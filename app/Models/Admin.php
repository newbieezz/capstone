<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Stephenjude\Wallet\Interfaces\Wallet;
use Stephenjude\Wallet\Traits\HasWallet;
use DateTimeInterface;

class Admin extends Authenticatable implements Wallet
{
    use HasFactory;
    use HasWallet;
    protected $guard = 'admin';
    
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
    // Creating a relation to vendors_personal
    public function vendorPersonal(){
        return $this->belongsTo('App\Models\Vendor','vendor_id');
    } 
        // Creating a relation to vendors_business/shop
    public function vendorBusiness(){
        return $this->belongsTo('App\Models\VendorsBusinessDetails','vendor_id');
    } 

        // Creating a relation to vendors_bank
    public function vendorBank(){
        return $this->belongsTo('App\Models\VendorsBankDetails','vendor_id');
    } 
    
    public function wallet_transactions(){
        return $this->belongsTo('App\Models\WalletTransaction','vendor_id');
        
    }
}
