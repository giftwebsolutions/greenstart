<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;
use Throwable;

class InstallationState
{
    public static function lockPath(): string
    {
        return storage_path('app/installed.json');
    }

    public static function isInstalled(): bool
    {
        if (is_file(self::lockPath())) {
            return true;
        }

        try {
            return Schema::hasTable('users') && Schema::hasTable('product');
        } catch (Throwable) {
            return false;
        }
    }
}
