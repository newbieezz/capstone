<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    public function section(){
        //every product belongs to a section
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function category(){
        //every product belongs to a category
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
