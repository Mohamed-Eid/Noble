<?php

namespace App\Http\Controllers\Api;
use App\Rate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class RateController extends Controller
{
    use ApiResponseTrait;

    public function rate()
    {
        //validation
        $validate = Validator::make(request()->all(), [
            'product_id' => 'required',
            'rate'    => 'required|min:0|max:5',
            //'text'    => 'required',
        ]);
        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }
        //find product
        $product = Product::find(request()->product_id);

        //if product exists (valid id)
        if($product)
        {
            //check if not rate
            $rate = $product->is_rated_by_client(request()->client); //if liked return rate object else return false
            
            if($rate == false){
                Rate::Create([
                    'client_id' => request()->client->id,
                    'product_id' => $product->id,
                    'rate'    => \request()->rate,
                    'text'    => request()->text,
                ]);
                return $this->ApiResponse(true , [] , __('api.rated') , [] ,200);
            }
            //update rate
            $rate->update([
                'client_id' => request()->client->id,
                'product_id' => $product->id,
                'rate'    => \request()->rate,
                'text'    => request()->text,

            ]); 
            return $this->ApiResponse(true , [] , __('api.rate_updated') , [] ,200);
        }
        return $this->ApiResponse(true , [__('api.product_not_found')] , __('api.validation_error') , [] ,200);
    }
}

