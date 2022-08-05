<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    public function index(Request $request) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        return response()->json(['error' => false,'data' => Product::get()]);
    }

    public function create(Request $request) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $request->validate([
            'product_id' => 'required|integer|unique:products,product_id',
            'product_name' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        $product = new Product;
        $product->product_id = $request->product_id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json(['error' => false, 'success' => true]);
    }

    public function detail(Request $request, $id) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $product = Product::where('product_id', $id)->first();

        if($product)
            return response()->json(['error' => false, 'data' => $product]);
        else
            return response()->json(['error' => false,'data' => []]);
    }

    public function delete(Request $request) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $product = Product::where('product_id', $request->product_id)->first();

        if(!$product)
        return $this->responseJson();

        $product->delete();
        return $this->responseJson(true);
    }

    public function update(Request $request, $id) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $request->validate([
            'product_id' => 'required|integer',
            'product_name' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        $product = Product::where('product_id', $id)->first();

        if(!$product)
        return $this->responseJson(null);

        $product->product_id = $request->product_id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->save();

        return $this->responseJson(true);
    }

    public function responseJson($bool = null) {
        if($bool)
            return response()->json(['error' => false, 'success' => true]);
        else
            return response()->json(['error' => 'Product not found', 'success' => false]);
    }

    public function Authorization($request) {
        $response = response()->json([
            'error' => 'Not Authorization',
            'success' => false,
        ]);

        return User::where('token', $request->header('Authorization'))->first() ? true : $response;
    }
}
