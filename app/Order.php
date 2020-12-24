<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    protected $casts = [
        'carts' => 'array'
    ];
    protected $appends = ['status_values', 'status_id','payment_method_values','payment_method_id'];


    public function client()
    {
        return $this->belongsTo(\App\Client::class);
    }
    
    public function ScopeWaiting($query){
        return $query->where('status',1);
    }
    
    public function getStatusValuesAttribute()
    {
        $s = [
            'ar'=> [
                1 => 'في الانتظار',
                2 => 'تم الشحن',
                3 => 'تم التوصيل',
            ],
            'en'=>[
                1 => 'Waiting',
                2 => 'Shipping Done',
                3 => 'Transported',
            ]
        ];

        return $s[app()->getLocale()];
    }
    
    public function getPaymentMethodValuesAttribute()
    {
        $s = [
            'ar'=> [
                1 => 'تحويل بنكي',
                2 => 'بطاقة ائتمانية',
                3 => 'الدفع عند الاستلام',
            ],
            'en'=>[
                1 => 'Bank transfer',
                2 => 'Credit card',
                3 => 'Cash on delivery',
            ]
        ];

        return $s[app()->getLocale()];
    }
    public function getPaymentMethodAttribute($val)
    {
        $s = [
            'ar'=> [
                1 => 'تحويل بنكي',
                2 => 'بطاقة ائتمانية',
                3 => 'الدفع عند الاستلام',
            ],
            'en'=>[
                1 => 'Bank transfer',
                2 => 'Credit card',
                3 => 'Cash on delivery',
            ]
        ];

        return $s[app()->getLocale()][$val];
    }
    
    public function getStatusIdAttribute()
    {
        return $this->attributes['status'];
    }

    public function getPaymentMethodIdAttribute()
    {
        return $this->attributes['payment_method'];
    }

    public function getStatusAttribute($val)
    {
        $s = [
            'ar'=> [
                1 => 'في الانتظار',
                2 => 'تم الشحن',
                3 => 'تم التوصيل',
            ],
            'en'=>[
                1 => 'Waiting',
                2 => 'Shipping Done',
                3 => 'Transported',
            ]
        ];

        return $s[app()->getLocale()][$val];
    }
    
}
