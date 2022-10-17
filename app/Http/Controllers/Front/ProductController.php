<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function listing(){
        //fetch current url route
        $url = Route::getFacadeRoot()->current()->uri();
        //check if url exist in category table or not
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount > 0) {
            //get category details
            $categoryDetails = Category::categoryDetails($url);
            //fetch all the products in the category
            $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])
                                ->where('status',1)->get()->toArray();

            return view('front.products.listing')->with(compact('categoryDetails','categoryProducts'));
        } else {
            abort(404);
        }
    }
}
