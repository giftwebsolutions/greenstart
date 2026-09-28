<?php

use Illuminate\Support\Facades\Route;
use Modules\SysAdmin\Http\Controllers\AttributeController;
use Modules\SysAdmin\Http\Controllers\AttributeFamilyController;
use Modules\SysAdmin\Http\Controllers\AttributeGroupController;
use Modules\SysAdmin\Http\Controllers\AttributeTypeController;
use Modules\SysAdmin\Http\Controllers\Auth\AuthController;
use Modules\SysAdmin\Http\Controllers\Auth\ForgotPasswordController;
use Modules\SysAdmin\Http\Controllers\BlockController;
use Modules\SysAdmin\Http\Controllers\BlogCategoryController;
use Modules\SysAdmin\Http\Controllers\BlogController;
use Modules\SysAdmin\Http\Controllers\CodeEditorController;
use Modules\SysAdmin\Http\Controllers\DashboardController;
use Modules\SysAdmin\Http\Controllers\EnquiryController;
use Modules\SysAdmin\Http\Controllers\GalleryController;
use Modules\SysAdmin\Http\Controllers\PageController;
use Modules\SysAdmin\Http\Controllers\ProductCategoryController;
use Modules\SysAdmin\Http\Controllers\ProductController;
use Modules\SysAdmin\Http\Controllers\RoleController;
use Modules\SysAdmin\Http\Controllers\SettingsController;
use Modules\SysAdmin\Http\Controllers\SitemapController;
use Modules\SysAdmin\Http\Controllers\SliderController;
use Modules\SysAdmin\Http\Controllers\TagController;
use Modules\SysAdmin\Http\Controllers\TestimonialController;
use Modules\SysAdmin\Http\Controllers\UserController;
use Modules\SysAdmin\Livewire\Auth\Login;

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
    Route::get('login', Login::class)->name('login.form');
    Route::post('signout', [AuthController::class, 'signOut'])->name('logout');

    // ---------------------------
    // Forgot / Reset Password
    // ---------------------------
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'showLinkRequestForm')->name('forget-password');
        Route::post('forget-password', 'sendResetLinkEmail')->name('forget-password.post');
        Route::get('reset-password/{token}', 'showResetForm')->name('reset-password');
        Route::post('reset-password', 'resetPassword')->name('reset-password.post');
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

        Route::view('tools', 'sysadmin::tools.index')->name('tools.index');

        // ===============================
        // 🔑 Role Management
        // ===============================
        Route::prefix('roles')->as('roles.')->controller(RoleController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('view/{id}', 'show')->name('view');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
        });

        // ===============================
        // 👤 User Management
        // ===============================
        Route::prefix('user')->as('user.')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('view/{id}', 'show')->name('view');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
        });

        Route::prefix('slider')
            ->as('slider.')
            ->controller(SliderController::class)
            ->group(function () {

                // List
                Route::get('/', 'index')->name('index');

                // Create
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');

                // View
                Route::get('/view/{id}', 'show')->name('view');

                // Edit
                Route::get('/edit/{id}', 'edit')->name('edit');

                // Update
                Route::patch('/update/{id}', 'update')->name('update');

                // Delete
                Route::delete('/delete/{id}', 'destroy')->name('delete');
                Route::post('/item-delete/{id}', 'itemDelete')->name('item-delete');
                Route::post('/item-save/{id}', 'itemCreate')->name('item-create');
            });

        Route::prefix('enquiry')
            ->as('enquiry.')
            ->controller(EnquiryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('appointments', 'appointments')->name('appointments');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });

        // ===============================
        // 📄 CMS (Pages + Blocks)
        // ===============================
        Route::prefix('cms')->as('cms.')->group(function () {
            Route::controller(PageController::class)->prefix('page')->as('page.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(BlockController::class)->prefix('block')->as('block.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });
        });

        Route::prefix('catalog')->as('catalog.')->group(function () {
            Route::controller(AttributeFamilyController::class)->prefix('attribute-family')->as('attribute.family.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('edit/{id}', 'edit')->name('edit');
            });

            Route::controller(AttributeController::class)->prefix('attribute')->as('attribute.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(AttributeGroupController::class)->prefix('group')->as('attribute.group.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
            });

            Route::controller(AttributeTypeController::class)->prefix('attribute-type')->as('attribute.type.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(ProductController::class)->prefix('product')->as('product.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');

                Route::post('load-family-attributes', 'loadFamilyAttributes')
                    ->name('load-attributes');

                Route::get('{product}/attributes', 'attributes')
                    ->name('attributes');

                Route::post('{product}/attributes', 'storeAttributes')
                    ->name('attributes.store');

                Route::get(
                    'sub-categories',
                    'subCategories'
                )->name('subcategories');
            });

            Route::controller(ProductCategoryController::class)->prefix('productcategory')->as('productcategory.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });
        });

        // Testimonial

        Route::prefix('testimonial')->as('testimonial.')->group(function () {
            Route::controller(TestimonialController::class)->group(function () {
                Route::get('/', 'index')->name('index');             // List all testimonials
                Route::get('view/{id}', 'show')->name('view');       // View a single testimonial
                Route::get('create', 'create')->name('create');      // Form to create
                Route::post('create', 'store')->name('store');       // Save new testimonial
                Route::get('edit/{id}', 'edit')->name('edit');       // Form to edit
                Route::patch('update/{id}', 'update')->name('update'); // Update testimonial
                Route::delete('destroy/{id}', 'destroy')->name('delete'); // Delete testimonial
            });
        });

        // ===============================
        // 📰 Blog Management
        // ===============================
        Route::prefix('blog')->as('blog.')->group(function () {
            Route::controller(BlogController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(BlogCategoryController::class)->prefix('category')->as('category.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });

            Route::controller(TagController::class)->prefix('tags')->as('tags.')->group(function () {
                Route::get('search', 'search')->name('search');
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
            });
        });

        // ===============================
        // ⚙️ Settings
        // ===============================
        Route::prefix('settings')->as('settings.')->controller(SettingsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
        });

        // ===============================
        // 🖼 Media (Gallery + Slider + Code Editor)
        // ===============================
        Route::prefix('media')->as('media.')->group(function () {
            Route::controller(GalleryController::class)->prefix('gallery')->as('gallery.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('view/{id}', 'show')->name('view');
                Route::get('create', 'create')->name('create');
                Route::post('create', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::patch('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('delete');
                Route::post('add-item/{id}/{created_at}', 'uploadItem')->name('item.upload');
                Route::delete('remove-item/{id}', 'removeItem')->name('item.remove');
            });

            // Sitemap
            Route::controller(SitemapController::class)->prefix('sitemap')->as('sitemap.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('generate', 'generate')->name('generate');
            });

            // Code Editor
            Route::controller(CodeEditorController::class)->prefix('code-editor')->as('code.')->group(function () {
                Route::get('robot', 'index')->name('robot');
                Route::post('robot/save', 'store')->name('robot-save');
            });
        });
    });
