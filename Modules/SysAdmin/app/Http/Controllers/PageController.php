<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\SysAdmin\DataTables\PageDataTable;
use Modules\SysAdmin\Interfaces\PageInterface;
use Modules\SysAdmin\Requests\PageFormRequest;
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    public function __construct(
        protected PageInterface $pageRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PageDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::page.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::page.create')->with([
            'parents' => $this->pageRepository->getParents(),
            'statuses' => $this->pageRepository->getStatus()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->pageRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.cms.page.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $page = $this->pageRepository->with(['parent'])->findOrFail($id)->toArray();
            return view('sysadmin::page.view')->with([
                'page' => $page,
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
        $page = $this->pageRepository->findOrFail($id);
        return view('sysadmin::page.edit', compact('page'))->with([
            'parents' => $this->pageRepository->getParents(),
            'statuses' => $this->pageRepository->getStatus()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageFormRequest $request, $id): RedirectResponse
    {
        try {
            //dd($request);
            $validatedData = $request->validated();
            $page = $this->pageRepository->saveOrUpdate($validatedData, $id);
            return redirect()->route('sysadmin.cms.page.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->pageRepository->delete($id);
        return redirect()->route('sysadmin.cms.page.index');
    }
}
