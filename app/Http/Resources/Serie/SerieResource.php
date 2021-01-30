<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Episode\EpisodeCollection;
use App\Http\Resources\Speaker\SpeakerCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'speaker' => new SpeakerCollection($this->speaker),
            'description' => $this->description,
            'episodes' => new EpisodeCollection($this->episodes),
            'episodes_count' => $this->episodes->count(),
            'episodes_length' => $this->episodes->sum('file_length'),
            'activity' => null
        ];
    }
}
