<?php

namespace Modules\SysAdmin\Http\Controllers\Auth;

use Modules\SysAdmin\Http\Controllers\Controller;
use Modules\SysAdmin\Http\Traits\AuthenticatesUsers;
//use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/sys_admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // activity('login') // Define the activity name (e.g., 'login')
        //     ->causedBy($user) // Identify the user causing the activity
        //     ->withProperties(['ip' => $request->ip()]) // Add additional properties (e.g., user IP)
        //     ->log('USER Login'); // Log the specific message
    }
}
