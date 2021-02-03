<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
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
            'icon' => Storage::disk('public')->url($this->icon),
            'color' => $this->color,
            'href' =>
            [
                "speakers" => route("category.speakers", $this->id),  ////
                "series" => route("category.series", $this->id)      ////
            ],
        ];
    }
}
