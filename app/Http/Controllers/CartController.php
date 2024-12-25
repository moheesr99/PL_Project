<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cartItems = Cart::where('user_id', $request->user()->id)->with('products')->get();
        if (!$cartItems) {
            return response()->json([
                'message' => 'Cart is empty',
            ]);
        }
        return response()->json([
            'cartItems' => $cartItems,
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();

        // Insert a new cart item
        Cart::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        $quantity = $request->input('quantity');
        $productId = $request->input('product_id');
        $product = Product::find($productId);
        $product->quantity = $product->quantity - $quantity;
        $product->save();

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function update(Request $request, $cartItemId): JsonResponse
    {
        $userId = auth()->id();

        // Validate the request data (ensure quantity is an integer and greater than 0)
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the cart item by its ID and ensure it belongs to the authenticated user
        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', $userId)
            ->first();

        // If the cart item is not found or doesn't belong to the user
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found or does not belong to the user'], 404);
        }

        // Update the quantity
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $productId = $cartItem->product_id;
        $quantity = $request->input('quantity');
        $product = Product::find($productId);
        $product->quantity = $product->quantity - $quantity;
        $product->save();



        return response()->json([
            'message' => 'Cart item quantity updated successfully',
            'cartItem' => $cartItem
        ]);
    }

    public function destroy(Request $request, $cartItemId)
    {
        $userId = auth()->id();

        // Find the cart item by ID and ensure it belongs to the authenticated user
        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', $userId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found or does not belong to the user'], 404);
        }

        $productId = $cartItem->product_id;
        $quantity = $cartItem->quantity;
        $product=Product::find($productId);
        $product->quantity = $product->quantity + $quantity;
        $product->save();
        // Delete the cart item
        $cartItem->delete();

        return response()->json(['message' => 'Product removed from cart successfully']);
    }

}
