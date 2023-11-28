<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditLimit extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id',
        'credit_limit',
        'current_credit_limit',
    ];

    public function credit_limit(){
        return $this->belongsTo('App\Models\User','id','user_id');
    }

    public static function getCreditLimit(){
        $getCreditLimit = CreditLimit::select('current_credit_limit')->first()->toArray();
        return $getCreditLimit['current_credit_limit'];
    }
}
