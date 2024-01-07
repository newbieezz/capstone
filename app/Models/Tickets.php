<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    public function userTicket(){
       return $this->hasMany('App\Models\User','user_id');
    }

    public function vendorTicket(){
        return $this->hasMany('App\Models\Vendor','vendor_id');
     }

     public function getUser(){
      $getUser = User::get()->toArray();
      return $getUser;
  }
}
