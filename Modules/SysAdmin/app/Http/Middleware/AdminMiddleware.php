<?php

namespace Modules\SysAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in, redirect to SysAdmin login page
        if (! Auth::check()) {
            return redirect()->route('sysadmin.login.form')
                ->with('error', 'Please login to access the SysAdmin panel.');
        }

        // (Optional) Role check — only allow admin users
        // if (! Auth::user()->is_admin) {
        //     abort(403, 'You are not authorized to access the admin panel.');
        // }

        return $next($request);
    }
}
