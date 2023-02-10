<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function getDeliveryAddress(Request $request){
        //call the ajax to get delivery address and return to the form
        if($request->ajax()){
            $data = $request->all();
            $address = DeliveryAddress::where('id',$data['addressid'])->first()->toArray(); //pass theh id from the jquery

            return response()->json(['address'=>$address]); //get the address from the database
        }
    }
}
