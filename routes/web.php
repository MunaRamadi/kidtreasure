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
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products.index'); 
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show'); 
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index'); 
Route::get('/workshops/{event}/register', [WorkshopController::class, 'showRegistrationForm'])->name('workshops.register.form'); 
Route::post('/workshops/{event}/register', [WorkshopController::class, 'register'])->name('workshops.register'); 
Route::post('/workshops/register-interest', [WorkshopController::class, 'registerInterest'])->name('workshops.register.interest');
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index'); 
Route::get('/stories/submit', [StoryController::class, 'create'])->name('stories.create'); 
Route::post('/stories/submit', [StoryController::class, 'store'])->name('stories.store'); 
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index'); 
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show'); 
Route::get('/contact-us', [ContactController::class, 'create'])->name('contact.create'); 
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store'); 

// طرق عربة التسوق
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add-item', [CartController::class, 'addItem'])->name('cart.add-item');
Route::patch('/cart/update-item/{itemId}', [CartController::class, 'updateItem'])->name('cart.update-item');
Route::delete('/cart/remove-item/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove-item');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/mini', [CartController::class, 'miniCart'])->name('cart.mini');

// طرق الدفع
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/failed/{order}', [CheckoutController::class, 'failed'])->name('checkout.failed');

Route::get('/dashboard', function () {
    return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
