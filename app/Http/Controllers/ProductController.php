<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Models\Products;
use Illuminate\Http\Request;

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

        return redirect('/');
    }
}
