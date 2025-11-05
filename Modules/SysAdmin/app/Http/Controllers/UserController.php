<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SysAdmin\Interfaces\UserInterface;
use Modules\SysAdmin\DataTables\UserDataTable;
use Modules\SysAdmin\Requests\UserFormRequest;

class UserController extends Controller
{

    public function __construct(
        protected UserInterface $userRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('sysadmin::user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $this->userRepository->create($validatedData);
        return redirect()->route('sysadmin.user.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $user = $this->userRepository->findOrFail($id)->toArray();
        return view('sysadmin::user.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = $this->userRepository->findOrFail($id);

        return view('sysadmin::user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $user = $this->userRepository->update($validatedData, $id);
        return redirect()->route('sysadmin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $this->userRepository->delete($id);
        return redirect()->route('sysadmin.user.index');
    }
}
