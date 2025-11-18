<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function getProduct($id)
    {
        return [
            'id' => $id,
            'name' => "Product $id",
            'price' => rand(10000, 100000),
            'description' => "Description of product $id"
        ];
    }

    private function getAllProducts()
    {
        return collect(range(1, 20))->map(function ($i) {
            return $this->getProduct($i);
        });
    }

    function index()
    {
        $products = $this->getAllProducts();
        return view('products.list', ['products' => $products]);
    }

    function create()
    {
        return view('products.form');
    }

    function edit($id)
    {
        $product = $this->getProduct($id);
        return view('products.form', ['product' => $product]);
    }

    function store(Request $request)
    {
        return redirect()->route('products');
    }

    function update(Request $request, $id)
    {
        return redirect()->route('products');
    }

    function show($id)
    {
        $product = $this->getProduct($id);
        return view('products.show', ['product' => $product]);
    }
}
