<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\District;

class ClientResource extends JsonResource
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
            'mobile' => $this->mobile,
            'street' => $this->street,
            'active' => $this->active,
            'email'   => $this->email,
            'city'   => new DistinctResource(District::find($this->district_id)),
            'api_token' => $this->api_token,
            'fcm_token' => $this->fcm_token
        ];
    }
}
