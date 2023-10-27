<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
class ProductController extends Controller
{
    //To get all the Product list from the database
    public function index(){
        $products = Products::all();
        //response in JSON format
        return response()->json($products);
    }
    //To add new product in database 
    public function addNew(Request $request){
        $product = new Products();
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->details = $request->details;
        $product->save();
        return response()->json(["message"=>"New Product added successfully"], 201);
    }

    //To display particular product by passing ID
    public function displayByid($id){
        $product = Products::find($id);
        if(!empty($product)){
            return response()->json(["message"=> "Product Details", "product"=> $product]);
        }else{
            return response()->json(["message"=> "Opps! Product not found."], 404);
        }
    }

    //To update particular product 
    public function updateProduct(Request $request, $id){
        if(Products::where("id", $id)->exists()){
            $product = Products::find($id);
            $product->product_name = is_null($request->product_name) ? $product->product_name : $request->product_name;
            $product->price = is_null($request->price) ? $product->price : $request->price;
            $product->details = is_null($request->details) ? $product->details : $request->details;

            $product->save();
            return response()->json(["message"=>"Product updated successfully"], 201);

        }else{
            return response()->json(["message"=>"Product not found"], 404);
        }
    }
    public function deleteProduct($id){
        if(Products::where("id", $id)->exists()){
            $product = Products::find($id);
            $product->delete();
            return response()->json(["message"=> "Product deleted successfully"], 202);
        }else{
            return response()->json(["message"=> "Product not found"], 404);
        }
    }
}
