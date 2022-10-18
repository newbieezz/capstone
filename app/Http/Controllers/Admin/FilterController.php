<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use Illuminate\Support\Facades\Session;
class FilterController extends Controller
{
    public function filters(){
        Session::put('page','filters');

        $filters = ProductsFilter::get()->toArray();

        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValue(){
        Session::put('page','filters');

        $filters_value = ProductsFiltersValue::get()->toArray();

        return view('admin.filters.filters_value')->with(compact('filters_value'));
    }

    // Update Filter Status
    public function updateFilterStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            ProductsFilter::where('id',$data['filter_id'])->update(['status'=>$status]);
            //return details into the ajax response so we can add the response as well
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    // Update FilterValue Status
    public function updateFilterValueStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            ProductsFiltersValue::where('id',$data['filter_id'])->update(['status'=>$status]);
            //return details into the ajax response so we can add the response as well
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }
}
