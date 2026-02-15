<?php

use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /*
    $users = User::all();

    Cache::put('all_users', $users); */

    dd(Cache::get('all_users'));

    return view('welcome');
});

Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function() {
    Route::get('/add', 'prepare')->name('prepare');
    Route::post('/create', 'create')->name('create');
});
