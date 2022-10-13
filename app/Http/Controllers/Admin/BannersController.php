<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;

class BannersController extends Controller
{
    public function banners(){
        $banners = Banner::get()->toArray();

        return view('admin.banners.banners')->with(compact('banners'));
    }

    //update banner status
    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
           //making the inactive->active, vice versa
           if($data['status']=="Active"){
                   $status = 0;
           } else{
                   $status = 1;
           }
               Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
               //return details into the ajax response so we can add the response as well
               return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }

    // delete banner
    public function deleteBanner($id){
        Session::put('page','banners');
        //get banner image
        $bannerImage = Banner::where('id',$id)->first();
        //get banner image path
        $banner_image_path = 'front/images/banner_images';

        //delete if image exists inside the folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        //delete from table
        Banner::where('id',$id)->delete();
        $message = "Banner has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }
}
