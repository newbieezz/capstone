<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CreditLimit;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\ProductsAttribute;
use App\Models\Installment;
use App\Models\Paylater;
use App\Models\Vendor;
use App\Models\Notification;
use App\Models\PayLaterApplication;
use App\Models\TransactionFee;
use App\Models\User;
use App\Models\VendorsBusinessDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

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
                    $productIds = array();
                    if(isset($data['price']) && !empty($data['price'])){
                        foreach($data['price'] as $key => $price){
                            $priceArray = explode('-',$price);//every price will convert to an element of an array
                            if(isset($priceArray[0]) && isset($priceArray[1])){ //condition that both value that's been clicked/executed must come
                                $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArray[0],$priceArray[1]])
                                            ->pluck('id')->toArray();//fetching th product Ids
                            }
                            $productIds = array_unique(array_flatten($productIds));//flatten works like array merge /removes duplicates array(unique)
                            $categoryProducts->whereIn('products.id',$productIds);

                        }
                        $productIds = call_user_func_array('array_merge',$productIds);//merge all the products into one array
                        $categoryProducts->whereIn('products.id',$productIds);
                    }

                    //checking for product brand
                    if(isset($data['brands']) && !empty($data['brands'])){
                        $productIds = Product::with('brands')->select('id')->whereIn('brand_id',$data['brands'])
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

    //detail.blade.php list of products details
    public function detail($id){
        $productDetails = Product::with(['section','category'=>function($query){
                            $query->where('status',1);
                         },'images','brands','vendor'])->find($id)->toArray();
        //call category for the breadcrumbs, pass the urlt o get the complete category details
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        // dd($categoryDetails);

        //get related/similar products ids
        $similarProducts = Product::with('brands')->where('category_id',$productDetails['category']['id'])
                            ->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();

        //set sessio for recently viewed products
        if(empty(Session::get('session_id'))){ //if empty then create variable session_id
            $session_id = rand(10000,10000000);
        } else {
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id); 

        //insert product in table if not already exists, count recent;y viewd products first
        $countRVP = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRVP==0){
            date_default_timezone_set("Asia/Taipei");
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id,
                        'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]); //insert in the table
        }
        //get recently viewed products,fetch the id from the table
        $recentProductsId = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)
                            ->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');

        //fetch the porducts, get recently viewed products
        $recenltyViewedProd = Product::with('brands')->whereIn('id',$recentProductsId)->get()->toArray();

        $totalStock = Product::where('id',$id)->sum('stock_quantity');
        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recenltyViewedProd'));
    }

    //get the price
    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function vendorListing($vendorid){
        //fetch/get vendor shop name
        $getVendorShop = Vendor::getVendorShop($vendorid);
        //get vendor products
        $vendorProducts = Product::with('brands')->where('vendor_id',$vendorid)->where('status',1);
        // $productDetails = Product::with(['section','category','attributes'=>function($query){
        //     $query->where('stock','>',0)->where('status',1);
        //  },'images','brands','vendor'])->find($vendorid)->toArray();
        $details = PayLaterApplication::where('vendor_id',$vendorid)->get()->toArray();
        // $userdetails = User::where('id',$detail[])->first();
        // dd($details);

        $vendorProducts = $vendorProducts->paginate(12);
       return view('front.products.vendor_listing')->with(compact('details','getVendorShop','vendorProducts','vendorid'));
    }

    public function cartAdd(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            if($data['quantity'] == 0){
                $data['quantity'] = 1; 
            }

            //check product stock is available or not
            $getStock = Product::getStock($data['product_id']);
            // dd($getStock);
            //condition if stock less than number of product stock
            if($getStock<$data['quantity']){
                return redirect()->back()->with('error_message','Required Quantity is not available!');
            }

            //generate session id if not exists
            $session_id = Session::get('session_id');//check
            if(empty($session_id)){
                $session_id = Session::getId(); //if not exist then generate
                Session::put('session_id',$session_id);
            }

            //check product if already exists in the user cart
            if(Auth::check()){ //check is the function used to chek if user exist/logged in or not
                //user is logged in, then count prods &compare user id
                $user_id = Auth::user()->id;//get user id
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();

            } else{
                //user is not logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();

            }

            if($countProducts>0){
                return redirect()->back()->with('error_message','Product already existed in Cart!');
            }
            //save/add products in carts table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();
            // dd($data);
            return redirect()->back()->with('success_message','Product has been added to Cart!');
        }
    }

    public function cart(){
        $getCartItems = Cart::getCartItems();
        
        // dd($getCartItems);
        $groupedProducts = [];
        foreach ($getCartItems as $item) {
            $vendorShop = $item['product']['vendor_id'];
            if (!isset($groupedProducts[$vendorShop])) {
                $groupedProducts[$vendorShop] = [];
            }
            $groupedProducts[$vendorShop][] = $item;
        }

        // dd($groupedProducts);

        return view('front.products.cart')->with(compact('getCartItems','groupedProducts'));
    }

    public function cartUpdate(Request $request){
        if($request->ajax()){
            $data = $request->all();

            //get cart details from cartid
            $cartDetails = Cart::find($data['cartid']);

            //get available product stock
            $availableStock = Product::select('stock_quantity')->where(['id'=>
                    $cartDetails['product_id']])->first()->toArray();

            //check availability of stock
            if($data['qty'] > $availableStock['stock_quantity']){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Stock is not available!',
                    'view'=>(String)View::make('front.products.cart_items')
                     ->with(compact('getCartItems'))
             ]);
            }   

            // //chech if product size is available
            // $availableSize = Product::where(['id'=>$cartDetails['product_id'],
            //             'size'=>$cartDetails['size'],'status'=>1])->count();
            // if($availableSize == 0){
            //     $getCartItems = Cart::getCartItems();
            //     return response()->json([
            //         'status'=>false,
            //         'message'=>'Product Size is not available. Please remove this Product and choose another one!',
            //         'view'=>(String)View::make('front.products.cart_items')
            //          ->with(compact('getCartItems'))
            //      ]);
            // }
            
            //update qty in carts table
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems(); //call cartitems to pass
            $groupedProducts = [];
            $totalCartItems = totalCartItems();
            foreach ($getCartItems as $item) {
                $vendorShop = $item['product']['vendor_id'];
                if (!isset($groupedProducts[$vendorShop])) {
                    $groupedProducts[$vendorShop] = [];
                }
                $groupedProducts[$vendorShop][] = $item;
            }
            return response()->json([
                   'status'=>true,
                   'totalCartItems'=>$totalCartItems,
                   'view'=>(String)View::make('front.products.cart_items')
                    ->with(compact('getCartItems','groupedProducts'))
            ]);
        }   
    }

    public function cartDelete(Request $request){
        if($request->ajax()){
            $data = $request->all();

            Cart::where('id',$data['cartid'])->delete();
            $getCartItems = Cart::getCartItems(); //call cartitems to pass
            $totalCartItems = totalCartItems();
            $groupedProducts = [];
            foreach ($getCartItems as $item) {
                $vendorShop = $item['product']['vendor_id'];
                if (!isset($groupedProducts[$vendorShop])) {
                    $groupedProducts[$vendorShop] = [];
                }
                $groupedProducts[$vendorShop][] = $item;
            }
            return response()->json([
                   'totalCartItems'=>$totalCartItems,
                   'view'=>(String)View::make('front.products.cart_items')
                    ->with(compact('getCartItems','groupedProducts'))
            ]);
        }
    }
    
    //check out by store
    public function checkout(Request $request, $id=null){
            $deliveryAddresses = DeliveryAddress::deliveryAddresses(); //show the addresses
            $getCartItems = Cart::getCartItems();
            // dd($deliveryAddresses);
            if($image = $request->file('valid_id')){
                $path = 'front/images/users/validid';
                $name = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($path, $name);
                $data['valid_id'] = "$name";
            }
            
            //if cart is empty then redirect user to the cart page
            if(count($getCartItems) == 0){
                $message = "Cart is empty! Please add some Products to checkout";
                return redirect('cart')->with('error_message',$message);
            }
            // dd($getCartItems);
            //group the cart items by vendor
            foreach ($getCartItems as $item) {
                $vendorShop = $item['product']['vendor_id'];
                if (!isset($groupedProducts[$vendorShop])) {
                    $groupedProducts[$vendorShop] = [];
                }
                $groupedProducts[$vendorShop][] = $item;
            }

            //get the selected vendor
            $selectedVendorId = $item['product']['vendor_id'] ;
            $vendorinstallment = Vendor::with('vendorshopdetails')->where('id',$selectedVendorId )->first();
                        // dd($vendorinstallment['vendorshopdetails']['installment_weeks']);
            $installment_details = [];

            $installment_details['weeks'] = $vendorinstallment['vendorshopdetails']['installment_weeks'];
            $installment_details['rate'] = $vendorinstallment['vendorshopdetails']['interest'];

            
            $paylater_application = PayLaterApplication::where('appstatus', 'Approved')
                    ->where('vendor_id', $item['product']['vendor_id'])
                    ->where('user_id', Auth::user()->id)
                    ->with(['users', 'vendor', 'garantor'])
                    ->first();

            // $status = PayLaterApplication::get()->first()->toArray();
            $userpl = User::where('id',Auth::user()->id)->first()->toArray();
            // dd($selectedVendorId );
            //get the items for the selected vendor
            if(isset($groupedProducts[$selectedVendorId])){
                $selectedVendorItems = $groupedProducts[$selectedVendorId];
                $total_price = 0 ;
            }

            if($request->isMethod('post')){ 
                $data = $request->all();
                $image = $request->file('valid_id');
                if($image){
                    $path = 'front/images/users/validid';
                    $name = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($path, $name);
                    $data['valid_id'] = "$name";
                }
                // echo "<pre>"; print_r($data);

                //check the delivery address id if delivery address ic clicked 
                    if(empty($data['address_id'])){
                        $message = "Please select Delivery Address! ";
                        // return redirect()->back()->with('error_message',$message);
                    }

                    //payment method validation
                    if(empty($data['payment_gateway'])){
                        $message = "Please select Payment Methods! ";
                        return redirect()->back()->with('error_message',$message);
                    }

                    //terms and condition validation
                    if(empty($data['accept'])){
                        $message = "Please agree to the Terms & Condition! ";
                        return redirect()->back()->with('error_message',$message);
                    }

                    //get the delivery address from the address_id
                    $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
                    // dd($deliveryAddress);
                    //set payment method as COD if Selected from user else set as prepaid and such
                    if($data['payment_gateway'] == "COD"){
                        $payment_method = "COD";
                        $order_status = "Processing";
                    } else if($data['payment_gateway'] == "Paypal"){
                        $payment_method = "Paypal";
                        $order_status = "Processing";
                    } else if($data['payment_gateway'] == "Gcash"){
                        $payment_method = "Gcash";
                        $order_status = "Processing";
                    } else if(str_contains($data['payment_gateway'], 'Paylater')){
                        $payment_method = "Paylater";
                        $order_status = "Processing";
                    } else {
                        $payment_method = "Prepaid"; //advance payment from the customer
                        $order_status = "Pending";
                    }

                    DB::beginTransaction();
                    foreach($selectedVendorItems as $item){
                        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                            $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']);
                    }

                    //Insert tht grand total in session variable
                    Session::put('grand_total',$total_price);
                     //Insert order details
                     $order = new Order;
                     $order->user_id = Auth::user()->id;
                     $order->vendor_id = $selectedVendorId;
                     $order->name = $deliveryAddress['name'];
                     $order->address = $deliveryAddress['address'];
                     $order->mobile = $deliveryAddress['mobile'];
                     $order->email = Auth::user()->email;
                     $order->order_status = $order_status;
                     $order->payment_gateway = $data['payment_gateway'];
                     $order->payment_method = $payment_method;
                     $order->grand_total = $total_price;
                     $order->order_received = "No";
                     $order->save(); //save
                     $order_id = DB::getPdo()->lastInsertId(); //fetch the latest saved order 

                    foreach($selectedVendorItems as $item){
                        $cartItem = new OrdersProduct;
                        $cartItem->order_id = $order_id;
                        $cartItem->user_id = Auth::user()->id;
                        $getProductDetails = Product::select('product_code','product_name','admin_id','vendor_id')
                                            ->where('id',$item['product_id'])->first()->toArray();   
                        // dd($getProductDetails);
                        $cartItem->admin_id = $getProductDetails['admin_id'];
                        $cartItem->vendor_id = $getProductDetails['vendor_id'];
                        $cartItem->product_id = $item['product_id'];
                        $cartItem->product_code = $getProductDetails['product_code'];
                        $cartItem->product_name = $getProductDetails['product_name'];
                        $cartItem->product_size = $item['size'];
                        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                        $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                        $cartItem->product_qty = $item['quantity'];
                        $cartItem->save();
                        
                        //reduce stock script starts
                        $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                        // dd($orderDetails);
                        $getStock = Product::getStock($item['product_id']);
                        $newStock = $getStock - $item['quantity'];
                        $reStock = Product::reStock($item['product_id']);
                        if (!$newStock) {
                            Notification::insert([
                                'module' => 'product',
                                'module_id' => $item['product_id'],
                                'user_id' => $orderDetails['vendor_id'],
                                'sender' => 'product',
                                'receiver' => 'vendor',
                                'message' => $order['product_name'] . ' is out of stock.'
                            ]);
                        } elseif ($newStock <= $reStock){
                            Notification::insert([
                                'module' => 'product',
                                'module_id' => $item['product_id'],
                                'user_id' => $orderDetails['vendor_id'],
                                'sender' => 'product',
                                'receiver' => 'vendor',
                                'message' => $getProductDetails['product_name'] . ' needs to be restocked.'
                            ]);
                        }
                        // update the new stock on each product
                        Product::where(['id'=>$item['product_id']])->update(['stock_quantity'=>$newStock]);
                        // dd($newStock);
                    }
                    // $selectedVendorId 
                    //PayLater payment script
                    if ($payment_method == 'Paylater') {
                        $installment = VendorsBusinessDetails::where('vendor_id', $orderDetails['vendor_id'])
                        ->first();
                        if($installment['installment_weeks'] == 1){
                            $installment_id = 2;
                        } elseif($installment['installment_weeks'] == 2){
                            $installment_id = 3;
                        } elseif($installment['installment_weeks'] == 3){
                            $installment_id = 4;
                        } elseif($installment['installment_weeks'] == 4){
                            $installment_id = 5;
                        }
                        for($x = 0; $x < $installment['installment_weeks']; $x++) {
                            $final_price = round(($total_price + ($total_price * ($installment['installment_weeks']/100))) / $installment['installment_weeks'] , 2);
                            $paylater = new PayLater();
                            $paylater->user_id = Auth::user()->id;
                            $paylater->order_id = $order_id;
                            $paylater->installment_id = $installment_id;
                            $paylater->amount = $final_price;
                            $paylater->installment_week = $installment['installment_weeks'];
                            $paylater->interest_rate = $installment['interest'];
                    // dd($paylater);

                            $paylater->save();
                        }

                        // $credit_limit = CreditLimit::where('user_id', Auth::user()->id)->first();
                        // $credit_limit->update([
                        //     'current_credit_limit' => $credit_limit->current_credit_limit - ($total_price + ($total_price * ($installment_rate/100)))
                        // ]);
                    }

                    //insert order id in session variable
                    Session::put('order_id',$order_id);

                    Notification::insert([
                        'module' => 'order',
                        'module_id' => $order_id,
                        'user_id' => $getProductDetails['vendor_id'],
                        'sender' => 'customer',
                        'receiver' => 'vendor',
                        'message' => Auth::user()->name . ' has made an order. Please check order ID: ' . $order_id
                    ]);

                    DB::commit();
            
                    $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                    if($data['payment_gateway']=="COD"){
                        //send order email
                        $email = Auth::user()->email; //get the email from user model
                        $messageData = [
                            'email' => $email,
                            'name' => Auth::user()->name,
                            'order_id' => $order_id,
                            'orderDetails' => $orderDetails
                        ];
                        Mail::send('emails.order',$messageData,function($message)use($email){
                            $message->to($email)->subject('Order Placed - P-Store Mart');
                        });
    
                        //send order sms
                        
                    } else if($data['payment_gateway']=="Paypal"){
                        // Paypal - Redirect User to Paypal page after saving order
                        return redirect('/paypal');
                    } else if($data['payment_gateway']=="Gcash"){
                        // Paypal - Redirect User to Paypal page after saving order
                        return redirect('/gcash');
                    }
                    else {
                        echo "Other Prepaid payment methods coming soon!";
                    }
                // dd($paylater);
                return redirect('orderplaced');
            }

        

        return view('front.products.checkout')->with(compact('deliveryAddresses','selectedVendorId','selectedVendorItems','getCartItems','userpl', 'installment_details', 'paylater_application')); //show checkout page   
    }

    //user order placed
    public function orderplaced(Request $request){
        if(Session::has('order_id')){
            //Empty the cart
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.orderplaced');
        } else {
            return redirect('cart');
        }
    }

}
