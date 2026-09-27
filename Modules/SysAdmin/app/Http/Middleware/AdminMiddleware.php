<?php

namespace Modules\SysAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SysAdmin\Support\PermissionCatalog;

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

        $user = Auth::user();
        if ($user->is_active === false) {
            Auth::logout();

            return redirect()->route('sysadmin.login.form')->with('error', 'This administrator account is inactive.');
        }

        $permission = PermissionCatalog::forRoute($request->route()?->getName());
        if ($permission && $user->cannot($permission)) {
            abort(403, 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
