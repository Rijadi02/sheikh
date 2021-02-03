<?php

namespace App\Http\Resources\Episode;

use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeSerieResource extends JsonResource
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
            'number' => $this->number,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'file_length' =>  $this->time_format($this->file_length),
            'activity' => null,
            'href' =>
            [
                "episode" => route("episodes.show", $this->id)
            ],
        ];
    }
}
