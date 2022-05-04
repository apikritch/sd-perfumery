<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Mail\UserResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;



class UserController extends Controller 
{
    public function getUsers(Request $request){

        $search = $request->query('search');

        if($search){
            $users = DB::table('users')
                    ->where('first_name','LIKE',"%$search%")
                    ->orwhere('last_name','LIKE',"%$search%")
                    ->orwhere('email','LIKE',"%$search%")
                    ->orwhere('phone','LIKE',"%$search%")
                    ->get();
                
        } else {
            $users = User::all();
        }
        return $users;

        
        
    }

    public function getUserById($id){
		$user = User::findOrFail($id);
		return $user;
	}

    public function getUserByCookies(Request $request){
		$user = DB::table('users')
        ->where('email', $request->email)
        ->get();
        error_log($user);
        return  response()->json(...$user);
	}

    public function postUser(Request $request){
        $inputEmail = $request->email;
        if ((User::where('email', '=', $inputEmail)->exists())){
        return response()->json(['status'=>true,'message' => 'Fail']);
        }else{

        
        $password = $request->password;
        $hashed = Hash::make($password);
        $user = User::insert([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'user_type'=> $request->user_type,
            'user_status'=> "Active",
            'password'=> $hashed,
        ]);
        return response()->json(['status'=>true,'message' => 'Success']);
        }
    }

    public function updateUser(Request $request, $id) {
        $password = $request->password;
        $hashed = Hash::make($password);

        $data = array();
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['user_type'] = $request->user_type;
        $data['user_status'] = $request->user_status;
        $data['password'] = $hashed;
        $update = DB::table('users')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function deleteUser($id){
        User::findOrFail($id)->delete();
       return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function signIn(Request $request){
        $inputEmail = $request->email;
        $inputPassword = $request->password;
        if ((User::where('email', '=', $inputEmail)->exists())){
            $check = User::where('email', $inputEmail)->first();
            if(Hash::check($inputPassword,$check->password)){
                $response = DB::table('users')->where('email', $request->email)->get();
                return  response()->json(...$response);
            } else{
                return response()->json(['status'=>false,'message' => 'Fail']);
            }
        } else {
            return response()->json(['status'=>true,'message' => 'Fail']);
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
        if (User::where('email', '=', $inputEmail)->exists()){
            User::where('email',$inputEmail)->update([
                'token' => $random,
            ]);
            $data = array();
            $data['email'] = $inputEmail;
            $data['token'] = $random;
            $data['created_at'] = Carbon::now();
            $key = DB::table('password_resets')->insert($data);
            Mail::to($inputEmail)->send(new UserResetPassword($details));
            return response()->json(['status'=>true,'message' => 'Success']);
        } else {
            return response()->json(['status'=>false,'message' => 'Fail']);
        }
    }

    public function resetPassword(Request $request, $token) {
        $newPassword = $request->password;
        $user = User::where('token', '=', $token)->first();        
        DB::table('password_resets')->where('created_at', '<', Carbon::now()->subMinutes(10))->delete();
        if ((User::where('token', '=', $token)->exists()) && DB::table('password_resets')->where('token', $token)->exists()) {
            User::where('token',$token)->update([
                'password' => Hash::make($newPassword),
                'token' => null
            ]);
            return response()->json(['status'=>true,'message' => 'Success']);
         } else {
            return response()->json(['status'=>false,'message' => 'Fail']);
         }
    }

    public function changePassword(Request $request, $id) {
        $inputPassword = $request->current_password;
        $newPassword = $request->new_password;
        $check = User::where('id', $id)->first();
        error_log($check->password);
        if(Hash::check($inputPassword,$check->password)){
            error_log("0");
            User::where('id',$id)->update([
                'password' => Hash::make($newPassword)
            ]);
            return response()->json(['status'=>true,'message' => 'Success']);
        } else{
            error_log("1");
            return response()->json(['status'=>false,'message' => 'Fail']);
        }    
    }
}