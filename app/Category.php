<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','image'];
    protected $guarded = [];
    protected  $appends = ['image_path'];



    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public  function getImagePathAttribute(){
        return asset('uploads/category_images/'.$this->image);
    }
}
