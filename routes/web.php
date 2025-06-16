<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')
    ->name('home');
Route::inertia('/menukaart', 'Menu')
    ->name('menu');
Route::inertia('/nieuws', 'News')
    ->name('news');
Route::inertia('/contact', 'Contact')
    ->name('contact');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
