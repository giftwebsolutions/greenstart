<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\CmsController;
use Modules\Frontend\Http\Controllers\FrontendController;
use Modules\Frontend\Http\Controllers\BlogController;
use Modules\Frontend\Http\Controllers\ProductController;
use Modules\Frontend\Http\Controllers\ErrorController;


Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/enquiry', [FrontendController::class, 'enquiry'])->name('enquiry');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::get('/cms/{slug}', [CmsController::class, 'show'])->name('cms.view');

// Blog home / list
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

// Search
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');

// List by category (by slug)
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

// Single blog (by slug)
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');



Route::prefix('shop')->group(function () {

    Route::get('/newarraival', [ProductController::class, 'newarraival'])
        ->name('frontend.shop.newarraival');

    Route::get('/categories', [ProductController::class, 'categories'])
        ->name('frontend.shop.categories');

    Route::get('/products', [ProductController::class, 'index'])
        ->name('frontend.shop.products.index');

    Route::get('/category/{slug}', [ProductController::class, 'category'])
        ->name('frontend.shop.category');

    Route::get('/search', [ProductController::class, 'search'])
        ->name('frontend.shop.search');

    Route::get('/product/{slug}', [ProductController::class, 'show'])
        ->name('frontend.shop.product.show');
});


Route::fallback([ErrorController::class, 'notFound']);