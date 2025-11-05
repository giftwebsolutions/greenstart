<?php 
namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        return view('sysadmin::dashboard.index');
    }
}