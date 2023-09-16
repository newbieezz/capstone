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
            // dd($data);  
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
                if($request->hasFile('valid_id')){
                    $name = $request->file('valid_id')->getClientOriginalName();
                    $path = $request->file('valid_id')->store('public/front/images/users');
                    $data['valid_id'] = $name;
                } 
                //upload selfie image
                if($request->hasFile('selfie')){
                    $files = $request->file('selfie');
                    $extensions = $files->getClientOriginalExtension();
                    //generate new image name
                    $imageNames = rand(111,99999).'.'.$extensions;
                    $paths = 'front/images/users/'.$imageNames;
                    Image::make($files)->resize(500,500)->save($paths);
                    $data['selfie'] = $imageNames;

                }
                //save all the data 
                 //user id
                 //get user_id and save all the data with the user_id
                //  User::create($data);
                $user_id = Auth::user()->id;
                $data['user_id'] = $user_id;
                $data['appstatus'] = 1;
                    // echo "<pre>"; print_r($data); die;
                    PayLaterApplication::create($data);
                $message = "Application is submitted successfully. We will inform you through email for further updates.";
                return redirect('user/pay-later')->with('success_message',$message);

        }
        // return view('front.pay_later.pay_later_application');
    }

}
