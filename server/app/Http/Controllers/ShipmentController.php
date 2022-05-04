<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use DB;
//use Illuminate\Support\Facades\Log;
//error_log($request);

class ShipmentController extends Controller 
{
     public function getShipment(Request $request){

        $search = $request->query('search');

        if($search){
            $shipment = DB::table('shipments')
                    ->where('shipping_method','LIKE',"%$search%")
                    ->get();
                
        } else {
            $shipment = Shipment::all();
        }
        return $shipment;

        
        
    }

    public function getShipmentById($id){
		$shipment = Shipment::findOrFail($id);
		return $shipment;
	}

    public function postShipment(Request $request){
        

        $shipment = Shipment::insert([
            'shipping_method'=> $request->shipping_method,
            'shipping_fee'=> $request->shipping_fee
        ]);
        return response()->json(['status'=>true,'message' => 'Success']);

    }

    public function updateShipment(Request $request, $id) {

        $data = array();
        $data['shipping_method'] = $request->shipping_method;
        $data['shipping_fee'] = $request->shipping_fee;

        $update = DB::table('shipments')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }


    public function deleteShipment($id){
        Shipment::findOrFail($id)->delete();
       return response()->json(['status'=>true,'message' => 'Success']);
    }
}