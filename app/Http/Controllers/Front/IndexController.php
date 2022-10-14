<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    
    public function index(){
        //get all the banners and return in the index file
        $banners = Banner::where('status',1)->get()->toArray();
        return view('front.index')->with(compact('banners'));
    }


}
    