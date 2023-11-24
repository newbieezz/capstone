<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionFee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'type', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //one order can have multiple/many products
    public function orders(){
        return $this->belongsTo('App\Models\Order','order_id');
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor','vendor_id');
    }

    // public function user(){
    //     return $this->belongsTo('App\Models\User','user_id');
    // }
}
