<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paylater extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'installment_id',
        'due_date',
        'amount',
        'interest_rate',
        'is_paid',
    ];

    public function orders () {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
