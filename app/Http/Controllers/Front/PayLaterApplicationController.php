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
    public function application(Request $request,$vendorid){
        $getVendorShop = Vendor::getVendorShop($vendorid);
        // dd($vendorid);

        $users = User::where('credit_score','>=',3000)->get()->toArray();
        if($request->isMethod('post')){
            $data = $request->all();
            $vendorid = $data['vendor_id'];
            // $garantorname = $users['name'];
            $userid = Auth::user()->id;

        // dd($data);

        }
        return view('front.pay_later.pay_later_application')->with(compact('users','vendorid'));    

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
        $getVendorShop = Vendor::getVendorShop($vendorid);
            // dd($vendorid);

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                    'garantor_name' => 'required',
                    'garantor_lname' => 'required',
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
                $paylaterapp = new PayLaterApplication;
                $paylaterapp['user_id'] = Auth::user()->id;
                $paylaterapp['vendor_id'] = $vendorid;
                $paylaterapp['work'] = $data['work'];
                $paylaterapp['salary'] = $data['salary'];
                $paylaterapp['valid_id'] = $name;
                $paylaterapp['selfie'] = $names;
                $paylaterapp['appstatus'] = 'Pending';
                $paylaterapp['garantor_id'] = $data['garantor_id'];
                $paylaterapp['garantor_name'] = $data['garantor_name']; 
                $paylaterapp['garantor_lname'] = $data['garantor_lname']; 
                $paylaterapp->save();
                    // dd($data);
                    
                // User::where('id',Auth::user()->id)->update(['bnpl_status'=>'Pending']);

                $message = "Application is submitted successfully. We will inform you through email for further updates.";
                return redirect('products/'.$vendorid)->with('success_message',$message);

        }
        // return view('front.pay_later.pay_later_application');
    }
}
