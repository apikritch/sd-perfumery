<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderedProduct;
use DB;

//use Illuminate\Support\Facades\Log;
//error_log($ordered_product);

class OrderedProductController extends Controller
{
    public function getOrderedProducts(){
        $ordered_product = OrderedProduct::all();
        return $ordered_product;
    }

    public function getOrderedProductById($id){
		$ordered_product = DB::table('ordered_products')
        ->where('order_id', $id)->get();      
        return  response()->json($ordered_product);
	}

    public function postOrderedProduct(Request $request){

       foreach($request->ordered_items as $ordered_items)
       {           
           $ordered_product = OrderedProduct::insert([
                'order_id'=> $ordered_items['order_id'],
                'product_id'=> $ordered_items['product_id'],
                'image'=> $ordered_items['image'],
                'title'=> $ordered_items['title'],
                'brand'=> $ordered_items['brand'],
                'type'=> $ordered_items['type'],
                'size'=> $ordered_items['size'],
                'gender'=> $ordered_items['gender'],
                'price'=> $ordered_items['price'],
                'discount'=> $ordered_items['discount'],
                'discount_number'=> $ordered_items['discount_number'],
                'quantity'=> $ordered_items['quantity'],
                'final_price'=> $ordered_items['final_price'],
                'total'=> $ordered_items['total'],
            ]);
       }
       return response()->json(['status'=>true,'message' => 'Success']);
    }
}

