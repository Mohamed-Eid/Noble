<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = [];

    public $appends = ['video_public_path'];

    public function product()
    {
        return $this->belongsTo(\App\Product::class);
    }
    
    public function getVideoAttribute($attribute){
        return asset('uploads/product_videos/'.$attribute);
    }

    public function getVideoPublicPathAttribute(){
        return public_path('uploads/product_videos/'.$this->getAttributes()['video']);
    }

}
