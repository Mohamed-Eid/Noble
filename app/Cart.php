<?php

namespace App;

use App\Http\Resources\SubdetailResource;
use Illuminate\Database\Eloquent\Model;
use App\Subdetail;

class Cart extends Model
{
    protected $guarded = [];
    protected  $appends = ['product_name' , 'details','sub'];

    protected $hidden = ['client_token'];

    public function getProductNameAttribute()
    {
        return Product::find($this->product_id)->name;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
    public function getSubAttribute()
    {
        $subs = [];
        $ids = explode(',',$this->subdetails);
        foreach($ids as $id)
        {
            $sub = Subdetail::find($id);
            $subs[] = $sub;
        }
        return $subs;
    }

    public function getDetailsAttribute()
    {
        $details = [];
        $ids = explode(',',$this->subdetails);
        if (($key = array_search("", $ids)) !== false) {
            unset($ids[$key]);
        }
        //dd($ids);
        foreach($ids as $id)
        {
            $sub = Subdetail::find($id);
            $details[$sub->detail->name] = $sub->name;
        }
        return $details;
    }
}
