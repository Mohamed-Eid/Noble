<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
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
                'client_id'  => $this->client_id,
                'rate'       => $this->rate,
                'text'       => $this->text,
                'created_at' => $this->created_at->toDateTimeString(),
            ];
    }
}
