<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WorkshopController; // For public workshops
use App\Http\Controllers\StoryController; // For public and user-managed stories
use App\Http\Controllers\BlogController; // For public blog
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\UsersController; // تم تضمينها بالفعل
use App\Http\Controllers\Admin\StoriesController; // For admin stories management
use App\Http\Controllers\Admin\WorkshopsController; // For admin workshop templates management
use App\Http\Controllers\Admin\WorkshopEventsController; // For admin workshop events management
use App\Http\Controllers\Admin\ContactMessagesController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController; // For admin blog
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\UserSecurityController;
use Illuminate\Support\Facades\Route;

// Language Switching Route
Route::get('/lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

// Public Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Public Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Public Workshop Routes
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshops/list', [WorkshopController::class, 'listAll'])->name('workshops.list');
Route::get('/workshops/{event}/register', [WorkshopController::class, 'showRegistrationForm'])->name('workshops.register.form');
Route::post('/workshops/{event}/register', [WorkshopController::class, 'register'])->name('workshops.register');
Route::get('/workshops/event/{event}', [WorkshopController::class, 'showEvent'])->name('workshops.event.show');
Route::get('/workshops/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show');
Route::post('/workshops/register-interest', [WorkshopController::class, 'registerInterest'])->name('workshops.register.interest');

// Workshop routes
Route::prefix('workshops')->name('workshops.')->group(function () {
    Route::get('/', [WorkshopController::class, 'index'])->name('index');
    Route::get('/workshop/{workshop}', [WorkshopController::class, 'show'])->name('show');
    Route::get('/event/{event}', [WorkshopController::class, 'showEvent'])->name('event.show');
    Route::get('/event/{event}/register', [WorkshopController::class, 'registerForm'])->name('register.form');
    Route::post('/event/{event}/register', [WorkshopController::class, 'register'])->name('register');
    Route::get('/registrations', [WorkshopController::class, 'registrations'])->name('registrations');
    Route::post('/interest', [WorkshopController::class, 'registerInterest'])->name('interest');
});

// Public Stories Routes (للجمهور)
Route::prefix('stories')->name('stories.')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('index');
    Route::get('/create', [StoryController::class, 'create'])->name('create');
    Route::post('/', [StoryController::class, 'store'])->name('store');
    Route::get('/{story}', [StoryController::class, 'show'])->name('show');
    // Removed redundant Route::get('/stories/{story}', [StoriesController::class, 'show'])->name('stories.show');
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
    Route::patch('/{itemId}', [CartController::class, 'update'])->name('update');
    Route::delete('/{itemId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clearCart'])->name('clear');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply_coupon');
    Route::get('/mini', [CartController::class, 'miniCart'])->name('mini');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/shipping', [CheckoutController::class, 'shipping'])->name('shipping');
    Route::post('/shipping', [CheckoutController::class, 'storeShipping'])->name('shipping.store');
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/failed/{order}', [CheckoutController::class, 'failed'])->name('failed');
    Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('payment');
});

// User Dashboard & Profile Routes (requires authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return app(UserDashboardController::class)->index();
    })->name('user.dashboard');

    // User Story Management Routes (للمستخدمين المسجلين)
    Route::prefix('my-stories')->name('user.my-stories.')->group(function () {
        Route::get('/', [StoryController::class, 'myStories'])->name('index');
        Route::get('/{story}/edit', [StoryController::class, 'edit'])->name('edit');
        Route::put('/{story}', [StoryController::class, 'update'])->name('update');
        Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Panel Routes (requires authentication and admin role)
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
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::patch('/{user}/toggle-status', 'toggleStatus')->name('toggle-status');
        // إضافة مسار لمعالجة طلبات إعادة تعيين كلمة المرور
        Route::patch('password-reset-requests/{passwordResetRequest}/resolve', 'resolvePasswordResetRequest')->name('password-reset-requests.resolve');
    });

    // Admin Stories Management
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
        Route::get('/', 'indexWorkshops')->name('index');
        Route::get('/create', 'createWorkshop')->name('create');
        Route::post('/', 'storeWorkshop')->name('store');
        Route::get('/{workshop}/registrations', 'registrationsWorkshop')->name('registrations');
        Route::patch('/registrations/{registration}/status', 'updateRegistrationStatusWorkshop')->name('registrations.update-status');
        Route::patch('/{workshop}/toggle-registration', 'toggleRegistrationStatusWorkshop')->name('toggle-registration');
        Route::get('/{workshop}', 'showWorkshop')->name('show');
        Route::get('/{workshop}/edit', 'editWorkshop')->name('edit');
        Route::put('/{workshop}', 'updateWorkshop')->name('update');
        Route::delete('/{workshop}', 'destroyWorkshop')->name('destroy');
        Route::post('/{workshop}/remove-image', 'removeImage')->name('remove-image');
    });

    // Workshop Events Management
    Route::prefix('workshop-events')->name('workshop-events.')->controller(WorkshopEventsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{event}', 'show')->name('show');
        Route::get('/{event}/edit', 'edit')->name('edit');
        Route::put('/{event}', 'update')->name('update');
        Route::delete('/{event}', 'destroy')->name('destroy');
        Route::get('/{event}/registrations', 'viewRegistrations')->name('registrations');
        Route::patch('/{event}/toggle-registration', 'toggleRegistration')->name('toggle-registration');
        Route::patch('/registrations/{registration}/status', 'updateRegistrationStatus')->name('registrations.update-status');
        Route::delete('/registrations/{registration}', 'destroyRegistration')->name('registrations.destroy');
        Route::post('/{event}/remove-image', 'removeImage')->name('remove-image');
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

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/workshop-registrations/{registration}', [App\Http\Controllers\Api\WorkshopRegistrationController::class, 'show']);
});

require __DIR__ . '/auth.php';