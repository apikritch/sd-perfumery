<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Yearly;
use DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller 
{
     public function getYearly(){
            $yearly = Yearly::all();
        return $yearly;
    }

    //public function getBrandById($id){
	//	$brand = Brand::findOrFail($id);
	//	return $brand;
	//}

    public function postYearly(Request $request){
        error_log($request);

        $yearly = Yearly::insert([
            'year'=> $request->year,
            'month'=> $request->month,
            'total'=> $request->total
        ]);
    }

    public function updateYearly(Request $request, $id) {
        $data = array();
        $data['year'] = $request->year;
        $data['month'] = $request->month;
        $data['total'] = $request->total;
        $update = DB::table('yearlies')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }


    //public function deleteBrand($id){
    //    Brand::findOrFail($id)->delete();
    //   return response()->json(['status'=>true,'message' => 'Success']);
    //}
}