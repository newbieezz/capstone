<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function section(){
        //every category belongs to a Section
        return $this->belongsTo('App\Models\Section','section_id')->select('id','name');
    }

    public function parentcategory(){

        return $this->belongsTo('App\Models\Category','parent_id')->select('id','category_name');

    }

    public function subcategories(){
        // every category can have many subcategories, creating a has to many relation
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    //fetch category id to pass the url
    public static function categoryDetails($url){
        $categoryDetails = Category::select('id','category_name','url')->with('subcategories')
                            ->where('url',$url)->first()->toArray();

        //array to add category and subcat id
        $catIds = array();
        $catIds[] = $categoryDetails['id'];
        //display all category id's with subcats
        foreach($categoryDetails['subcategories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
        }

        $resp = array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails);
        return $resp;
    }
}
