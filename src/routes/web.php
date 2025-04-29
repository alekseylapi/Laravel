<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return "Hello world";
    });
});
Route::prefix('admin')->middleware(['auth', 'check_is_admin'])->group(function () {
    // Категории
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::post('categories/{id}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])
        ->name('categories.restore');

    // Продукты
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    Route::post('products/{id}/restore', [\App\Http\Controllers\Admin\ProductController::class, 'restore'])
        ->name('products.restore');
});
