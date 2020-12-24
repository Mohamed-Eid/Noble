<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','currency'];
    protected $guarded = [];
    protected  $appends = ['image_path'];

    protected $hidden = ['created_at' , 'updated_at', 'translations'];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public  function getImagePathAttribute(){
        return asset('uploads/city_images/'.$this->image);
    }
}
