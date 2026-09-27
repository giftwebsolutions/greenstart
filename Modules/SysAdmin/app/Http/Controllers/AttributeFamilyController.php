<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AttributeFamilyController extends Controller
{
    public function index(): View
    {
        return view('sysadmin::catalog.families.index');
    }

    public function create(): View
    {
        return view('sysadmin::catalog.families.create');
    }

    public function edit(int $id): View
    {
        return view('sysadmin::catalog.families.edit', compact('id'));
    }
}
