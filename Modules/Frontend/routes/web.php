<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\CmsController;
use Modules\Frontend\Http\Controllers\FrontendController;
use Modules\Frontend\Http\Controllers\BlogController;
use Modules\Frontend\Http\Controllers\ProductController;


Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/enquiry', [FrontendController::class, 'enquiry'])->name('enquiry');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/newarraival', [FrontendController::class, 'newarraival'])->name('newarraival');

Route::get('/cms/{slug}', [CmsController::class, 'show'])->name('cms.view');

Route::get('/blog', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blogs.show');



Route::get('/products', [ProductController::class, 'index'])
    ->name('frontend.products.index');

Route::get('/products/{slug}', [ProductController::class, 'show'])
    ->name('frontend.products.show');