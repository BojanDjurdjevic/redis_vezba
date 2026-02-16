<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShipmentController;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/',[ HomeController::class, 'index'])->name('homepage');

Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function() {
    Route::get('/add', 'prepare')->name('prepare');
    Route::post('/create', 'create')->name('create');
    Route::get('/flush', 'flush')->name('flush');
});

Route::resource('shipments', ShipmentController::class);
