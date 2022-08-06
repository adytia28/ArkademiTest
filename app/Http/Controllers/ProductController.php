<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\DeleteProductRequest;

class ProductController extends Controller
{
    public function index(Request $request) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $product = Product::with('category_id')->get();
        return response()->json(['error' => false,'data' => $product]);
    }

    public function create(CreateProductRequest $request) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $product = new Product;
        $product->create($request->validated());

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

    public function delete(DeleteProductRequest $request) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $product = Product::where('product_id', $request->product_id)->first();

        if(!$product)
        return $this->responseJson();

        $product->delete();
        return $this->responseJson(true);
    }

    public function update(UpdateProductRequest $request, $id) {
        $auth = $this->Authorization($request);

        if($auth !== true)
        return $auth;

        $product = Product::where('product_id', $id)->first();

        if(!$product)
        return $this->responseJson(null);

        $product->update($request->validated());
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

        $auth = User::where('token', $request->header('Authorization'))->first();

        return $auth ? true : $response;
    }
}
