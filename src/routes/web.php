<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Настройки email
    Route::get('/email-settings', [\App\Http\Controllers\Admin\EmailNotificationController::class, 'index'])->name('admin.email-settings');
    Route::post('/email-settings/test', [\App\Http\Controllers\Admin\EmailNotificationController::class, 'testNotification'])->name('admin.email-settings.test');
    Route::post('/email-settings/bulk', [\App\Http\Controllers\Admin\EmailNotificationController::class, 'bulkNotification'])->name('admin.email-settings.bulk');
    Route::get('/email-settings/queue-status', [\App\Http\Controllers\Admin\EmailNotificationController::class, 'getQueueStatus'])->name('admin.email-settings.queue-status');
    Route::post('/email-settings/clear-queue', [\App\Http\Controllers\Admin\EmailNotificationController::class, 'clearQueue'])->name('admin.email-settings.clear-queue');
    
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
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
