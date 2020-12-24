<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['body' ,];
    protected $guarded = [];
    protected $hidden = ['translations'];
    
}
