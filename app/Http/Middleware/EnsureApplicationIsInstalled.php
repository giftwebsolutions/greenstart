<?php

namespace App\Http\Middleware;

use App\Support\InstallationState;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApplicationIsInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('install', 'install/*', 'livewire/*', 'up')) {
            return $next($request);
        }

        if (! InstallationState::isInstalled()) {
            return redirect()->route('install');
        }

        return $next($request);
    }
}
