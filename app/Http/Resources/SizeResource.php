<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'depth' => $this->depth,
            'cost' => $this->cost,
        ];
    }
}
