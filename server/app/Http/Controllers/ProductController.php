<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;


class ProductController extends Controller 
{
    public function getProducts(Request $request){

        $search = $request->query('search');

        if($search){
            $products = DB::table('products')
                    ->where('title','LIKE',"%$search%")
                    ->orwhere('description','LIKE',"%$search%")
                    ->get();
                
        } else {
            $products = Product::all();
        }
        return $products;
    }

    public function getProductById($id){
		$product = Product::findOrFail($id);
		return $product;
	}

    public function postProduct(Request $request){
        $product = Product::insert([
            'image'=> $request->image,
            'title'=> $request->title,
            'brand'=> $request->brand,
            'type'=> $request->type,
            'size'=> $request->size,
            'gender'=> $request->gender,
            'description'=> $request->description,
            'stock'=> $request->stock,
            'price'=> $request->price,
            'discount'=> $request->discount,
            'discount_number'=> $request->discount_number,
            'final_price'=> $request->final_price,
        ]);
        return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function updateProduct(Request $request, $id) {
        $data = array();
        $data['image'] = $request->image;
        $data['title'] = $request->title;
        $data['brand'] = $request->brand;
        $data['type'] = $request->type;
        $data['size'] = $request->size;
        $data['gender'] = $request->gender;
        $data['description'] = $request->description;
        $data['stock'] = $request->stock;
        $data['price'] = $request->price;
        $data['discount'] = $request->discount;
        $data['discount_number'] = $request->discount_number;
        $data['final_price'] = $request->final_price;

        $update = DB::table('products')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function deleteProduct($id){
        Product::findOrFail($id)->delete();

       return response()->json(['status'=>true,'message' => 'Success']);
    }
}