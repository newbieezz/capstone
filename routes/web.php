<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

//Route Group for the Admin and Login
//Admin is required to admin route links
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    //Admin Login Route 
    Route::match(['get','post'],'login','AdminController@login');

    //Addning the dashboard of the Admin Middleware
    Route::group(['middleware' => ['admin']], function() {
    //All this routes will come/execute after admin login
        //Admin Dashboard Route 
         Route::get('dashboard','AdminController@dashboard');

        // Update Admin Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');

         // Check Admin Password
         Route::post('check-admin-password','AdminController@checkAdminPassword'); //checkAdminPassword will be created in the AdminController

        // Update Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        // Update Vendor Details (slug will work for updates on all vendor such as personal, bank etc.)
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');

        // View Admin / Subadmins / Vendors
        Route::get('admins/{type?}','AdminController@admins');

        // Display/View Vendor Details by the Admin
        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');
         
        // Update Admin Status
        Route::post('update-admin-status','AdminController@updateAdminStatus');
        
        //Admin Logout
         Route::get('logout','AdminController@logout');


        // SECTIONS
        Route::get('sections','SectionController@sections');
        // Update Section Status
        Route::post('update-section-status','SectionController@updateSectionStatus');
        // Delete Section Functionality 
        Route::get('delete-section/{id}','SectionController@deleteSection');
        // Add Section Functionality 
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

        // CATEGORIES
        Route::get('categories','CategoryController@categories');
        // Update Category Status
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        // Add-Edit Category
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        // Get route for the subcategory
        Route::get('append-categories-level','CategoryController@appendCategoryLevel');
        // Delete Category Functionality 
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        // Delete Category Image Functionality 
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

        // BRANDS
        Route::get('brands','BrandController@brands');
        // Update Brand Status
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        // Delete Brand Functionality 
        Route::get('delete-brand/{id}','BrandController@deleteBrand');
        // Add Brand Functionality 
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

        // PRODUCtS
        Route::get('products','ProductsController@products');
        // Update Product Status
        Route::post('update-product-status','ProductsController@updateProductStatus');
        // Delete Product Functionality 
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        // Add-Edit Product
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        //Delete Image
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        //Delete Video
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

        //ATTRIBUTES
        Route::match(['get','post'],'add-edit-attributes/{id?}','ProductsController@addAttributes');
        // Update Attribute Status
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        // Delete Attribute Functionality 
        Route::get('delete-atttribute/{id}','ProductsController@deleteAttribute');
        // Edit/Update Attribute
        Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttributes');

        //IMAGES
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
         // Update Image Status
        Route::post('update-image-status','ProductsController@updateImageStatus');
        // Delete Image Functionality 
        Route::get('delete-image/{id}','ProductsController@deleteImage');

        //BANNERS
        Route::get('banners','BannersController@banners');
        // Update BannerStatus
        Route::post('update-banner-status','BannersController@updateBannerStatus');
         // Delete Banner Functionality 
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
        // Add-Edit Banner
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');
    });
});

//Route Group for the Front Views 
Route::namespace('App\Http\Controllers\Front')->group(function(){
    //Route for the Index page
    Route::get('/','IndexController@index');
    //dynamic routes for the product listing page fetch by category
    $catUrl = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach($catUrl as $key => $url) {
        Route::get('/'.$url,'ProductController@listing');
    }

});
