<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
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
            // Add Product Functionality
            $title = "Add Product";
            $product = new Product;
            $getCategories = array();
            $message = "Product added successfully!";
        } else {
            // Edit Functionality
            $title = "Edit product";
            $product = Product::find($id);
            //getting the categories along with then subproduct, gets the subcategories also
            $getProduct = Product::with('subcategories')->where(['parent_id'=>0,'section_id'=>$product['section_id']])->get();
            $message = "product updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            // Array of Validation Rules
            $rules = [
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];
            $customMessages = [
                'product_name.required' => 'product Name is required!',
                'product_name.regex' => 'Valid product Name is required!',
                'section_id.required' => 'Section is required!',
                'url.required' => 'product URL is required!',
            ];
                $this->validate($request,$rules,$customMessages);

            if($data['product_discount']==""){
                $data['product_discount'] =0;
            }

                // Upload product Image/Photo
                if($request->hasFile('product_image')){
                    $image_tmp = $request->file('product_image');
                    if($image_tmp->isValid()){
                        // Building function to get the image extension of the file
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new image name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'front/images/product_images/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                        // Save the Image
                        $product->product_image = $imageName;
                    }
                } else {
                    $product->product_image = "";
                }

                $product->section_id = $data['section_id'];
                $product->parent_id = $data['parent_id'];
                $product->product_name = $data['product_name'];
                $product->product_discount = $data['product_discount'];
                $product->description = $data['description'];
                $product->url = $data['url'];
                $product->meta_title= $data['meta_title'];
                $product->meta_description = $data['meta_description'];
                $product->meta_keywords = $data['meta_keywords'];
                $product->status = 1;
                $product->save();

                return redirect('admin/products')->with('success_message', $message);
        }

        // $getSections = Section::get()->toArray();

        return view('admin.products.add_edit_product')->with(compact('title','product','getSections','getProducts'));
    }

        // delete product
    public function deleteProduct($id){
        Session::put('page','products');
        //delete from categories table by id
        Product::where('id',$id)->delete();
        $message = "Product has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }
}
