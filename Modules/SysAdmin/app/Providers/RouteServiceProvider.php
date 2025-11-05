<?php

namespace Modules\SysAdmin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\SysAdmin\Http\Middleware\AdminMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'SysAdmin';

    /**
     * Boot the route service provider.
     */
    public function boot(): void
    {
        // 1. Register our custom middleware alias so we can just say 'sysadmin' in route groups
        $this->app['router']->aliasMiddleware('sysadmin', AdminMiddleware::class);

        // If the parent::boot() in your Laravel version is required for implicit bindings etc.,
        // keep it. In newer Laravel this may be optional.
        parent::boot();
    }

    /**
     * Define all module routes.
     */
    public function map(): void
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Web routes for this module.
     *
     * These routes get:
     * - web session / CSRF stack
     * - auth / verified
     * - sysadmin (custom middleware)
     * They are all prefixed with /sysadmin and route names start with sysadmin.
     */

    protected function mapWebRoutes(): void
    {
        Route::middleware(['web'])
            ->group(module_path($this->name, 'routes/web.php'));
    }

    /**
     * API routes for this module.
     *
     * Optional: If you want your API also behind sysadmin,
     * you can include 'auth:sanctum' or 'sysadmin' here too.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware(['api'])
            ->prefix('api/sysadmin')
            ->as('sysadmin.api.')
            ->group(module_path($this->name, 'routes/api.php'));
    }
}
