<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function categories(){
        //every section has one to many categories together with the subcategories
        return $this->hasMany('App\Models\Category','section_id')->where(['parent_id'=>0,'status'=>1])
        ->with('subcategories');
    }
}
