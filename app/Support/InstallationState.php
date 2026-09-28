<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class InstallationState
{
    public static function lockPath(): string
    {
        return storage_path('app/installed.json');
    }

    public static function pendingPath(): string
    {
        return storage_path('app/installing.json');
    }

    public static function isInstalled(): bool
    {
        if (app()->environment('testing')) {
            return (bool) config('app.installed_for_tests', false);
        }

        if (is_file(self::lockPath())) {
            return true;
        }

        // A failed installation must always remain retryable, even when its
        // migrations or administrator record were already created.
        if (is_file(self::pendingPath())) {
            return false;
        }

        try {
            if (! Schema::hasTable('users') || ! Schema::hasTable('product')) {
                return false;
            }

            // Backwards compatibility for installations created before the
            // lock file existed. Tables alone are not enough to call an
            // interrupted installation complete.
            if (! Schema::hasTable('roles') || ! Schema::hasTable('model_has_roles')) {
                return false;
            }

            return DB::table('users')
                ->join('model_has_roles', function ($join): void {
                    $join->on('model_has_roles.model_id', '=', 'users.id')
                        ->where('model_has_roles.model_type', '=', 'App\\Models\\User');
                })
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->whereIn('roles.name', ['super-admin', 'owner'])
                ->exists();
        } catch (Throwable) {
            return false;
        }
    }
}
