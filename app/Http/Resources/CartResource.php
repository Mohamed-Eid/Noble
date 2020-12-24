<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Subdetail;
use App\Product;
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $details = [];
        $ids = explode(',',$this->subdetails);
        foreach($ids as $id)
        {
            $sub = Subdetail::find($id);
            array_push($details , new SubdetailResource($sub));
            //$details[$sub->detail->name] = $sub->name;
        }

        return [
            'id'           => $this->id,
            'product_name' => Product::find($this->product_id)->name,
            'details'      => (array) $details,
            'quantity'     => $this->quantity,
            'price'        => $this->price,
        ];
    }
}
