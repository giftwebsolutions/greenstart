<?php

use Illuminate\Support\Facades\Route;
use Modules\SysAdmin\Http\Controllers\SysAdminController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('sysadmins', SysAdminController::class)->names('sysadmin');
});
