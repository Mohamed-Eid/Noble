<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public $appends = ['image_public_path'];

    public function product()
    {
        return $this->belongsTo(\App\Product::class);
    }
    public function getImageAttribute($attribute){
        return asset('uploads/product_images/'.$attribute);
    }

    public function getImagePublicPathAttribute(){
        return public_path('uploads/product_images/'.$this->getAttributes()['image']);
    }


}
