<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/products', [HomeController::class, 'products'])->name('homepage.products');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('homepage.products.detail');
Route::post('/checkout/{slug}', [HomeController::class, 'rentalStore'])->name('rental.store');


Route::prefix('dashboard')->group(function () {
    Route::middleware(['auth'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        //> products
        Route::resource("product", ProductController::class);
        Route::get('product-action/setActive/{id}',  [ProductController::class, 'setActive'])->name('product.setActive');
        Route::post('/upload-image', [ProductController::class, 'uploadImage'])->name('ckeditor.uploadImage');

        //> Category
        Route::resource("category", CategoryController::class);
        Route::get('category-action/setActive/{id}', [CategoryController::class, 'setActive'])->name('category.setActive');

        //> user
        Route::resource('users', UserController::class)->only(['index', 'show']);
        Route::get('users-action/setActive/{id}', [UserController::class, 'setActive'])->name('users.setActive');

        //> Update password
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile');
        Route::get('/update-password', [DashboardController::class, 'changePassword'])->name('update-password');
        Route::post('/update-password', [DashboardController::class, 'updatePassword'])->name('update-password');
    });
});


Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::get('logout', function () {
        Auth()->logout();
        request()->session()->invalidate();
        request()->session()->flush();;
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
