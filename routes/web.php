<?php

use App\Http\Controllers\AdminWeb\AuthController;
use App\Http\Controllers\AdminWeb\CategoryController;
use App\Http\Controllers\AdminWeb\CustomerController;
use App\Http\Controllers\AdminWeb\DashboardController;
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

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.web')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('customers/{user}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('customers/{user}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('customers/{user}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('customers/{user}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
        Route::get('leads/export', [LeadController::class, 'exportCsv'])->name('leads.export');
        Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
    });
});
