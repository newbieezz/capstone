<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'name', 'address', 'email', 'mobile', 'status'
    ];

    public static function deliveryAddresses(){
        //use of get() for multiple addresses and toArray to convert it to Arrays
        $deliveryAddresses = DeliveryAddress::where('user_id',Auth::user()->id)->get()->toArray();

        return $deliveryAddresses; //used in checkout page (checkout function inside ProductController)
    }
}
