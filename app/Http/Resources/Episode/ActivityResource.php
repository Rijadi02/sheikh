<?php

namespace App\Http\Resources\Episode;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            "watch_later" => isset($this->watch_later) ? 1 : 0,
            "download" => isset($this->download) ? 1 : 0,
            "history" => isset($this->history) ? 1 : 0
        ];
    }
}
