<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use DB;

class BillingAddressController extends Controller
{
    public function getBillingAddressById($id){
		$billing_address = DB::table('billing_addresses')
        ->where('order_id', $id)->get();  
        return  response()->json(...$billing_address);
	}

    public function postBillingAddress(Request $request){
        $billing_address = BillingAddress::insert([
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
