<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Episode\EpisodeSerieResource;
use App\Http\Resources\Speaker\SpeakerCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            // 'episodes' => EpisodeSerieResource::collection($this->episodes),
            'episodes_count' => $this->episodes->count(),
            // 'episodes_length' => $this->episodes->("DATEDIFF(MINUTE, '0:00:00', file_length)")->toSql(),
            'subscribed' => $this->subscribed->contains(Auth::id())
        ];
    }
}
