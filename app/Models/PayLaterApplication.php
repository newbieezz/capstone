<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayLaterApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'garantor_id',
        'garantor_name', 
        'work',
        'salary',
        'valid_id',
        'selfie' ,
        'appstatus',
    ];
    public function users(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function setEntryDateAttribute($input)
    {
        $this->attributes['dob'] =
        Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
    }
 
    public function getEntryDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)
        ->format(config('app.date_format'));
    }
}
