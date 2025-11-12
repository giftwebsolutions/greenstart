<?php

namespace Modules\SysAdmin\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\DataTables\AttributeGroupDataTable;
use Modules\SysAdmin\Interfaces\AttributeGroupInterface;
use Modules\SysAdmin\Requests\AttributeGroupFormRequest;
use Illuminate\Support\Str;

class AttributeGroupController extends Controller
{

    public function __construct(
        protected AttributeGroupInterface $groupRepository
    ) {}

    public function index(AttributeGroupDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::catalog.groups.index');
    }

    public function create()
    {
        return view('sysadmin::catalog.groups.create')->with(
            ['statuses' => $this->groupRepository->getStatuses()]
        );
    }

    public function store(AttributeGroupFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->groupRepository->saveOrUpdate($validatedData);
        return redirect()->route('sysadmin.catalog.attribute.group.index');
    }

    public function edit(int $id)
    {
        return view('sysadmin::catalog.groups.edit', [
            'group'    => $this->groupRepository->find($id),
            'statuses' => $this->groupRepository->getStatuses(),
        ]);
    }

    public function update(AttributeGroupFormRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $this->groupRepository->saveOrUpdate($data, $id);
        return redirect()->route('sysadmin.catalog.attribute.group.index')
            ->with('success', 'Attribute group updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->groupRepository->delete($id);
        return redirect()->route('sysadmin.catalog.attribute.group.index')
            ->with('success', 'Attribute group deleted successfully.');
    }
}
