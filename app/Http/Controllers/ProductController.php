<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product){
        return response()->json([
            'product' => $product,
            'store' => $product->store
        ]);
    }
}
