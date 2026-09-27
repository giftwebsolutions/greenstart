<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function index()
    {
        return view('sysadmin::roles.index');
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('sysadmin.roles.index');
    }

    public function show(): RedirectResponse
    {
        return redirect()->route('sysadmin.roles.index');
    }

    public function edit(): RedirectResponse
    {
        return redirect()->route('sysadmin.roles.index');
    }
}
