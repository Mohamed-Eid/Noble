<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdetail extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name',];
    protected $guarded = [];
    protected  $appends = ['image_path','icon_path'];


    public function detail()
    {
        return $this->belongsTo(Detail::class);
    }

    public  function getImagePathAttribute(){
        return asset('uploads/product_images/'.$this->image);
    }

    public  function getIconPathAttribute(){
        return asset('uploads/product_images/'.$this->icon);
    }
} 
