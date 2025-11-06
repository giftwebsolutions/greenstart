<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\CmsController;
use Modules\Frontend\Http\Controllers\FrontendController;


Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/enquiry', [FrontendController::class, 'enquiry'])->name('enquiry');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::get('/cms/{slug}', [CmsController::class, 'show'])->name('cms.view');

Route::get('/blog', [\Modules\Frontend\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [\Modules\Frontend\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
