<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubdetailResource extends JsonResource
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
            'type' => $this->detail->name,
            'price' => $this->price,
            'icon'  => $this->icon ? $this->icon_path : '',
            'image' => $this->image && $this->icon ? $this->image_path : '',
        ];
    }
}
