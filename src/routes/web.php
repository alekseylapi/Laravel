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
Route::prefix('admin')->middleware([])->group(function () {
    // Категории
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories')->withTrashed();
    Route::post('categories/{id}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])
        ->name('admin.categories.restore');

    // Продукты
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show'])->names('admin.products');
    Route::post('products/{id}/restore', [\App\Http\Controllers\Admin\ProductController::class, 'restore'])
        ->name('products.restore');
});
