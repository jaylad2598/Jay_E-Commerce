<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ApiProductController extends Controller
{
    //
    public function create(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->status = $request->input('status');
        $product->save();

        return response()->json($product);
    }

    public function show()
    {
        $product = Product::all();
        return response()->json($product);
    }

    public function showbyid($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function updatebyid(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->status = $request->input('status');
        $product->save();

        return response()->json($product);
    }

}
