<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return view('sysadmin::settings.index');
    }
}
