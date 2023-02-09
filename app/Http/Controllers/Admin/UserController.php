<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function users(){
        $users = User::get()->toArray();
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

}
