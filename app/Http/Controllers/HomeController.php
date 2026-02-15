<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
         /*
        $users = User::all();

        Cache::put('all_users', $users); 

        dd(Cache::get('all_users'));*/
        /* // bez remember()
        if(Cache::has('allProducts')) {
            $products = Cache::get('allProducts');
        } else {
            $products = Products::latest()->take(15)->get();
            Cache::put('allProducts', $products, 300); // 5 min
        }
        

        //Cache::remember
        $products = Cache::remember('allProducts', 300, function() {
            return Products::latest()->take(15)->get();
        });
        */

        //skraćena remember (php 8+)
        $products = Cache::remember('allProducts', 300, fn() => Products::latest()->take(15)->get());

        return view('welcome', [
            'products' => $products
        ]);
    }
}
