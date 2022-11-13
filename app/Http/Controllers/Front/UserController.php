<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\elementType;

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
                $user->status = 0;
                $user->save();

                //send register email 
                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];//infor getting from the user
                Mail::send('emails.register',$messageData,function($message)use($email){ //send the email using mail
                    $message->to($email)->subject('Welcome to P-Store Mart');
                });

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    $redirectTo = url('cart'); //sending to cart page

                    //Update user cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }
            } else{ //error message if fails
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

            
        }
    }

    public function userLogin(Request $request){
        if($request->Ajax()){
            $data = $request->all();

             //requires validation
             $validator = Validator::make($request->all(),[  
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6',
            ]);

            if($validator->passes()){
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>'Your Account is inactive. Please contact Admin.']);
                    }

                    //Update user cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectTo = url('cart'); //sending to cart page
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                } else { //if auth is incorrect
                    return response()->json(['type'=>'incorrect','message'=>'Incorrect Email or Password']);
                }
            } else {
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }
    }

    public function userlogout(){
        Auth::logout();
        return redirect('/');
    }
}

