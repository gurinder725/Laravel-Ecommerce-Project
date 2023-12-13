<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    function parentCategories(){
        return $this->hasMany(Category::class,'id','category_id');
    }


}
