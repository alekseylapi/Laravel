<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')/*->middleware("check_is_admin")*/->group(function() {
    Route::prefix('products')/*->middleware('can:product_view')*/->group(function() {
        Route::get('', [ProductController::class, 'index']);
        Route::get('{product}', [ProductController::class, 'view']);
        Route::post('', [ProductController::class, 'store']);
        Route::put('{product_id}', [ProductController::class, 'update']);
        Route::delete('{product_id}', [ProductController::class, 'delete']);
    });
});
