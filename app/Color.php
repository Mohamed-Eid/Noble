<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(\App\Product::class);
    }
}
