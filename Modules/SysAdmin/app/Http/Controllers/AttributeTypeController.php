<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\SysAdmin\Interfaces\AttributeTypeInterface;
use Modules\SysAdmin\DataTables\AttributeTypeDataTable;
use Modules\SysAdmin\Requests\AttributeTypeFormRequest;

class AttributeTypeController extends Controller
{
    public function __construct(
        protected AttributeTypeInterface $typeRepository
    ) {}

    public function index(AttributeTypeDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.type.index');
    }

    public function create(): View
    {
        return view('sysadmin::catalog.type.create', [
            'statuses' => $this->typeRepository->getStatuses(),
        ]);
    }

    public function store(AttributeTypeFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->typeRepository->saveOrUpdate($validated);

        return redirect()
            ->route('sysadmin.catalog.attribute.type.index')
            ->with('success', 'Attribute type created successfully.');
    }

    public function show(int $id): View
    {
        return view('sysadmin::catalog.type.view', [
            'type'     => $this->typeRepository->find($id),
            'statuses' => $this->typeRepository->getStatuses(),
        ]);
    }

    public function edit(int $id): View
    {
        return view('sysadmin::catalog.type.edit', [
            'type'     => $this->typeRepository->find($id),
            'statuses' => $this->typeRepository->getStatuses(),
        ]);
    }

    public function update(AttributeTypeFormRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $this->typeRepository->saveOrUpdate($validated, $id);

        return redirect()
            ->route('sysadmin.catalog.attribute.type.index')
            ->with('success', 'Attribute type updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->typeRepository->delete($id);

        return redirect()
            ->route('sysadmin.catalog.attribute.type.index')
            ->with('success', 'Attribute type deleted successfully.');
    }
}
