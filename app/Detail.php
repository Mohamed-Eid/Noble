<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subdetails()
    {
        return $this->hasMany(Subdetail::class);
    }
}
