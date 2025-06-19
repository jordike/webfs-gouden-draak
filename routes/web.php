<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Main/Home')->name('home');
Route::inertia('/menukaart', 'Main/Menu')->name('menu');
Route::inertia('/nieuws', 'Main/News')->name('news');
Route::inertia('/contact', 'Main/Contact')->name('contact');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('guest')->post('/login', [AuthController::class, 'loginPost'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('backoffice')->name('backoffice.')->group(function () {
        Route::get('/', function() {
            return redirect()->route('backoffice.orders.index');
        });

        Route::resource('orders', OrderController::class)->names('orders');
        Route::resource('menu', MenuController::class)->names('menu');
        Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
        Route::get('sales/daily-overview', [SalesController::class, 'dailyOverview'])->name('sales.daily-overview');
        Route::get('sales/daily-overview/{dailyOverview}/download', [SalesController::class, 'downloadDailyOverview'])->name('sales.daily-overview.download');
        Route::get('sales/export/{order}', [SalesController::class, 'export'])->name('sales.export');
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    });

    Route::get('/review/{order}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{order}', [ReviewController::class, 'store'])->name('review.store');
});
