<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    //
    public function getDeliveryAddress(Request $request){
        //call the ajax to get delivery address and return to the form
        if($request->ajax()){
            $data = $request->all();
            $address = DeliveryAddress::where('id',$data['addressid'])->first()->toArray(); //fetch the addresss id to show it on form
            return response()->json(['address'=>$address]); //get the address from the database
        }
    }

    //save delivery address
    public function saveDeliveryAddress(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'delivery_name' => 'required|string|max:50',
                'delivery_address' => 'required|string|max:100',
                'delivery_mobile' => 'required|numeric|digits:11',
                'delivery_email' => 'required',
            ]);
            if($validator->passes()){
                $data = $request->all();
                $address = array(); //add all the data columns
                $address['user_id'] = Auth::user()->id;
                $address['name'] = $data['delivery_name'];
                $address['address'] = $data['delivery_address'];
                $address['mobile'] = $data['delivery_mobile'];
                $address['email'] = $data['delivery_email'];
                
                if(!empty($data['delivery_id'])){ //if not empty Edit Delivery Address
                    DeliveryAddress::where('id',$data['delivery_id'])->update($address);
                } else{ //Add Delivery Address
                    $address['status'] = 1;
                    DeliveryAddress::create($address); //creates the address from here
                }
                $deliveryAddresses = DeliveryAddress::deliveryAddresses(); //call and use the function inside the deliveryaddress model
                return response()->json(['view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses'))]); 
            } else {
                return response()->json(['type'=>'error','errors'=>$validator->messages()]); 
            }
           
        }
    }

    public function removeAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            DeliveryAddress::where('id',$data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddress::deliveryAddresses(); //call and use the function inside the deliveryaddress model
            return response()->json(['view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses'))]); 

        }
    }
}
