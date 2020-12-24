<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOrder extends Model
{
    protected $guarded = [];
    public $appends = ['files_path'];
    protected $casts = [
        'files' => 'array',
    ];
    
    public function client()
    {
        return $this->belongsTo(\App\Client::class);
    }
    
    public function getFilesPathAttribute()
    {
        $data = [];
        foreach($this->files as $file)
        {
            $data[] = asset('uploads/special_orders/'.$file);
        }
        return $data;
    }

}
