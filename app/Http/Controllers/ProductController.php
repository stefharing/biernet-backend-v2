<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {

        $products = Product::all();

        return $products;

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required'
        ]);

        Product::create($request->all());

        return ('product created successfully');
    }

    public function update(Request $request, Product $product)

    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required'
        ]);

        $product->update($request->all());

        return ('product updated successfully');
    }

    public function destroy(Product $product)

    {
        $product->delete();

        return ('product successfully deleted');
    }

}
