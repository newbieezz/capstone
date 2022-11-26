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
use Illuminate\Support\Str;
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

                //activte the user only when user confirms his email acc (with confirmation email)
                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'email'=>$data['email'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation',$messageData,function($message)use($email){ //send the email using mail
                        $message->to($email)->subject('Confirm your P-Store Marts Account.');
                    });
                //redirect user with successs message
                $redirectTo = url('user/login-register');
                return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Please confirm your email to activate your account!']);

                //send register email then activate user acc (no confirmation email)
                // $email = $data['email'];
                // $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];//infor getting from the user
                // Mail::send('emails.register',$messageData,function($message)use($email){ //send the email using mail
                //     $message->to($email)->subject('Welcome to P-Store Mart');
                // });

                // if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                //     $redirectTo = url('cart'); //sending to cart page

                //     //Update user cart with user id
                //     if(!empty(Session::get('session_id'))){
                //         $user_id = Auth::user()->id;
                //         $session_id = Session::get('session_id');
                //         Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                //     }
                    
                //     return response()->json(['type'=>'success','url'=>$redirectTo]);
                // }

            } else{ //error message if fails
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

            
        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();

             //requires validation
             $validator = Validator::make($request->all(),[  
                'name' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'address' => 'required|string|max:100',
                'zipcode' => 'required|numeric',
                'mobile' => 'required|numeric|digits:11',
                ]
            );

            if($validator->passes()){

                //Update User Details inside the users table
                User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'address'=>$data['address'],'city'=>$data['city'],
                        'zipcode'=>$data['zipcode'],'mobile'=>$data['mobile']]);

                //redirect user with success message
                return response()->json(['type'=>'success','message'=>'Your contact details is successfully updated!']);
                
            } else{ //error message if fails
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        } else {
            return view('front.users.user_account');
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
                        return response()->json(['type'=>'inactive','message'=>'Your Account is not activated! Please confirm your email.']);
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

    public function confirmAccount(Request $request, $code){
        $email = base64_decode(($code));
        $userCount = User::where('email',$email)->count(); //check in the table if email exists

        if($userCount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){ //chechk the status     
                return redirect('user/login-register')->with('error_message','Your account is already activated. You can now login.');
            }else {
                User::where('email',$email)->update(['status'=>1]);

                $messageData = ['name'=>$userDetails->name,'mobile'=>$userDetails->mobile,'email'=>$email];//infor getting from the user
                Mail::send('emails.register',$messageData,function($message)use($email){ //send the email using mail
                    $message->to($email)->subject('Welcome to P-Store Mart');
                });
                return redirect('user/login-register')->with('success_message','Your account is activated. You can now login.');
            }
        } else {
            abort(404);
        }


    }

    public function forgotPassword(Request $request){
        //get data in ajax
        if($request->ajax()){
            $data = $request->all();

            //requires validation
            $validator = Validator::make($request->all(),[  
                'email' => 'required|email|max:150|exists:users'
                ],
                    [ //custom message
                        'email.exists' => 'Email does not exists!'
                    ]
            );
            if($validator->passes()){
                //generate new password
                $new_password = Str::random(16);
                //update user acc with new password
                User::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);

                //get user detail to fetch the name etc.
                $userDetails = User::where('email',$data['email'])->first()->toArray();
                
                //send email to the user 
                $email = $data['email'];
                $messageData = ['name'=>$userDetails['name'],'email'=>$email,'password'=>$new_password];
                Mail::send('emails.user_forgot_password',$messageData,function($message)use($email){
                    $message->to($email)->subject('New Password - P-Store Account');
                });

                //redirect user with success message
                return response()->json(['type'=>'success','message'=>'New Password has been sent to your registered email.']);
            
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        } else {
            return view('front.users.forgot_password');
        }
    }

    public function userlogout(){
        Auth::logout();
        return redirect('/');
    }
}

