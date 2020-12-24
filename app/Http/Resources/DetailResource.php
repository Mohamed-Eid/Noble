<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
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
            'index' => $this->sort,
            'name' => $this->translate(app()->getLocale())->name,
            'subdetails' => SubdetailResource::collection($this->subdetails->sortBy('sort')),
        ];
    }
}
