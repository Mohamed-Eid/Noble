<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Tax;
use App\Product;
use App\Subdetail;
use App\Size;

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
        
        $items = [] ;
       // dd($this->carts);
        $products = [];
        foreach ($this->carts as $item) 
        {
            $data = [];
            
            $product = Product::find($item['product_id']);
            //dd($product);
            $products [] = $product ;
            $product = [
                'name'       => $product->name,
                'image_path' => $product->image_path,
            ];

            foreach ($item['sub_details'] as $sub_detail_id) {
                $subdetail = Subdetail::find($sub_detail_id);
                $data[] = [ 
                    "key" => $subdetail->detail->name,
                    "value" => $subdetail->name 
                ];
            }

            $return_data = [
                //'id'            => $this->id,
                'product'       => $product ,//new ProductResource($product),
                'cart_data'     => $data ,
                'special_sizes' => isset($item['special_sizes']) ? true : false,
                'quantity'      => $item['quantity'],
                'price'         => $this->price,
            ];

            if($return_data['special_sizes'] == false){
                $return_data += [
                    'size' => new SizeResource(Size::find( $item['size_id']))
                    ];
            }

            if($return_data['special_sizes']){
                $return_data += [
                'special_sizes_data' => $item['special_sizes']
            ];
            }
            $items[] = $return_data;
        }

        return [
            'id'                            => $this->id,
            'status'                        => $this->status,
            'status_id'                     => $this->status_id,
            'location'                      => $this->location,
            'price'                         => $this->total_price,
            'tax'                           => Tax::first()->tax,
            
            // 'delivery_cost'                 => request()->client->district->delivered_cost, 
            // 'total_price_before_discount'   => $price + request()->client->district->delivered_cost + Tax::first()->tax,
            
            'total_price'                   => $this->total_price,
            //'discount'                      => $this->discount,
            
            'discount'                      => $this->discount[-1] == "%" ? (int)substr($this->discount, 0, -1) : 0,
            'payment_id'                    => $this->payment_method_id,
            'payment_method'                => $this->payment_method,
            'carts'                         => $items ,
            'status_values'                 => (object)$this->status_values,
            'created_at'                    => $this->created_at->toDateTimeString(),
        ];
    }
}
