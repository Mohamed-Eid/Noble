<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['client_id' , 'product_id' , 'rate','text'];
}
