<?php

namespace App\Http\Resources\Episode;

use App\Http\Resources\Serie\SerieCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
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
            'file_length' => $this->file_length,
            'serie' => new SerieCollection($this->serie),
            'activity' => null,
            'file' => $this->file
        ];
    }
}
