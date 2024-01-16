<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationStatus;
use App\Models\Paylater;
use App\Models\PayLaterApplication;
use App\Models\PaylaterApplicationStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    
    public function users(){
        $users = User::get()->toArray();
        Session::put('page','view_users');
        // dd($users);
        return view('admin.users.users')->with(compact('users'));//users array return to blade file
    }

    public function updateUserStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status'] == "Active"){
                $status = 0;
            } else {
                $status = 1;
            }

            User::where('id',$data['user_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'user_id'=>$data['user_id']]);
        }
    }

    public function usersPayLater(){
        Session::put('page','users_paylater');
        $users = PayLaterApplication::get()->toArray();
        // dd($users);
        $statuses = PaylaterApplicationStatus::get()->toArray();
        return view('admin.users.user_paylater_application')->with(compact('users','statuses'));
    }

    public function updateAppstatus(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
             $users = PayLaterApplication::get()->toArray();
            // dd($data);
            // dd($users);

            PayLaterApplication::where('id',$data['app_id'])->update(['appstatus'=>$data['appstatus']]);
            User::where('id',$data['app_id'])->update(['bnpl_status'=>$data['appstatus']]);
            //send order status update email
            $user = User::first()->toArray();
            // dd($user['name']);
                $email = $user['email'];
                $messageData = [
                    'email' => $email,
                    'name' => $user['name'],
                    'appstatus' => $data['appstatus']
                ];
                Mail::send('emails.user_paylater_application_status',$messageData,function($message)use($email){
                    $message->to($email)->subject('PayLater Application Update - P-Store Mart');
                });

            //error in message part
            // Notification::insert([
            //     'module' => 'paylater',
            //     'module_id' => $data['app_id'],
            //     'user_id' => $user['id'],
            //     'sender' => 'admin',
            //     'receiver' => 'customer',
            //     'message' => "Your submitted paylater application form has been  " . $data['appstatus']
            // ]);
            $message = "Application Status has been updated successfully!";
            return redirect()->back()->with('success_message',$message);
        }
        
    }
    public function deleteApplication($id){
        PayLaterApplication::where('id',$id)->delete();
        $message = "Application has been";
    }

    public function viewloan(){
        Session::put('page','loans');
        $loans = Paylater::get()->toArray();

        
    //    dd($loans);
       return view('admin.paylater.loan')->with(compact('loans'));

    }

}
