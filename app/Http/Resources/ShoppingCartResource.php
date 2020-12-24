<?php

namespace App\Http\Resources;

use App\Detail;
use App\Subdetail;
use App\Tax;
use App\Size;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = [
            'name'       => $this->product->name,
            'image_path' => $this->product->image_path,
        ];
        $data = [];
        //dd($this->details);
        foreach ($this->details as $detail) {
            $detail_ = Detail::find($detail['detail_id']);
            $subdetail = Subdetail::find($detail['subdetail_id']);
            $data[] = [ 
                "key" => $detail_->name,
                "value" => $subdetail->name 
            ];
        }

        $return_data = [
            'id'            => $this->id,
            //'product'       => $product,
            'product'       => new ProductResource($this->product),
            'cart_data'     => $data ,
            'special_sizes' => $this->special_sizes == null ? false : true,
            'quantity'      => $this->quantity,
            'price'         => $this->price,
        ];
        
        
        if($return_data['special_sizes'] == false){
           $return_data+= [
               'size' => new SizeResource(Size::find($this->size_id))
               ];
        }
        if($return_data['special_sizes']){
           $return_data+= [
               'special_sizes_data' => $this->special_sizes,
               ];
        }

        return $return_data;
    }
}
