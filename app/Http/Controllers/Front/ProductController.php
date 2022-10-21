<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\Brand;
use App\Models\ProductsAttribute;

class ProductController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; //debug to check if data passes
                //fetch current url route
                $url = $data['url'];
                $_GET['sort'] = $data['sort'];
                //check if url exist in category table or not
                $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
                if($categoryCount > 0) {
                    //get category details
                    $categoryDetails = Category::categoryDetails($url);
                    //fetch all the products in the category with use of simple pagination
                    $categoryProducts = Product::with('brands')->whereIn('category_id',$categoryDetails['catIds'])
                                        ->where('status',1);
                      
                    //checking for (filter) dynamically 
                    $productFilters = ProductsFilter::productFilters(); //fetching the product filters
                    foreach($productFilters as $key => $filter){
                        //if particular filter is selected then check if it's coming(calue will come in $data)
                        if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && 
                            !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                            
                            $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                        }
                    }     
                    
                    //checking for size (product attribute)
                    if(isset($data['size']) && !empty($data['size'])){
                        $productIds = ProductsAttribute::select('product_id')->whereIn('size',$data['size'])
                                      ->pluck('product_id')->toArray();//fetching th product Ids
                        $categoryProducts->whereIn('products.id',$productIds);
                    }

                    //checking for price
                    if(isset($data['price']) && !empty($data['price'])){
                        foreach($data['price'] as $key => $price){
                            $priceArray = explode('-',$price);//every price will convert to an element of an array
                            $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArray[0],$priceArray[1]])
                                            ->pluck('id')->toArray();//fetching th product Ids
                        
                        }
                        $productIds = call_user_func_array('array_merge',$productIds);//merge all the products into one array
                        $categoryProducts->whereIn('products.id',$productIds);
                    }

                    //checking for product brand
                    if(isset($data['brand']) && !empty($data['brand'])){
                        $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])
                                      ->pluck('id')->toArray();//fetching th product Ids
                        $categoryProducts->whereIn('products.id',$productIds);
                    }

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
                $categoryProducts = Product::with('brands')->whereIn('category_id',$categoryDetails['catIds'])
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
