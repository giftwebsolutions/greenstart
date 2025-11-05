<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\FrontendController;


Route::prefix('frontend')
    ->group(function () {
        // Public frontend routes can go here
        Route::get('/', [FrontendController::class, 'index'])->name('index');
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('frontends', FrontendController::class)->names('frontend');
});
