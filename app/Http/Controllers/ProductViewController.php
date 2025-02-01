<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductViewController extends Controller
{
    public function index()
    {
        $products = Product::with('properties')->get();
        return view('products.index', compact('products'));
    }
}
