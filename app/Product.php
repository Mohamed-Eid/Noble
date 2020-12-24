<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name' ,'description'];
    protected $guarded = [];
    protected  $appends = ['image_path','rate','active','active_status','active_data'];


    public function category()
    { 
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Image::class);
    }
    
    public function videos()
    {
        return $this->hasMany(\App\Video::class);
    }

    public function sizes()
    {
        return $this->hasMany(\App\Size::class);
    }

    public function colors()
    {
        return $this->hasMany(\App\Color::class);
    }

    public function coupons()
    {
        return $this->hasMany(\App\Coupon::class);
    }
    
    public function rates()
    {
        return $this->hasMany(\App\Rate::class);
    }

    public  function getImagePathAttribute(){
        return asset('uploads/product_images/'.$this->image);
    }
    

    public function getRateAttribute()
    {
        return  $this->rates->sum('rate')/($this->rates->count() == 0 ? 1 : $this->rates->count());
    }

    private function ss()
    {
        $special_size = [];
        if($this->tafsil)
        {
            if($this->length_cost!=null || $this->length_cost!=0){
                $special_size[] = [
                    'id' => 1,
                    'cost'=>$this->length_cost
                    ];
            }
            if($this->width_cost!=null || $this->width_cost!=0){
                $special_size[] = [
                    'id' => 2,
                    'cost'=>$this->width_cost
                    ];
            }
            if($this->height_cost!=null || $this->height_cost!=0){
                $special_size[] = [
                    'id' => 3,
                    'cost'=>$this->height_cost
                    ];
            }
            if($this->depth_cost!=null || $this->depth_cost!=0){
                $special_size[] = [
                    'id' => 4,
                    'cost'=>$this->depth_cost
                    ];
            }
        }
        return $special_size;
    }


    public function is_rated_by_client($client)
    {
        $rate = Rate::where('product_id',$this->id)
                        ->where('client_id',$client->id)->first();
        return $rate ? $rate : false;
    }

    public function lowest_price()
    {
        //$sizes = $this->sizes;

        $sizes = $this->sizes->where('quantity','>',0);
        $total = $sizes->min('cost') ?? 0;
        $prices = [];
        //return $total;
        $details = $this->details;
        foreach ($details as $detail) {
            $prices[] = $detail->subdetails->min('price') ?? 0 ;  
        }
        foreach ($prices as $price) {
            $total += $price;
        }

        return $total;
    }
    
    public function getActiveAttribute($val)
    {
        return [
            'ar' => [
                0 => 'غير مفعل',
                1 => 'مفعل',
            ],
            'en' => [
                0 => 'Inactive',
                1 => 'Active',
            ]
        ][app()->getLocale()][$val];
    }
    
    
    public function getActiveDataAttribute($val)
    {
        return [
            'ar' => [
                0 => 'غير مفعل',
                1 => 'مفعل',
            ],
            'en' => [
                0 => 'Inactive',
                1 => 'Active',
            ]
        ][app()->getLocale()];
    }

    public function getActiveStatusAttribute()
    {
        return $this->attributes['active'];
    }

}
