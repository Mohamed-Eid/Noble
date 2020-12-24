<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['bank_name' , 'name'];
    protected $guarded = [];
    protected  $appends = ['image_path'];

    public  function getImagePathAttribute(){
        return asset('uploads/bank_images/'.$this->image);
    }
}
