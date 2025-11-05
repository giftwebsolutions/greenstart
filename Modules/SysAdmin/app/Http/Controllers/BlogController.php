<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\DataTables\BlogDataTable;
use Modules\SysAdmin\Interfaces\BlogCategoryInterface;
use Modules\SysAdmin\Interfaces\BlogInterface;
use Modules\SysAdmin\Requests\BlogFormRequest;

class BlogController extends Controller
{
    public function __construct(
        protected BlogInterface $blogRepository,
        protected BlogCategoryInterface $categoryRepository
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::blog.create')->with([
            'parentCategory' => $this->categoryRepository->getParents(),
            'statuses' => $this->blogRepository->getStatus()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogFormRequest $request): RedirectResponse
    {
        try {
            $validatedData = $request->validated();
            $this->blogRepository->saveOrUpdate($validatedData);
            return redirect()->route('sysadmin.blog.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $blog = $this->blogRepository->findOrFail($id)->toArray();
            return view('sysadmin::blog.view')->with([
                'blog' => $blog
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = $this->blogRepository->findOrFail($id);
        return view('sysadmin::blog.edit')->with([
            'blog' => $blog,
            'parentCategory' => $this->categoryRepository->getParents(),
            'statuses' => $this->blogRepository->getStatus()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogFormRequest $request, $id): RedirectResponse
    {
        try {
            $validatedData = $request->validated();
            $this->blogRepository->saveOrUpdate($validatedData, $id);
            return redirect()->route('sysadmin.blog.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->blogRepository->delete($id);
        return redirect()->route('sysadmin.blog.index');
    }
}
