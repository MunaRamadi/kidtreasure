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
use App\Http\Controllers\Admin\WorkshopsController;
use App\Http\Controllers\Admin\ContactMessagesController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshops/{event}/register', [WorkshopController::class, 'showRegistrationForm'])->name('workshops.register.form');
Route::post('/workshops/{event}/register', [WorkshopController::class, 'register'])->name('workshops.register');

// Public Stories Routes (للجمهور)
Route::prefix('stories')->name('stories.')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('index');
    Route::get('/create', [StoryController::class, 'create'])->name('create');
    Route::post('/', [StoryController::class, 'store'])->name('store');
    Route::get('/{story}', [StoryController::class, 'show'])->name('show');
    Route::get('/stories/{story}', [StoriesController::class, 'show'])->name('stories.show');
});

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

// Contact Routes
Route::get('/contact-us', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'addItem'])->name('add');
    Route::patch('/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clearCart'])->name('clear');
    Route::get('/mini', [CartController::class, 'miniCart'])->name('mini');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/failed/{order}', [CheckoutController::class, 'failed'])->name('failed');
});

// User Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return app(UserDashboardController::class)->index();
    })->name('dashboard');
    
    // User Story Management Routes (للمستخدمين المسجلين)
    Route::prefix('my-stories')->name('my-stories.')->group(function () {
        Route::get('/', [StoryController::class, 'myStories'])->name('index');
        Route::get('/{story}/edit', [StoryController::class, 'edit'])->name('edit');
        Route::put('/{story}', [StoryController::class, 'update'])->name('update');
        Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
    });
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
    Route::prefix('products')->name('products.')->controller(ProductsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::post('/import', 'import')->name('import');
        Route::get('/export', 'export')->name('export');
        Route::post('/search', 'search')->name('search');
        Route::get('/{product}/duplicate', 'duplicate')->name('duplicate');
        Route::get('/{product}', 'show')->name('show');
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::put('/{product}', 'update')->name('update');
        Route::patch('/{product}', 'update')->name('patch');
        Route::delete('/{product}', 'destroy')->name('destroy');
        Route::patch('/{product}/toggle-status', 'toggleStatus')->name('toggle-status');
    });

    // Order Management
    Route::prefix('orders')->name('orders.')->controller(OrdersController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order}', 'show')->name('show');
        Route::patch('/{order}/status', 'updateStatus')->name('update-status');
        Route::patch('/{order}/payment-status', 'updatePaymentStatus')->name('update-payment-status');
    });

    // User Management
    Route::prefix('users')->name('users.')->controller(UsersController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::patch('/{user}/toggle-status', 'toggleStatus')->name('toggle-status');
    });

    // Admin Stories Management (إدارة القصص للمشرفين)
    Route::prefix('stories')->name('stories.')->controller(StoriesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/export', 'export')->name('export');
        Route::get('/analytics', 'analytics')->name('analytics');
        Route::post('/bulk-action', 'bulkAction')->name('bulk-action');
        Route::post('/{story}/quick-review', 'quickReview')->name('quick-review');
        Route::get('/create-test', 'createTestStory')->name('create-test');
        
        // Individual story management routes
        Route::get('/{story}', 'show')->name('show');
        Route::get('/{story}/edit', 'edit')->name('edit');
        Route::put('/{story}', 'update')->name('update');
        Route::patch('/{story}', 'update')->name('patch');
        Route::patch('/{story}/status', 'updateStatus')->name('update-status');
        Route::delete('/{story}', 'destroy')->name('destroy');
    });

    // Workshop Management
    Route::prefix('workshops')->name('workshops.')->controller(WorkshopsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{workshop}', 'show')->name('show');
        Route::get('/{workshop}/edit', 'edit')->name('edit');
        Route::put('/{workshop}', 'update')->name('update');
        Route::delete('/{workshop}', 'destroy')->name('destroy');
        Route::get('/{workshop}/registrations', 'registrations')->name('registrations');
        Route::patch('/registrations/{registration}/status', 'updateRegistrationStatus')->name('registrations.update-status');
    });

    // Contact Messages Management
    Route::prefix('contact-messages')->name('contact-messages.')->controller(ContactMessagesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{message}', 'show')->name('show');
        Route::patch('/{message}/mark-as-read', 'markAsRead')->name('mark-as-read');
        Route::patch('/{message}/mark-as-unread', 'markAsUnread')->name('mark-as-unread');
        Route::delete('/{message}', 'destroy')->name('destroy');
        Route::post('/bulk-mark-as-read', 'bulkMarkAsRead')->name('bulk-mark-as-read');
        Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Blog Management
    Route::prefix('blog')->name('blog.')->controller(AdminBlogController::class)->group(function () {
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
    Route::prefix('settings')->name('settings.')->controller(AdminController::class)->group(function () {
        Route::get('/', 'settingsIndex')->name('index');
    });
});

require __DIR__.'/auth.php';