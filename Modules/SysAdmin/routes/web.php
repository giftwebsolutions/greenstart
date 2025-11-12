<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Modules\SysAdmin\Http\Controllers\DashboardController;
use Modules\SysAdmin\Http\Controllers\Auth\AuthController;
use Modules\SysAdmin\Http\Controllers\Auth\ForgotPasswordController;

// ============================================================================
// 💡 Public SysAdmin Authentication Routes
// ============================================================================
// These routes are accessible without authentication.
// URL Prefix: /sysadmin
// Route Names: sysadmin.login.*, sysadmin.register.*, sysadmin.forget-password.*, etc.
// ============================================================================
Route::prefix('sysadmin')->as('sysadmin.')->group(function () {
    // ---------------------------
    // Authentication
    // ---------------------------
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'index')->name('login.form');
        Route::post('login', 'login')->name('login.attempt');

        Route::get('registration', 'registration')->name('register');
        Route::post('registration', 'submitRegistration')->name('register.submit');

        Route::post('signout', 'signOut')->name('logout');
    });

    // ---------------------------
    // Forgot / Reset Password
    // ---------------------------
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'showLinkRequestForm')->name('forget-password');
        Route::post('forget-password', 'sendResetLinkEmail')->name('forget-password.post');
        Route::get('reset-password/{token}', 'showResetForm')->name('reset-password');
        Route::post('reset-password', 'resetPassword')->name('reset-password.post');
    });

    // ---------------------------
    // Cache & Maintenance Tools (for dev/admin)
    // ---------------------------
    Route::prefix('tools')->as('tools.')->group(function () {
        Route::get('/config-clear', fn() => Artisan::call('config:clear'))->name('config-clear');
        Route::get('/config-cache', fn() => Artisan::call('config:cache'))->name('config-cache');
        Route::get('/cache-clear', fn() => Artisan::call('cache:clear'))->name('cache-clear');
        Route::get('/view-clear', fn() => Artisan::call('view:clear'))->name('view-clear');
        Route::get('/optimize-clear', fn() => Artisan::call('optimize:clear'))->name('optimize-clear');
    });
});


// ============================================================================
// 🔒 Protected SysAdmin Routes (Requires Middleware)
// ============================================================================
// Only authenticated SysAdmin users can access these routes.
// Middleware: web + sysadmin (custom AdminMiddleware)
// URL Prefix: /sysadmin
// ============================================================================
Route::prefix('sysadmin')
    ->as('sysadmin.')
    ->middleware(['web', 'sysadmin'])
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // ===============================
        // 👤 User Management
        // ===============================
        Route::prefix('user')->as('user.')->controller(Modules\SysAdmin\Http\Controllers\UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('view/{id}', 'show')->name('view');
            Route::get('create', 'create')->name('create');
            Route::post('create', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::patch('update/{id}', 'update')->name('update');
            Route::get('destroy/{id}', 'destroy')->name('delete');
        });

        // ===============================
        // 📄 CMS (Pages + Blocks)
        // ===============================
        Route::prefix('cms')->as('cms.')->group(function () {
            Route::controller(Modules\SysAdmin\Http\Controllers\PageController::class)->prefix('page')->as('page.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(Modules\SysAdmin\Http\Controllers\BlockController::class)->prefix('block')->as('block.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });
        });

        Route::prefix('catalog')->as('catalog.')->group(function () {
            Route::controller(Modules\SysAdmin\Http\Controllers\AttributeController::class)->prefix('attribute')->as('attribute.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(Modules\SysAdmin\Http\Controllers\AttributeGroupController::class)->prefix('attribute-group')->as('attribute.group.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(Modules\SysAdmin\Http\Controllers\ProductController::class)->prefix('product')->as('product.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });
        });

        // ===============================
        // 📰 Blog Management
        // ===============================
        Route::prefix('blog')->as('blog.')->group(function () {
            Route::controller(Modules\SysAdmin\Http\Controllers\BlogController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(Modules\SysAdmin\Http\Controllers\BlogCategoryController::class)->prefix('category')->as('category.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(Modules\SysAdmin\Http\Controllers\TagController::class)->prefix('tags')->as('tags.')->group(function () {
                Route::get('search', 'search')->name('search');
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });
        });

        // ===============================
        // ⚙️ Settings
        // ===============================
        Route::prefix('settings')->as('settings.')->controller(Modules\SysAdmin\Http\Controllers\SettingsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('ajax-form', 'ajaxForm')->name('ajax-form');
            Route::post('ajax-store', 'ajaxStore')->name('ajax-store');
            Route::get('create', 'create')->name('create');
            Route::get('ajax-view/{id}', 'ajaxShow')->name('ajax-view');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::patch('update/{id}', 'update')->name('update');
            Route::get('destroy/{id}', 'destroy')->name('delete');
        });

        // ===============================
        // 🖼 Media (Gallery + Slider + Code Editor)
        // ===============================
        Route::prefix('media')->as('media.')->group(function () {
            Route::controller(Modules\SysAdmin\Http\Controllers\GalleryController::class)->prefix('gallery')->as('gallery.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
                Route::post('add-item/{id}/{created_at}', 'uploadItem')->name('item.upload');
                Route::delete('remove-item/{id}', 'removeItem')->name('item.remove');
            });

            Route::controller(Modules\SysAdmin\Http\Controllers\SliderController::class)->prefix('slider')->as('slider.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('delete');
            });

            // Code Editor
            Route::controller(Modules\SysAdmin\Http\Controllers\CodeEditorController::class)->prefix('code-editor')->as('code.')->group(function () {
                Route::get('robot', 'index')->name('robot');
                Route::post('robot/save', 'store')->name('robot-save');
            });
        });
    });


Route::middleware(['web', 'sysadmin'])->prefix('sysadmin/tools')->as('sysadmin.tools.')->group(function () {

    Route::get('/config-clear', function () {
        Artisan::call('config:clear');
        return ' Config cache cleared successfully!';
    })->name('config-clear');

    Route::get('/config-cache', function () {
        Artisan::call('config:cache');
        return ' Configuration cached successfully!';
    })->name('config-cache');

    Route::get('/cache-clear', function () {
        Artisan::call('cache:clear');
        return ' Application cache cleared successfully!';
    })->name('cache-clear');

    Route::get('/view-clear', function () {
        Artisan::call('view:clear');
        return ' Compiled views cleared successfully!';
    })->name('view-clear');

    Route::get('/optimize-clear', function () {
        Artisan::call('optimize:clear');
        return ' Optimized files cleared successfully!';
    })->name('optimize-clear');
});
