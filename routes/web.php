<?php

use App\Http\Controllers\AdminWeb\AuthController;
use App\Http\Controllers\AdminWeb\CategoryController;
use App\Http\Controllers\AdminWeb\CustomerController;
use App\Http\Controllers\AdminWeb\DashboardController;
use App\Http\Controllers\AdminWeb\HeroController;
use App\Http\Controllers\AdminWeb\LeadController;
use App\Http\Controllers\AdminWeb\OrderController;
use App\Http\Controllers\AdminWeb\ProductController;
use App\Http\Controllers\AdminWeb\UserController;
use App\Http\Controllers\Store\LeadTrackingController;
use App\Http\Controllers\Store\StorefrontController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Curves & Tees Customer Web Storefront
|--------------------------------------------------------------------------
*/
Route::get('/', [StorefrontController::class, 'index'])->name('store.index');
Route::get('/product/{product}', [StorefrontController::class, 'show'])->name('store.product');
Route::get('/checkout', [StorefrontController::class, 'checkoutView'])->name('store.checkout');
Route::post('/checkout', [StorefrontController::class, 'checkout'])->name('store.checkout.submit');
Route::get('/order/{order_number}/success', [StorefrontController::class, 'orderSuccess'])->name('store.order.success');
Route::post('/store/leads/track', [LeadTrackingController::class, 'track'])->name('store.leads.track');

/*
|--------------------------------------------------------------------------
| Admin Authentication & Management Portal
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

Route::middleware(['auth', 'admin.web'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Inventory, Catalog & Orders (Accessible to both Administrators and Storekeepers)
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class)->except(['show', 'destroy']);
        Route::resource('categories', CategoryController::class)->except(['show', 'destroy']);
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('customers/{user}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('customers/{user}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('customers/{user}', [CustomerController::class, 'update'])->name('customers.update');

        // Full Administrator Only: User Management, Hero Branding, Leads & Campaigns, Record Deletion
        Route::middleware('admin.full')->group(function () {
            Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
            Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
            Route::delete('customers/{user}', [CustomerController::class, 'destroy'])->name('customers.destroy');

            Route::get('hero', [HeroController::class, 'index'])->name('hero.index');
            Route::post('hero/settings', [HeroController::class, 'updateSettings'])->name('hero.settings');
            Route::post('hero/slides', [HeroController::class, 'storeSlide'])->name('hero.slides.store');
            Route::put('hero/slides/{slide}', [HeroController::class, 'updateSlide'])->name('hero.slides.update');
            Route::delete('hero/slides/{slide}', [HeroController::class, 'destroySlide'])->name('hero.slides.destroy');
            Route::post('hero/slides/{slide}/delete', [HeroController::class, 'destroySlide'])->name('hero.slides.destroy.post');
            Route::patch('hero/slides/{slide}/toggle', [HeroController::class, 'toggleSlide'])->name('hero.slides.toggle');

            Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
            Route::get('leads/export', [LeadController::class, 'exportCsv'])->name('leads.export');
            Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::get('users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('users', [UserController::class, 'store'])->name('users.store');
        });
});
