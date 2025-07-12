<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth'])->group(function(){
    Route::controller(DashboardController::class)->name('dashboard.')->group(function(){
        Route::get('dashboard', 'index')->name('index');
    });

    Route::controller(UserController::class)->name('users.')->group(function(){
        Route::get('users', 'index')->name('index');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
