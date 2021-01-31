<?php

namespace App\Http\Resources\Episode;

use App\Http\Resources\Serie\SerieCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EpisodeCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $activity = $this->activity()->where('user_id', Auth::id())->first();
        // $log = DB::getQueryLog();
        // dump($log);
        return [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'file_length' => $this->file_length,
            'serie' => new SerieCollection($this->serie),
            'activity' => new ActivityResource($activity ? $activity->pivot : null)
        ];
    }
}
