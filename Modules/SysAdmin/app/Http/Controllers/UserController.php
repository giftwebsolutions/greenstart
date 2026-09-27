<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        return view('sysadmin::user.index');
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('sysadmin.user.index');
    }

    public function show(): RedirectResponse
    {
        return redirect()->route('sysadmin.user.index');
    }

    public function edit(): RedirectResponse
    {
        return redirect()->route('sysadmin.user.index');
    }
}
