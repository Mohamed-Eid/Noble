<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Tax;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $carts = $this->carts;
        $price = 0;
        foreach($carts as $cart){
            $price += ($cart['price']*$cart['quantity']); 
        }
        return [
            'id'                            => $this->id,
            'status'                        => $this->status,
            'status_id'                     => $this->status_id,
            'location'                      => $this->location,
            'price'                         => $price,
            'tax'                           => Tax::first()->tax,
            'delivery_cost'                 => request()->client->district->delivered_cost, 
            'total_price_before_discount'   => $price + request()->client->district->delivered_cost + Tax::first()->tax,
            'total_price'                   => $this->total_price,
            //'discount'                      => $this->discount,
            'discount'                      => $this->discount[-1] == "%" ? (int)substr($this->discount, 0, -1) : 0,
            'payment_id'                    => $this->payment_method_id,
            'payment_method'                => $this->payment_method,
            'carts'                         => $this->carts,
            'status_values'                 => (object)$this->status_values,
            'created_at'                    => $this->created_at->toDateTimeString(),
        ];
    }
}
