<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

      function subCategories(){
        return $this->hasMany(SubCategory::class,'id','sub_category_id');
    }
       function categories(){
        return $this->hasMany(Category::class,'id','category_id');
    }
       function brands(){
        return $this->hasMany(Brand::class,'id','brand_id');
    }
     function g_images(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
}
