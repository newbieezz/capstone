<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    public function loginRegister(){
        return view('front.vendors.login_register');
    }

    public function vendorRegister(Request $request){
        //get the data in post method
        if($request->isMethod('post')){
            $data = $request->all();

            //validate vendor
            $rules = [
                "name" => "required",
                "email" => "required|email|unique:admins|unique:vendors",//must be a unique email and be checked thru admins table for its uniqueness
                "mobile" => "required|min:10|numeric|unique:vendors|unique:vendors", 
                "accept" => "required",
            ];

            $customMessages = [
                "name.required" => "Name is required!",
                "email.required" => "Email is required!",
                "email.unique" => "Email already Exists!",
                "mobile.required" => "Mobile is required!",
                "mobile.unique" => "Mobile already Exists!",
                "accept.required" => "Kindly accept terms & conditions!",
            ];

            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            //if anything goes wrong from inserting then the entry will not enter in db
            DB::beginTransaction();

            //create vendor account then save in vendors table
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;

            //save phil timezone
            date_default_timezone_set("Asia/Taipei");
            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();

            $vendor_id = DB::getPdo()->lastInsertId();//syntax t get the vendor id 

            //insert vendor details in admins id using vendor_id to specify the admin type
            $admin = new Admin;
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $data['name'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->mobile = $data['mobile'];
            $admin->status = 0;

             //save phil timezone
            date_default_timezone_set("Asia/Taipei");
            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            //send confirmation email to the vendor
            $email = $data['email'];
            $messageData = [
                'email' =>$data['email'],
                'name' =>$data['name'],
                'code' =>base64_encode($data['email']),
            ];
            Mail::send('emails.vendor_confirmation',$messageData,function($message)use($email){
                $message->to($email)->subject('Confirm your Vendor Account');
            });
            DB::commit();

            //redirect with success message
            $message = "Thanks for registeriing as Vendor. We wil confirm by email once your account is approved.";
            return redirect()->back()->with('success_message',$message);
        }
    }
}
