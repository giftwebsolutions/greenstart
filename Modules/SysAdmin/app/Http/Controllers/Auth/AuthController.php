<?php

namespace Modules\SysAdmin\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\SysAdmin\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        return view('sysadmin::auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }

        return redirect()->route('sysadmin.login.form')->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('sysadmin::auth.register');
    }

    public function submitRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect()->route('sysadmin.index')->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('sysadmin::dashboard');
        }

        return redirect()->route('sysadmin.login.form')->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('sysadmin.login.form')->withSuccess('Suscessfully logged out');
    }
}
