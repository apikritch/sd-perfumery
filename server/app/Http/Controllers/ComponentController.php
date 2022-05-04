<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Component;
use DB;


class ComponentController extends Controller
{
    public function getComponents(){
        $component = Component::all();
        return $component;
    }

    public function getComponentById($id){
		$component = Component::findOrFail($id);
		return $component;
	}

    public function postComponent(Request $request){
        $component = Component::insert([
            'sequence'=> $request->sequence,
            'link_address'=> $request->link_address,
        ]);
    
        return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function updateComponent(Request $request, $id) {
        //error_log($request);
        
        $data = array();
        $data['sequence'] = $request->sequence;
        $data['link_address'] = $request->link_address;

        $update = DB::table('components')->where('id',$id)->update($data);
        return response()->json(['status'=>true,'message' => 'Success']);
    }

    public function deleteComponent($id){
        Component::findOrFail($id)->delete();

       return response()->json(['status'=>true,'message' => 'Success']);
    }
}
