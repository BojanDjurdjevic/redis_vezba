<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {

    }

    public function prepare()
    {
        return view('product.add-product');
    }

    public function create(CreateProductRequest $request)
    {
        //dd($request->validated());

        Products::create($request->validated()); // vrati samo podatke koji su prošli validaciju

        Cache::forget('allProducts');

        return redirect('/');
    }

    public function flush()
    {
        Cache::forget('allProducts');

        return redirect('/');
    }
}
