<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['check_is_admin'])->group(function() {
    Route::prefix('products')/*->middleware('can:product_view')*/->group(function() {
        Route::get('', [ProductController::class, 'index']);
        Route::get('{product}', [ProductController::class, 'view'])->withTrashed();
        Route::post('', [ProductController::class, 'store']);
        Route::put('{product}', [ProductController::class, 'update']);
        Route::delete('{product}', [ProductController::class, 'delete']);
        Route::post('{product}/restore', [ProductController::class, 'restore'])->withTrashed();
    });
    Route::prefix('admin')/*->middleware('can:product_view')*/ ->group(function () {
        Route::get('index', [CategoryController::class, 'index']); //
        Route::get('{category}', [CategoryController::class, 'view']);
        Route::post('store', [CategoryController::class, 'store']);
        Route::put('{category_id}', [CategoryController::class, 'update']);
        Route::delete('{category_id}', [CategoryController::class, 'delete']);
    });
});
