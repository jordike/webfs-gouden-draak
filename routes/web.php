<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
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
        Route::inertia('menu', 'BackOffice/Menu')->name('menu');
        Route::resource('sales', SalesController::class)->names('sales');
    });
});
