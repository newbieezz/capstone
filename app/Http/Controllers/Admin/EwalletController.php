<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin as ModelsAdmin;
use Illuminate\Http\Request;
use App\Models\Ewallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionFee;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\WalletTransaction;
use App\Models\Notification;

use Illuminate\Support\Facades\DB;
// use Intervention\Image\Facades\Image;
use Intervention\Image\Facades\Image;


class EwalletController extends Controller
{

    public function addFunds(Request $request)
    {
        Session::put('page','wallet');
        // $vendor = Vendor::where('id',Auth::guard('admin')->user()->id)->first()->toArray();
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',Auth::guard('admin')->user()->id)->first();
        // dd( $vendorDetails);
        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
        //     $rules = [
        //         'amount' => 'required',
        //         'proof_image' => 'required',
        // ];
        //     $this->validate($request,$rules);
            // Upload wallet Image/Photo
            // if($image = $request->file('proof_image')){
            //     $path = 'admin/images/gcashproofs';
            //     $name = date('YmdHis') . "." . $image->getClientOriginalExtension();
            //     $image->move($path, $name);
            //     $data['proof_image'] = "$name";
            // } 
            
            $admin_id = Auth::guard('admin')->user()->id;

            $walletTransaction = new WalletTransaction;
            $walletTransaction->admin_id = $admin_id;
            $walletTransaction->transaction_type = "add";
            $walletTransaction->amount = $data['transferAmount'];
            $walletTransaction->status = "Pending";
            $walletTransaction->reference = mt_rand(100000,999999);
            if($request->hasFile('proof_image')){
                $image_tmp = $request->file('proof_image');
                if($image_tmp->isValid()){
                    // Building function to get the image extension of the file
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/proofs/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);

                }
            }
            $walletTransaction->proof_image = $data['proof_image'];
            // dd($data['id']);
            // $data['id'];
            // dd($data);
            $admin = 0;
            $walletTransaction->save();
            //insert notif to admin
            Notification::insert([
                'module' => 'walletRequest',
                'module_id' => $admin_id,
                'user_id' => $admin,
                'sender' => 'vendor',
                'receiver' => 'admin',
                'message' => $vendorDetails['name']. 'requested to add'.$data['transferAmount'].' wallet funds. Click to Respond' 
            ]);
            return redirect()->back()->with('success_message','Your request has been sent! Please wait for our approval');
        }
        return view('admin.wallet.ewallet')->with(compact('vendorDetails'));

    }

    public function viewWalletTransaction(){
        Session::put('page','wallet');
        $walletTransactions = WalletTransaction::get()->toArray();
        // dd($walletTransactions);
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->get()->first();
        $admin_id = Auth::guard('admin')->user()->id;
        $admin = Admin::where('id',$admin_id)->get()->first();
        // dd($admin);
        return view('admin.wallet.viewwallet')->with(compact('walletTransactions','vendorDetails','admin'));

    }

    public function updateVendorWallet(Request $request, $id){
        Session::put('page','wallet');
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank','wallet_transactions')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        // $walletRequest = WalletTransaction::where('admin_id',$vendorDetails['vendor_id'])->first()->toArray();
        // dd($vendorDetails);

        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);  
            $status = 'Updated';
            $newBalance = $data['amount'] + $vendorDetails['vendor_personal']['wallet_balance'];
            // dd($newBalance);
            Vendor::where('id',$data['vendor_id'])->update(['wallet_balance'=>$newBalance]);
            WalletTransaction::where('admin_id',$data['vendor_id'])->update(['status'=>$status]);
            return redirect()->back()->with('success_message','Vendor wallet balance updated successfully');
        
        }
        return view('admin.wallet.update_vendor_wallet')->with(compact('vendorDetails'));

    }
}
