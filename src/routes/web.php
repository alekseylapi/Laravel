<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return "Hello world";
    });
    
    // Категории
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories')->withTrashed();
    Route::post('categories/{id}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])
        ->name('admin.categories.restore');

    // Продукты
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show'])->names('admin.products');
    Route::post('products/{id}/restore', [\App\Http\Controllers\Admin\ProductController::class, 'restore'])
        ->name('admin.products.restore');
});

// Роуты для аутентификации
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
