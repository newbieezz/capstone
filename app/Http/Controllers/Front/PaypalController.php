<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;
use App\Models\ProductsAttribute;


class PaypalController extends Controller
{
    private $gateway;

    public function __construct(){
       $this->gateway = Omnipay::create('PayPal_Rest');
       $this->gateway->setClientId(env('PAYPAL_CLIENT_ID')); 
       $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET')); 
       $this->gateway->setTestMode(true);
    }

    public function paypal(){
        if(Session::has('order_id')){
            return view('front.paypal.paypal');
        } else{
            return redirect('cart');
        }
    }

    public function pay(Request $request){
        try{
            $paypal_amount = round(Session::get('grand_total'),2);
            $response = $this->gateway->purchase(array(
                'amount' => $paypal_amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();
            if($response->isRedirect()){
                $response->redirect();
            }else{
                return $response->getMessage();
            }
        }catch(\Throwable $th){
           return $th->getMessage(); 
        }
    }

    public function success(Request $request){
        // if(Session::has('order_id')){
        //     return redirect('cart');
        // }

        if($request->input('paymentId') && $request->input('PayerID')){
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));
            $response = $transaction->send();
            if($response->isSuccessful()){
                $arr = $response->getData();
                $payment = new Payment;
                $payment->order_id = Session::get('order_id');
                $payment->user_id = Auth::user()->id;
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['state'];
                $payment->save();
                // return "Payment is Successful. Your transaction ID is ". $arr['id'];

                // send order email upon successfully paid
                $order_id = Session::get('order_id');
                $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                //update order status in db
                Order::where('id',$order_id)->update(['order_status'=>'Paid']);
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
                
                Notification::insert([
                    'module' => 'order',
                    'module_id' => $order_id,
                    'user_id' => $orderDetails['orders_products'][0]['vendor_id'],
                    'sender' => 'customer',
                    'receiver' => 'vendor',
                    'message' => Auth::user()->name . ' has made an order. Please check order ID: ' . $order_id
                ]);

                foreach($orderDetails['orders_products'] as $key => $order){
                    //reduce stock script starts
                    // dd($orderDetails);
                    $getProductStock = ProductsAttribute::getProductStock($order['product_id'],$order['product_size']);
                    $newStock = $getProductStock - $order['product_qty'];
                    ProductsAttribute::where(['product_id'=>$order['product_id'],'size'=>$order['product_size']])->update(['stock'=>$newStock]);

                    if (!$newStock) {
                        Notification::insert([
                            'module' => 'product',
                            'module_id' => $order['product_id'],
                            'user_id' => $orderDetails['orders_products'][$key]['vendor_id'],
                            'sender' => 'product',
                            'receiver' => 'vendor',
                            'message' => $order['product_name'] . ' is out of stock.'
                        ]);
                    }

                }

                //empty the cart
                Cart::where('user_id',Auth::user()->id)->delete();
                return view('front.paypal.ordersuccess');

            } else{
                return $response->getMessage();
            }

        }else {
            return "Payment Declined!";
        }
    }

    public function error(){
        return view('front.paypal.orderfailed');
        
    }
}
