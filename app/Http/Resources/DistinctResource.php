<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\City;

class DistinctResource extends JsonResource
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
            'name' => $this->translate(app()->getLocale())->name,
            'delivered_cost' => $this->delivered_cost,
            'country'        => new CityResource(City::find($this->city_id)),
        ];
    }
}
