<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'store_id' => 'required|exists:stores,id',
            'price' => 'required|numeric',
        ]);
        $product = Product::create($request->all());
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'store_id' => 'required|exists:stores,id',
            'price' => 'required|numeric',
            'image' => 'mimes:jpg,jpeg,png',
            'quantity' => 'required|numeric',
            'description' => 'required',
        ]);
        $product  = Product::find($id);
        $product->update($request->all());
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }
}
