<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $hidden = ['translations'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
