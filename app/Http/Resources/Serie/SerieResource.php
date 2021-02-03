<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Episode\EpisodeSerieResource;
use App\Http\Resources\Speaker\SpeakerCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'image' => Storage::disk('public')->url($this->image),
            'speaker' => new SpeakerCollection($this->speaker),
            'description' => $this->description,
            // 'episodes' => EpisodeSerieResource::collection($this->episodes),
            'episodes_count' => $this->episodes->count(),
            'episodes_length' => $this->time_format($this->episodes->sum('file_length')),
            'episodes_size' => $this->bytes_format($this->episodes->sum('file_size')),
            'subscribed' => $this->subscribed->contains(Auth::id()),
            'href' =>
            [
                "episodes" => route("serie.episodes", $this->id)
            ]
        ];
    }
}
