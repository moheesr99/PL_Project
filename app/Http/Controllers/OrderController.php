<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders=Order::where('user_id',$request->user()->id)->get();
        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'No orders found',
            ]);
        }
        return response()->json([
            'orders' => $orders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
        ]);
        $order=Order::updateOrCreate(
            [
                'user_id'=>$request->user()->id,
                'product_id' => $request->product_id
            ],
            [
                'quantity' => \DB::raw('quantity + {$request->quantity}'),
            ]
        );
        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
