<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return Product::all(); 
    }

    public function createProduct(Request $data){
        $product = Product::create([
            "name" => $data -> name,
            "price" => $data -> price,
            "description" => $data -> description
        ]);
        return response($product, 200);
    }

    public function updateProduct(Request $data){
        $product = Product::find($data->id);
        $product->name = $data->name;
        $product->price = $data->price;
        $product->description = $data->description;

        $product->save();
        return response($product, 200);
    }

    public function deleteProduct(Request $data){
        $product = Product::find($data->id);
        $product->delete();
        return response(['OK'], 200);
    }

    public function getProduct(Request $data){
        $product = Product::find($data->id);
        return response($product, 200);
    }
}
