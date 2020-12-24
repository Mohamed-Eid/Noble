<?php

namespace App;

use App\Http\Resources\SizeResource;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $guarded = [];
    protected $casts = [
        'special_sizes' => 'array',
        'details' => 'array'
    ];
   // public $appends = ['cart'];

    public function client()
    {
        return $this->belongsTo(\App\Client::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Product::class);
    }

    // public function color()
    // {
    //     return $this->belongsTo(\App\Color::class);
    // }


    // public function getCartAttribute()
    // {
    //     $data  = [
    //         'color' => $this->color->name,
    //         'cost'          => $this->price,
    //     ];

    //     if($this->size_id != null)
    //     {
    //         $data += [ 
    //             'size' => new SizeResource(Size::find($this->size_id)) 
    //         ];
    //     }
    //     else if($this->special_sizes != null){
    //         $data += [ 
    //             'special_sizes' => $this->special_sizes 
    //         ];
    //     }

    //     return $data;
    // }


}
