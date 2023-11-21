<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PayLaterApplication;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class PayLaterApplicationController extends Controller
{
    public function application(){
        return view('front.pay_later.pay_later_application');    
    }

    public function saveApplication(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            dd($data);  
            $rules = [
                'dob' => 'required',
                    'pob' => 'required',
                    'sof' => 'required',
                    'comp_name' => 'required',
                    'income' => 'required',
                    'valid_id' => 'required',
                    'selfie' => 'required',
                    'emerCon_name' => 'required',
                    'emerCon_mobile' => 'required',
                    'relationship' => 'required',
                    'accept' => 'required',
            ];
                $this->validate($request,$rules);
                //upload valid_id image 
                if($image = $request->file('valid_id')){
                    $path = 'front/images/users/validid';
                    $name = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($path, $name);
                    $data['valid_id'] = "$name";
                } 
                //upload selfie image
                if($images = $request->file('selfie')){
                    $paths = 'front/images/users/selfie';
                    $names = date('YmdHis') . "." . $images->getClientOriginalExtension();
                    $images->move($paths, $names);
                    $data['selfie'] = "$names";
                } 

                //save all the data 
                 //user id
                 //get user_id and save all the data with the user_id
                //  User::create($data);
                $user_id = Auth::user()->id;
                $data['user_id'] = $user_id;
                $data['appstatus'] = 'Pending';
                    // echo "<pre>"; print_r($data); die;
                    PayLaterApplication::create($data);
                $message = "Application is submitted successfully. We will inform you through email for further updates.";
                return redirect('user/pay-later')->with('success_message',$message);

        }
        // return view('front.pay_later.pay_later_application');
    }

}
