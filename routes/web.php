<?php

use App\Support\InstallationState;
use Illuminate\Support\Facades\Route;

Route::get('/install', function () {
    if (InstallationState::isInstalled()) {
        return redirect()->route('sysadmin.login.form');
    }

    return view('installer.index');
})->name('install');
