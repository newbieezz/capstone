<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class VendorController extends Controller
{
    public function loginRegister(){
        return view('front.vendors.login_register');
    }

    public function login(){
        return view('front.vendors.login');
    }

    public function vendorRegister(Request $request){
        //get the data in post method
        if($request->isMethod('post')){
            $data = $request->all();

            //validate vendor
            $rules = [
                "name" => "required",
                "lastname" => "required",
                "email" => "required|email|unique:admins|unique:vendors",//must be a unique email and be checked thru admins table for its uniqueness
                "mobile" => "required|min:10|numeric|unique:vendors|unique:vendors", 
                'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                "accept" => "required",
            ];

            $customMessages = [
                "name.required" => "Name is required!",
                "lastname.required" => "Last Name is required!",
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
            $admin->lastname = $data['lastname'];
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
            $message = "Thanks for registering as Vendor. Please confirm your email to confirm your account!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    //confirm vendor/send email
    public function confirmVendor($email){
        //decode vendor email
       $email = base64_decode($email);

        //check if vendor exists or not
        $vendorCount = Vendor::where('email',$email)->count();
        if($vendorCount > 0) {
            //vendor email is already activated or not
            $vendorDetails = Vendor::where('email',$email)->first();
            if($vendorDetails->confirm=="Yes"){
                $message = "Your Vendor Account is already confirmed. You can now login!";
                return redirect('vendor/login-register')->with('error_message',$message);
            } else {
                //update confirm column to Yes in both admin/vendors tables to activate
                Admin::where('email',$email)->update(['confirm'=>"Yes"]);
                Vendor::where('email',$email)->update(['confirm'=>"Yes"]);

                //send register email
                $messageData = [
                    'email' => $email,
                    'name' => $vendorDetails->name,
                    'mobile' => $vendorDetails->mobile,
                ];
                Mail::send('emails.vendor_confirmed',$messageData,function($message)use($email){
                    $message->to($email)->subject('Your Vendor Account is Confirmed!');
                });
                //redirect vendor to the login/register page wtih success message
                $message = "Your Vendor Email Account is confirmed. You can now login, do add your personal, business and bank details to activate your Vendor Account and fully use all the features!";
                return redirect('vendor/login-register')->with('success_message',$message);
            }
        } else{
            abort(404);
        }
    }

    public function vendorlist(Request $request){
       
        $getVendorShop = Vendor::getVendorShop('shop_name');
    //     //get vendor products
        $vendorProducts = Product::with('brands')->where('status',1);
        $getVendorDetails = VendorsBusinessDetails::get()->toArray();
        $vendorProducts = $vendorProducts->paginate(30);
        //  dd($vendorProducts);
       return view('front.vendors.vendor_list')->with(compact('getVendorShop','vendorProducts','getVendorDetails'));

    //     return view('front.vendors.vendor_list')->with(compact('getVendorShop','vendorProducts'));
    }
}
