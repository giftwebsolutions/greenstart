<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\DataTables\RoleDataTable;
use Modules\SysAdmin\Interfaces\RoleInterface;
use Modules\SysAdmin\Requests\RoleFormRequest;

class RoleController extends Controller
{
    public function __construct(
        protected RoleInterface $roleRepository
    ) {}

    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::roles.index');
    }

    public function create()
    {
        return view('sysadmin::roles.create');
    }

    public function store(RoleFormRequest $request): RedirectResponse
    {
        $this->roleRepository->saveOrUpdate($request->validated());
        return redirect()->route('sysadmin.roles.index')->with('success', 'Role created successfully.');
    }

    public function show($id)
    {
        $role = $this->roleRepository->findOrFail($id)->toArray();
        return view('sysadmin::roles.view', compact('role'));
    }

    public function edit($id)
    {
        $role = $this->roleRepository->findOrFail($id);
        return view('sysadmin::roles.edit', compact('role'));
    }

    public function update(RoleFormRequest $request, $id): RedirectResponse
    {
        $this->roleRepository->saveOrUpdate($request->validated(), $id);
        return redirect()->route('sysadmin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->roleRepository->delete($id);
        return redirect()->route('sysadmin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
