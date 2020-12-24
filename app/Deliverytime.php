<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverytime extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];
}
