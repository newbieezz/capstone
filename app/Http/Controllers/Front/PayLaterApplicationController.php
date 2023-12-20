<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PayLaterApplication;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Vendor;

class PayLaterApplicationController extends Controller
{
    public function application(Request $request){
        

            // $users = User::orderBy('created_at','DESC')->where('credit_score', '>=', 3000)->get();
            $users = User::where('name','LIKE','%'.request('search').'%')->get()->first();
            
            if(request()->has('search')){
                if($users['credit_score'] >= 3000){
                    // $users = User::where('name','LIKE','%'.request('search').'%')->get();
                    // dd($users['name']);
                    // dd($users['credit_score']);

                    return view('front.pay_later.pay_later_application')->with(compact('users'));
                } else {
                    $message = "This user does not have enough credit score to be a guarantor. Try to look for another one.";
                    // return redirect()->back()->with('success_message','Product has been added to Cart!');
                return view('front.pay_later.pay_later_application')->with('error_message','Product has been added to Cart!');

                    
                }

            }
        if($request->isMethod('post')){
            $data = $request->all();
        // dd($data);
            $vendorid = $data['vendor_id'];
            $garantorname = $users['name'];
            $userid = Auth::user()->id;


        }
        return view('front.pay_later.pay_later_application')->with(compact('vendorid','users'));    

    }

    public function search(Request $request)
    {
        $users = User::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->orWhere('email', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(6);

        return view('users.index', compact('users'));
    }

    public function saveApplication(Request $request,$vendorid){
            // dd($vendorid);  

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                    'garantor_name' => 'required',
                    'work' => 'required',
                    'salary' => 'required',
                    'valid_id' => 'required',
                    'selfie' => 'required',
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
               
        
                 //get user_id and save all the data with the user_id
                //  User::create($data);
                //save all the data 
                $user_id = Auth::user()->id;
                $data['user_id'] = $user_id;
                $data['appstatus'] = 'Pending';
                $data['vendor_id'] = $vendorid;
                
                    // echo "<pre>"; print_r($data); die;
                    PayLaterApplication::create($data);
                    
                User::where('id',$user_id)->update(['bnpl_status'=>'Pending']);

                $message = "Application is submitted successfully. We will inform you through email for further updates.";
                return redirect('user/pay-later')->with('success_message',$message);

        }
        // return view('front.pay_later.pay_later_application');
    }

    

}
