<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Code extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->BelongsTo(\App\Client::class);
    }
}
