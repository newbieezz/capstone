<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //one order can have multiple/many products
    public function orders_products(){
        return $this->hasMany('App\Models\OrdersProduct','order_id');
    }
}
