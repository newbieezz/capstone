<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
    }

    public function userRegister(Request $request ){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //requires validation
            $validator = Validator::make($request->all(),[  
                'name' => 'required|string|max:100',
                'mobile' => 'required|numeric|digits:11',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:6',
                'accept' => 'required'
                ],
                    [ //custom message
                        'accept.required' => 'Kindly accept our Terms & Conditions.'
                    ]
            );
 
            //if all the validation passed
            if($validator->passes()){
                //register the user
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);//encrypt in hash
                $user->status = 1;
                $user->save();

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    $redirectTo = url('cart'); //sending to cart page
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }
            } else{ //error message if fails
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

            
        }
    }

    public function userlogout(){
        Auth::logout();
        return redirect('/');
    }
}

