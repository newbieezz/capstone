<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersProduct extends Model
{
    use HasFactory;

    public function orders_products(){
        return $this->belongsTo('App\Models\Order','order_id');
    }
}
