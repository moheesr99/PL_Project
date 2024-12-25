<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'stores' => Store::all()
        ]);
    }
    public function show(Store $store): JsonResponse
    {
        return response()->json([
            'store' => $store->load('products')
        ]);
    }
}
