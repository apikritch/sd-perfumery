<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use DB;
//use Illuminate\Support\Facades\Log;
//error_log($request);

class BrandController extends Controller 
{
     public function getBrands(Request $request){

        $search = $request->query('search');

        if($search){
            $brand = DB::table('brands')
                    ->where('text','LIKE',"%$search%")
                    ->orwhere('value','LIKE',"%$search%")
                    ->get();
                
        } else {
            $brand = Brand::all();
        }
        return $brand;
    }

    public function getBrandById($id){
		$brand = Brand::findOrFail($id);
		return $brand;
	}

    public function postBrand(Request $request){
        $brand = Brand::insert([
            'value'=> $request->value,
            'text'=> $request->text
        ]);
        return response()->json(['status'=>true,'message' => 'Success']);

    }

    public function updateBrand(Request $request, $id) {

        $data = array();
        $data['value'] = $request->value;
        $data['text'] = $request->text;

        $update = DB::table('brands')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }


    public function deleteBrand($id){
        Brand::findOrFail($id)->delete();
       return response()->json(['status'=>true,'message' => 'Success']);
    }
}