<?php

namespace App\Http\Requests\Episode;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "serie_id" => "required|integer",
            "audio" => "mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav|required_without_all:video,link",
            "video" => "mimes:mp4,mov,ogg,qt|max:20000|required_without_all:audio,link",
            "link" => "required_without_all:video,audio",
            "number" => "integer"
        ];
    }
}
