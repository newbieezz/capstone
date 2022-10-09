<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function products(){
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }])->get()->toArray(); //subquery-> add the section and category relation
        return view('admin.products.products')->with(compact('products'));
    }

        // Update Product Status
    public function updateProductStatus(Request $request){
        if($request->ajax()){
             $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                    $status = 0;
            } else{
                    $status = 1;
            }
                Product::where('id',$data['product_id'])->update(['status'=>$status]);
                //return details into the ajax response so we can add the response as well
                return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
         }
    }
    
    // Add-Edit product
    public function addEditProduct(Request $request, $id=null){
        Session::put('page','products');
        if($id==""){
            Session::put('page','products');
            // Add Product Functionality
            $title = "Add Product";
            $product = new Product;
            $message = "Product added successfully!";
        } else {
            // Edit Functionality
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product updated successfully!";
        }
        //get the data
        if($request->isMethod('post')){
            $data = $request->all();
                
              // Array of Validation Rules
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required',
                'product_price' => 'required|numeric',
            ];
            $customMessages = [
                'category_id.required' => 'Category is required!',
                'product_name.required' => 'Product Name is required!',
                'product_code.required' => 'Product Code is required!',
                'product_price.required' => 'Product Price is required!',
                'product_price.numeric' => 'Valid Product Price is required!',
            ];
                $this->validate($request,$rules,$customMessages);

            //Upload product image after resize, small250x250, medium500x500, large1000x1000
                if($request->hasFile('product_image')){
                    $image_tmp = $request->file('product_image');
                    if($image_tmp->isValid()){
                        // Building function to get the image extension of the file
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new image name
                        $imageName = rand(111,99999).'.'.$extension;
                        $largeImagePath = 'front/images/product_images/large/'.$imageName;
                        $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                        $smallImagePath = 'front/images/product_images/small/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                        Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                        Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                        $product->product_image = $imageName;

                    }
                } 
                //Upload the product video
                if($request->hasFile('product_video')){
                    $video_tmp = $request->file('product_video');
                    if($video_tmp->isValid()){
                        //Upload the video in folder
                        $extension = $video_tmp->getClientOriginalExtension();
                        $videoName = rand(111,99999).'.'.$extension;
                        //modify the video name
                        $videoPath = 'front/videos/product_videos/';
                        //move the image from tmp to actual folder
                        $video_tmp->move($videoPath,$videoName);

                        //Insert video name in products table
                        $product->product_video = $videoName;
                    }
                }
            
             //insert/save the data into the products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            //save the category id from the form
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            //fetch the admin type using the auth::guard
            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;
            //saving in the products table
            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if($adminType=="vendor"){
                $product->vendor_id = $vendor_id;
            }else {
                $product->vendor_id = 0;
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();
            return redirect('admin/products')->with('success_message', $message);

        }


        // get sections with categories and sub categories
        $categories = Section::with('categories')->get()->toArray();
        // get all the brands
        $brands = Brand::where('status',1)->get()->toArray();
        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product'));
    }


     // delete product
    public function deleteProduct($id){
        Session::put('page','products');
        //delete from categories table by id
        Product::where('id',$id)->delete();
        $message = "Product has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }
    //delete product image
    public function deleteProductImage($id){
        //get the image from the product folder and database
        $productImage = Product::select('product_image')->where('id',$id)->first();

        //get image paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        //delete small image if exist in small folder
        if(file_exists($small_image_path.$productImage->product_image)){
            unlink($small_image_path.$productImage->product_image);
        }
                //delete medium image if exist in medium folder
        if(file_exists($medium_image_path.$productImage->product_image)){
            unlink($medium_image_path.$productImage->product_image);
        }
                //delete large image if exist in large folder
        if(file_exists($large_image_path.$productImage->product_image)){
            unlink($large_image_path.$productImage->product_image);
        }

        //delete products image from products table
        Product::where('id',$id)->update(['product_image'=>'']);
        $message = "Product Image has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }

    //delete product video
    public function deleteProductVideo($id){
        //get the video from the product folder and database
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        //get video path
        $product_video_path = 'front/videos/product_videos/';

        //delete video if exist in folder
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video); 
        }

        //delete video from table
        Product::where('id',$id)->update(['product_video'=>'']);
        $message = "Product Video has been deleted successfully";
        return redirect()->back()->with('success_message',$message);

    }
}
