<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => $this->title,
            'body'  => $this->body,
            'image' => $this->image==null ? null : $this->image_path,
            'type'  => $this->type,
            'created_at' => $this->created_at->diffForHumans(),
            ];
    }
}
