<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\DataTables\BlockDataTable;
use Modules\SysAdmin\Interfaces\BlockInterface;
use Modules\SysAdmin\Requests\BlockFormRequest;
use Illuminate\Validation\ValidationException;

class BlockController extends Controller
{
    public function __construct(
        protected BlockInterface $blockRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BlockDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::blocks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlockFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->blockRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.cms.block.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $page = $this->blockRepository->findOrFail($id)->toArray();
        return view('sysadmin::block.view')->with([
            'page' => $page,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $block = $this->blockRepository->findOrFail($id);
        return view('sysadmin::blocks.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlockFormRequest $request, $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $page = $this->blockRepository->saveOrUpdate($validatedData, $id);
        return redirect()->route('sysadmin.cms.block.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->blockRepository->delete($id);
        return redirect()->route('sysadmin.cms.block.index');
    }
}
