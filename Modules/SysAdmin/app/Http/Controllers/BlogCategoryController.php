<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\DataTables\BlogCategoryDataTable;
use Modules\SysAdmin\Interfaces\BlogCategoryInterface;
use Modules\SysAdmin\Requests\BlogCategoryFormRequest;

class BlogCategoryController extends Controller
{
    public function __construct(
        protected BlogCategoryInterface $categoryRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::blog.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::blog.category.create')->with([
            'parents' => $this->categoryRepository->getParents(),
            'statuses' => $this->categoryRepository->getStatus()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryFormRequest $request)
    {
        $validatedData = $request->validated();
        $this->categoryRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.blog.category.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $category = $this->categoryRepository->with(['parent'])->findOrFail($id)->toArray();
        return view('sysadmin::blog.category.view')->with([
            'page' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        //dd($this->categoryRepository->getParents());
        return view('sysadmin::blog.category.edit')->with([
            'category' => $category,
            'parents' => $this->categoryRepository->getParents(),
            'statuses' => $this->categoryRepository->getStatus()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryFormRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
        //dd($validatedData);
            $this->categoryRepository->saveOrUpdate($validatedData, $id);
            return redirect()->route('sysadmin.blog.category.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->categoryRepository->delete($id);
        return redirect()->route('sysadmin.blog.category.index');
    }
}
