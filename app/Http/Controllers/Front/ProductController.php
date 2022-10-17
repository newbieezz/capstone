<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class ProductController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
                //fetch current url route
                $url = $data['url'];
                $_GET['sort'] = $data['sort'];
                //check if url exist in category table or not
                $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
                if($categoryCount > 0) {
                    //get category details
                    $categoryDetails = Category::categoryDetails($url);
                    //fetch all the products in the category with use of simple pagination
                    $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
                                        ->where('status',1);
                    //condition for sorting
                    if(isset($_GET['sort']) && !empty($_GET['sort'])){
                        if($_GET['sort']=="product_latest"){
                            //if true, show latest product in desc order
                            $categoryProducts->orderby('products.id','Desc');
                        } else if($_GET['sort']=="price_lowest"){
                            //show in asscending then compare the price
                            $categoryProducts->orderby('products.product_price','Asc');
                        } else if($_GET['sort']=="price_highest"){
                            //show in asscending then compare the price
                            $categoryProducts->orderby('products.product_price','Desc');
                        } else if($_GET['sort']=="name_a_z"){
                            //show name in asscending 
                            $categoryProducts->orderby('products.product_name','Asc');
                        } else if($_GET['sort']=="name_z_a"){
                            //show name in desc
                            $categoryProducts->orderby('products.product_name','Desc');
                        }
                    }               
                    
                    $categoryProducts = $categoryProducts->paginate(20);

                    return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
                } else {
                    abort(404);
                }
        } else{
            //fetch current url route
            $url = Route::getFacadeRoot()->current()->uri();
            //check if url exist in category table or not
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount > 0) {
                //get category details
                $categoryDetails = Category::categoryDetails($url);
                //fetch all the products in the category with use of simple pagination
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
                                    ->where('status',1);
                //condition for sorting
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        //if true, show latest product in desc order
                        $categoryProducts->orderby('products.id','Desc');
                    } else if($_GET['sort']=="price_lowest"){
                        //show in asscending then compare the price
                        $categoryProducts->orderby('products.product_price','Asc');
                    } else if($_GET['sort']=="price_highest"){
                        //show in asscending then compare the price
                        $categoryProducts->orderby('products.product_price','Desc');
                    } else if($_GET['sort']=="name_a_z"){
                        //show name in asscending 
                        $categoryProducts->orderby('products.product_name','Asc');
                    } else if($_GET['sort']=="name_z_a"){
                        //show name in desc
                        $categoryProducts->orderby('products.product_name','Desc');
                    }
                }               
                
                $categoryProducts = $categoryProducts->paginate(20);

                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            } else {
                abort(404);
            }
        }

    }
}
