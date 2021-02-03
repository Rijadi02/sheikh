<?php

namespace App\Http\Resources\Episode;

use App\Http\Resources\Serie\SerieCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $activity = $this->activity()->where('user_id', Auth::id())->first();
        return [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'file' => Storage::disk('public')->url($this->file),
            'file_length' => $this->time_format($this->file_length),
            'file_size' => $this->bytes_format($this->file_size,2),
            'serie' => new SerieCollection($this->serie),
            'activity' => new ActivityResource($activity ? $activity->pivot : null)
        ];
    }
}
