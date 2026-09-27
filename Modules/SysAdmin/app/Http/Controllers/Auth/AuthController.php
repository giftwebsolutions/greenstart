<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SysAdmin\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function signOut(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sysadmin.login.form')->with('success', 'Successfully signed out.');
    }
}
