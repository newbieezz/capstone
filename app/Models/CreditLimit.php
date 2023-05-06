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
}
