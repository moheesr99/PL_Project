<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);
        $store=Store::create($request->all());
        return response()->json([
            'message'=>'Store created successfully',
            'store'=>$store
        ]);
    }
    public function destroy($id)
    {
        $store=Store::findOrFail($id);
        $store->delete();
        return response()->json([
            'message'=>'Store deleted successfully',
        ]);
    }
}
