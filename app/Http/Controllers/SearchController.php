<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $request->validate([
            'search'=>'required',
            'type'=>'required'
        ]);
        $search = $request->input('search');
        $type = $request->input('type');
        if ($type === 'store'){
            $results=Store::where('name','like','%'.$search.'%')->get();
        }elseif ($type === 'product'){
            $results=Product::where('name','like','%'.$search.'%')->orWhere('description','like','%'.$search.'%')->get();
        }else{
            return response()->json([
                'message'=>'Invalid type'
            ]);
        }
        if ($type === 'store'){
        return response()->json([
            'results'=>$results->load('products')
        ]);}
        if ($type === 'product'){
            return response()->json([
                'results'=>$results
            ]);
        }
    }
}
