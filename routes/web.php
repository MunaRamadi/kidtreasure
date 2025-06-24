<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\StoriesController;
use App\Http\Controllers\Admin\WorkshopManagementController;
use App\Http\Controllers\Admin\WorkshopsController;
use App\Http\Controllers\Admin\WorkshopEventsController;
use App\Http\Controllers\Admin\ContactMessagesController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshops/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show');
Route::get('/workshops/list', [WorkshopController::class, 'listAll'])->name('workshops.list');
Route::get('/workshops/{event}/register', [WorkshopController::class, 'showRegistrationForm'])->name('workshops.register.form');
Route::post('/workshops/{event}/register', [WorkshopController::class, 'register'])->name('workshops.register');
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/submit', [StoryController::class, 'create'])->name('stories.create');
Route::post('/stories/submit', [StoryController::class, 'store'])->name('stories.store');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact-us', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Workshop interest registration route (public-facing)
Route::post('/workshops/register-interest', [WorkshopController::class, 'registerInterest'])->name('workshops.register.interest');

// Cart Routes (تم التعديل هنا)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add'); // تم توحيد مسار الإضافة
Route::patch('/cart/{productId}', [CartController::class, 'update'])->name('cart.update'); // PATCH لتحديث الكمية، تم تغيير itemId إلى productId
Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove'); // DELETE للحذف، تم تغيير itemId إلى productId
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/mini', [CartController::class, 'miniCart'])->name('cart.mini');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/failed/{order}', [CheckoutController::class, 'failed'])->name('checkout.failed');

// Dashboard Route - Updated
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return app(UserDashboardController::class)->index();
    })->name('dashboard');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Main Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Product Management
    Route::controller(ProductsController::class)->prefix('products')->name('products.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::post('/import', 'import')->name('import');
        Route::get('/export', 'export')->name('export');
        Route::post('/search', 'search')->name('search');
        Route::get('/{product}/duplicate', 'duplicate')->name('duplicate');
        Route::get('/{product}', 'show')->name('show');
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::PATCH('/{product}', 'update')->name('update');
        Route::PUT('/{product}', 'update');
        Route::delete('/{product}', 'destroy')->name('destroy');
        Route::patch('/{product}/toggle-status', 'toggleStatus')->name('toggle-status');
    });

    // Order Management
    Route::controller(OrdersController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order}', 'show')->name('show');
        Route::patch('/{order}/status', 'updateStatus')->name('update-status');
        Route::patch('/{order}/payment-status', 'updatePaymentStatus')->name('update-payment-status');
    });

    // User Management
    Route::controller(UsersController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::patch('/{user}/toggle-status', 'toggleStatus')->name('toggle-status');
    });

    // Stories Management - UPDATED WITH MISSING ROUTES
    Route::controller(StoriesController::class)->prefix('stories')->name('stories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/export', 'export')->name('export');
        Route::get('/analytics', 'analytics')->name('analytics'); // ADDED MISSING ROUTE
        Route::post('/bulk-action', 'bulkAction')->name('bulk-action');
        Route::post('/{story}/quick-review', 'quickReview')->name('quick-review'); // ADDED MISSING ROUTE
        
        // Test route for development
        Route::get('/create-test', 'createTestStory')->name('create-test');
        
        // Individual story routes - using explicit route parameter names
        Route::get('/{story}', 'show')->name('show')->where('story', '[0-9]+');
        Route::get('/{story}/edit', 'edit')->name('edit')->where('story', '[0-9]+');
        Route::patch('/{story}', 'update')->name('update')->where('story', '[0-9]+');
        Route::put('/{story}', 'update')->name('update.put')->where('story', '[0-9]+');
        Route::patch('/{story}/status', 'updateStatus')->name('update-status')->where('story', '[0-9]+');
        Route::delete('/{story}', 'destroy')->name('destroy')->where('story', '[0-9]+');
    });
    
 // إدارة الورش (Workshop Templates)
Route::controller(WorkshopsController::class)->prefix('workshops')->name('workshops.')->group(function () {
    Route::get('/', 'indexWorkshops')->name('index');
    Route::get('/create', 'createWorkshop')->name('create');
    Route::post('/', 'storeWorkshop')->name('store');
    Route::get('/{workshop}', 'showWorkshop')->name('show');
    Route::get('/{workshop}/edit', 'editWorkshop')->name('edit');
    Route::put('/{workshop}', 'updateWorkshop')->name('update');
    Route::delete('/{workshop}', 'destroyWorkshop')->name('destroy');
    Route::get('/{workshop}/registrations', 'workshopRegistrations')->name('registrations');
});
    
    // إدارة فعاليات الورش (WorkshopEvents)
    Route::controller(WorkshopEventsController::class)->prefix('workshop-events')->name('workshop-events.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{workshop}', 'show')->name('show');
        Route::get('/{workshop}/edit', 'edit')->name('edit');
        Route::put('/{workshop}', 'update')->name('update');
        Route::delete('/{workshop}', 'destroy')->name('destroy');
        Route::get('/{workshop}/registrations', 'registrations')->name('registrations');
        Route::patch('/registrations/{registration}/status', 'updateRegistrationStatus')->name('registrations.update-status');
        Route::patch('/{workshop}/toggle-registration', 'toggleRegistrationStatus')->name('toggle-registration');
    });

    // Contact Messages Management
    Route::controller(ContactMessagesController::class)->prefix('contact-messages')->name('contact-messages.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{message}', 'show')->name('show');
        Route::patch('/{message}/mark-as-read', 'markAsRead')->name('mark-as-read');
        Route::patch('/{message}/mark-as-unread', 'markAsUnread')->name('mark-as-unread');
        Route::delete('/{message}', 'destroy')->name('destroy');
        Route::post('/bulk-mark-as-read', 'bulkMarkAsRead')->name('bulk-mark-as-read');
        Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Blog Management
    Route::controller(AdminBlogController::class)->prefix('blog')->name('blog.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{post}', 'show')->name('show');
        Route::get('/{post}/edit', 'edit')->name('edit');
        Route::put('/{post}', 'update')->name('update');
        Route::delete('/{post}', 'destroy')->name('destroy');
        Route::patch('/{post}/toggle-status', 'toggleStatus')->name('toggle-status');
    });

    // Settings Management
    Route::controller(AdminController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', 'settingsIndex')->name('index');
    });
});

require __DIR__.'/auth.php';