<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use DB;
//use Illuminate\Support\Facades\Log;
//error_log($shipping_address);

class ShippingAddressController extends Controller
{
 
    public function getShippingAddressById($id){
		$shipping_address = DB::table('shipping_addresses')
        ->where('order_id', $id)->get();  
        return  response()->json(...$shipping_address);

	}

    public function postShippingAddress(Request $request){
        $shipping_address = ShippingAddress::insert([
            'order_id'=> $request->order_id,
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'phone'=> $request->phone,
            'address_1'=> $request->address_1,
            'address_2'=> $request->address_2,
            'city'=> $request->city,
            'state'=> $request->state,
            'postcode'=> $request->postcode,
            'country'=> "Sri Lanka"
        ]);

        return response()->json(['status'=>true,'message' => 'Success']);
    }
}
