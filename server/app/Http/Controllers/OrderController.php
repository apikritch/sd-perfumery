<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use DB;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    public function getOrder(Request $request){

        $search = $request->query('search');

        if($search){
            $order = DB::table('orders')
                    ->where('first_name','LIKE',"%$search%")
                    ->orwhere('last_name','LIKE',"%$search%")
                    ->orwhere('tracking_number','LIKE',"%$search%")
                    ->get();
                
        } else {
            $order = Order::all();
        }
        return $order;

    }

    public function getOrderById($id){
		$order = Order::findOrFail($id);
		return $order;
	}


    public function getOrderByEmail(Request $request){
        $response = DB::table('orders')
        ->where('email', $request->email)->get();      
        return  response()->json($response);
    }

    public function getOrderDetailByEmail(Request $request, $id){
        $response = DB::table('orders')
        ->where('email', $request->email)
        ->where('id', $id)->get();      
      
        return  response()->json(...$response);
    }

    public function postOrder(Request $request){
        $order = Order::insert([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'subtotal'=> $request->subtotal,
            'total_saving'=> $request->total_saving,
            'shipping_method'=> $request->shipping_method,
            'shipping_fee'=> $request->shipping_fee,
            'order_total'=> $request->order_total,
            'payment_bank'=> $request->payment_bank,
            'payment_account_name'=> $request->payment_account_name,
            'payment_account_detail'=> $request->payment_account_detail,
            'order_date'=> $request->order_date,
            'order_time'=> $request->order_time,
            'order_status'=> "Waiting for Payment",
            'shippment_status'=> "Awaiting",
            'tracking_number'=> null,
            'notification' => 'Unread'
        ]);

        $response = DB::table('orders')
        ->where('email', $request->email)
        //->where('order_total', $request->order_total)
        ->where('order_date', $request->order_date)
        ->where('order_time', $request->order_time)->get();
    
        return response()->json(...$response);

    }

    public function updateOrder(Request $request, $id) {
        $data = array();
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['subtotal'] = $request->subtotal;
        $data['total_saving'] = $request->total_saving;
        $data['shipping_method'] = $request->shipping_method;
        $data['shipping_fee'] = $request->shipping_fee;
        $data['order_total'] = $request->order_total;
        $data['payment_bank'] = $request->payment_bank;
        $data['payment_account_name'] = $request->payment_account_name;
        $data['payment_account_detail'] = $request->payment_account_detail;
        $data['order_date'] = $request->order_date;
        $data['order_time'] = $request->order_time;
        $data['order_status'] = $request->order_status;
        $data['shippment_status'] = $request->shippment_status;
        $data['tracking_number'] = $request->tracking_number;

       
        $update = DB::table('orders')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function updateOrderNotification(Request $request, $id) {
        

        $data = Order::find($id);
        $data->notification = $request->notification;
        $data->save();
       
        return response()->json(['status'=>true,'message' => 'Success']);
    }
    
    public function postConfirmOrder(Request $request){
        
        $orderId = $request->order_id;

        $order = DB::table('orders') 
        ->where('id', $orderId)
        ->first();

        $email = $order->email;

        $shipping = DB::table('shipping_addresses') 
        ->where('order_id', $orderId)
        ->first();

        $billing = DB::table('billing_addresses') 
        ->where('order_id', $orderId)
        ->first();

        $products = DB::table('ordered_products') 
        ->where('order_id', $orderId)
        ->get();

        foreach($products as $productId){
            
            $stock = DB::table('products') 
            ->where('id', $productId->product_id)
            ->first();
            $productInvent = $stock->stock;
            $orderQuantity = $productId->quantity;

            $productInvent -= $orderQuantity;

            $updateStock = DB::table('products') 
            ->where('id', $productId->product_id)
            ->update(['stock' => $productInvent]);

        }
        
        $details = [
            'id' => $orderId,
            //delivery
            'delivery_first_name'=> $shipping->first_name,
            'delivery_last_name'=> $shipping->last_name,
            'delivery_phone'=> $shipping->phone,
            'delivery_address_1'=> $shipping->address_1,
            'delivery_city'=> $shipping->city,
            'delivery_state'=> $shipping->state,
            'delivery_postcode'=> $shipping->postcode,
            'delivery_country'=> $shipping->country,
            //billing
            'billing_first_name'=> $billing->first_name,
            'billing_last_name'=> $billing->last_name,
            'billing_phone'=> $billing->phone,
            'billing_address_1'=> $billing->address_1,
            'billing_city'=> $billing->city,
            'billing_state'=> $billing->state,
            'billing_postcode'=> $billing->postcode,
            'billing_country'=> $billing->country,
            //order
            'subtotal'=> $order->subtotal,
            'total_saving'=> $order->total_saving,
            'shipping_method'=> $order->shipping_method,
            'shipping_fee'=> $order->shipping_fee,
            'order_total'=> $order->order_total,
            'payment_bank'=> $order->payment_bank,
            'payment_account_name'=> $order->payment_account_name,
            'payment_account_detail'=> $order->payment_account_detail,
            'order_date'=> $order->order_date,
            // 'order_time'=> $order_time,
            'order_status'=> $order->order_status,
            'shippment_status'=> $order->shippment_status,
            //product
            'product'=> $products,
            // 'tracking_number'=> null
        ];

        Mail::to($email)->send(new OrderMail($details));
        
    }
}
