<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/',[ HomeController::class, 'index'])->name('homepage');

Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function() {
    Route::get('/add', 'prepare')->name('prepare');
    Route::post('/create', 'create')->name('create');
    Route::get('/flush', 'flush')->name('flush');
});

Route::resource('shipments', ShipmentController::class);
/*
Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('profile/change-avatar', [ProfileController::class, 'changeAvatar'])->name('profile.changeAvatar');
});

require __DIR__.'/auth.php';
