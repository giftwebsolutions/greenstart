<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\CmsController;
use Modules\Frontend\Http\Controllers\FrontendController;
use Modules\Frontend\Http\Controllers\BlogController;
use Modules\Frontend\Http\Controllers\ProductController;
use Modules\Frontend\Http\Controllers\ShopController;
use Modules\Frontend\Http\Controllers\ErrorController;


Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');

Route::get('/enquiry', [FrontendController::class, 'enquiry'])->name('frontend.enquiry');

Route::post('enquiry/store', [FrontendController::class, 'storeEnquiry'])->name('frontend.enquiry.store');

Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');

Route::get('/cms/{slug}', [CmsController::class, 'show'])->name('frontend.cms.view');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('frontend.blog.index');
Route::get('/blog/search', [BlogController::class, 'search'])->name('frontend.blog.search');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('frontend.blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('frontend.blog.show');


Route::prefix('shop')->group(function () {

    // ── Listing routes → ShopController ──────────────────────────────

    // Main shop / all products
    Route::get('/', [ShopController::class, 'index'])
        ->name('frontend.shop.index');

    // Products by category slug
    Route::get('/category/{slug}', [ShopController::class, 'category'])
        ->name('frontend.shop.category');

    // New arrivals
    Route::get('/new-arrivals', [ShopController::class, 'newArrivals'])
        ->name('frontend.shop.new-arrivals');

    // Search
    Route::get('/search', [ShopController::class, 'search'])
        ->name('frontend.shop.search');

    // ── Product detail → ProductController ───────────────────────────

    Route::get('/product/{slug}', [ProductController::class, 'show'])
        ->name('frontend.shop.product.show');

    // ── Legacy URL redirects ──────────────────────────────────────────
    Route::redirect('/products',    '/shop',           301)->name('frontend.shop.products.index');
    Route::redirect('/newarraival', '/shop/new-arrivals', 301)->name('frontend.shop.newarraival');
    Route::redirect('/categories',  '/shop',           301)->name('frontend.shop.categories');
});


Route::fallback([ErrorController::class, 'notFound']);
