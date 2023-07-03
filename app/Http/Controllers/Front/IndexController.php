<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetails;

class IndexController extends Controller
{
    
    public function index(){
        //get all the banners and return in the index file
        $sliderbanners = Banner::where('type','Slider')->where('status',1)->get()->toArray();
        $fixbanners = Banner::where('type','Fix')->where('status',1)->get()->toArray();
        //fetch the products from the products table and show the last 8 products  added
        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(8)->get()->toArray();
        //query for showing the bestseller products
        $bestSeller = Product::where(['is_bestseller'=>'Yes','status'=>1])->inRandomOrder()->get()->toArray();
        //show products with discounted price
        $discountedProds = Product::where('product_discount','>',0)->where('status',1)->limit(4)->inRandomOrder()->get()->toArray();
        //dd($discountedProds);
        //query for showing the featured products
        $featured = Product::where(['is_featured'=>'Yes','status'=>1])->inRandomOrder()->get()->toArray();
        $vendor = Vendor::orderBy('id','Desc')->where('status',1)->limit(10)->get()->toArray();
        $getVendorDetails = VendorsBusinessDetails::get()->toArray();

        return view('front.index')->with(compact('sliderbanners','fixbanners','newProducts','bestSeller','discountedProds','featured','vendor','getVendorDetails'));
    }

    public function about(){
        return view('front.layout.about');
    }

    public function terms(){
        return view('front.layout.terms');
    }

}
    