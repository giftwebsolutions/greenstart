<?php

namespace Modules\SysAdmin\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\SysAdmin\Interfaces\AttributeInterface;
use Modules\SysAdmin\DataTables\AttributeDataTable;
use Modules\SysAdmin\Requests\AttributeFormRequest;

class AttributeController extends Controller
{

    public function __construct(
        protected AttributeInterface $attributeRepository
    ) {}

    public function index(AttributeDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.attribute.index');
    }

    public function create()
    {
        return view('sysadmin::catalog.attribute.create')->with([
            'groups' => $this->attributeRepository->getAttributeSets(),
            'types' => $this->attributeRepository->getAttributeTypes(),
            'statuses' => $this->attributeRepository->getStatus()
        ]);
    }

    public function store(AttributeFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->attributeRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.catalog.attribute.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $page = $this->attributeRepository->with(['parent'])->findOrFail($id)->toArray();
            return view('sysadmin::catalog.attribute.view')->with([
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
        $page = $this->attributeRepository->findOrFail($id);
        return view('sysadmin::catalog.attribute.edit', compact('page'))->with([
            'parents' => $this->attributeRepository->getParents(),
            'attributeTypes' => $this->attributeRepository->getAttributeTypes(),
            'statuses' => $this->attributeRepository->getStatus()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeFormRequest $request, $id): RedirectResponse
    {
        try {
            //dd($request);
            $validatedData = $request->validated();
            $page = $this->attributeRepository->saveOrUpdate($validatedData, $id);
            return redirect()->route('sysadmin.catalog.attribute.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->attributeRepository->delete($id);
        return redirect()->route('sysadmin.catalog.attribute.index');
    }
}
