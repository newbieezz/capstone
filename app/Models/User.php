<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Backup\Helpers\Format;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pay_later_applications(){
        return $this->hasMany(PayLaterApplication::class);
        
    }
    public static function getUserBNPLstatus(){
        $getUserBNPLstatus = User::select('bnpl_status')->where('id',Auth::user()->id)->first()->toArray();

        return $getUserBNPLstatus['bnpl_status'];
    }

    public function gcash_payments(){
        return $this->belongsTo('App\Models\GcashPayment','user_id');
        
    }

    public function paylaters(){
        return $this->hasMany(PayLaterApplication::class);
        
    }
    
}
