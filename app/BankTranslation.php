<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['bank_name','name'];
}
