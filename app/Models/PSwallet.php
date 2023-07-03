<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSwallet extends Model
{
    protected $fillable = [
        'admin_id',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(Admin::class);
    }
}
