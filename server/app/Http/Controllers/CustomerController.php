<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Mail\CustomerResetPassword;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class CustomerController extends Controller 
{
    public function getCustomers(Request $request){

        $search = $request->query('search');

        if($search){
            $customers = DB::table('customers')
                    ->where('first_name','LIKE',"%$search%")
                    ->orwhere('last_name','LIKE',"%$search%")
                    ->orwhere('email','LIKE',"%$search%")
                    ->orwhere('phone','LIKE',"%$search%")
                    ->orwhere('address_1','LIKE',"%$search%")
                    ->orwhere('address_2','LIKE',"%$search%")
                    ->orwhere('city','LIKE',"%$search%")
                    ->orwhere('state','LIKE',"%$search%")
                    ->orwhere('postcode','LIKE',"%$search%")
                    ->get();
                
        } else {
            $customers = Customer::all();
        }
        return $customers;
    }

    public function getCustomerById($id){
		$customer = Customer::findOrFail($id);
		return $customer;
	}

    public function updateCustomer(Request $request, $id) {
        $data = array();
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;

        $data['address_1'] = $request->address_1;
        $data['address_2'] = $request->address_2;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['postcode'] = $request->postcode;
        $data['country'] = $request->country;

        $data['password'] = $request->password;
 

        $update = DB::table('customers')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function signUp(Request $request){
        $inputEmail = $request->email;
        if ((Customer::where('email', '=', $inputEmail)->exists())){
        return response()->json(['status'=>true,'message' => 'Fail']);
        }else{
        $data = array();
        $data['email'] = $request->email;
        $data['country'] = "Sri Lanka";
        $password = $request->password;
        $hashed = Hash::make($password);
        $data['password'] = $hashed;
        DB::table('customers')->insert($data);
        $response = DB::table('customers')->where('email', $request->email)->get();
        return  response()->json(...$response);
        }
    }

    public function signIn(Request $request){
        $inputEmail = $request->email;
        $inputPassword = $request->password;
        if ((Customer::where('email', '=', $inputEmail)->exists())){
            $check = Customer::where('email', $inputEmail)->first();
            if(Hash::check($inputPassword,$check->password)){
                $response = DB::table('customers')->where('email', $request->email)->get();
                return  response()->json(...$response);
            } else{
                return response()->json(['status'=>false,'message' => 'Fail']);
            }
        } else {
            return response()->json(['status'=>true,'message' => 'Fail']);
        }
        
    }

    public function changePassword(Request $request, $id) {
        $inputPassword = $request->current_password;
        $newPassword = $request->new_password;
        $check = Customer::where('id', $id)->first();
        if(Hash::check($inputPassword,$check->password)){
            Customer::where('id',$id)->update([
                'password' => Hash::make($newPassword)
            ]);
            return response()->json(['status'=>true,'message' => 'Success']);
        } else{
            return response()->json(['status'=>false,'message' => 'Fail']);
        }    
    }

    public function forgetPassword(Request $request) {

        $inputEmail = $request->email;
        $random = Str::random(40);
        $details = [
            'title' => 'Hello',
            'body' => 'this is test',
            'token' => $random
        ];
        if (Customer::where('email', '=', $inputEmail)->exists()){
            Customer::where('email',$inputEmail)->update([
                'token' => $random,
            ]);
            $data = array();
            $data['email'] = $inputEmail;
            $data['token'] = $random;
            $data['created_at'] = Carbon::now();
            $key = DB::table('password_resets')->insert($data);
            Mail::to($inputEmail)->send(new CustomerResetPassword($details));
            return response()->json(['status'=>true,'message' => 'Success']);
        } else {
            return response()->json(['status'=>false,'message' => 'Fail']);
        }
    }


    public function resetPassword(Request $request, $token) {
    
        $newPassword = $request->password;
        $customer = Customer::where('token', '=', $token)->first();
        DB::table('password_resets')->where('created_at', '<', Carbon::now()->subMinutes(10))->delete();
        if ((Customer::where('token', '=', $token)->exists()) && DB::table('password_resets')->where('token', $token)->exists()) {
            Customer::where('token',$token)->update([
                'password' => Hash::make($newPassword),
                'token' => null

            ]);

            return response()->json(['status'=>true,'message' => 'Success']);
         } else {
            return response()->json(['status'=>false,'message' => 'Fail']);
         }
    }

    public function contactUs(Request $request) {
        if($request->filled('email')){
            $email = $request->email;
            $name = $request->name;
            $message = $request->message;

            $details = [
                'email' => $email,
                'name' => $name,
                'message' => $message
            ];

            //error_log($details['email']);

            Mail::to('sdperfumery@gmail.com')->send(new ContactMail($details));
            return response()->json(['status'=>true,'message' => 'Success']);
        } else {
            return response()->json(['status'=>false,'message' => 'Fail']);
        }
        
    }

}