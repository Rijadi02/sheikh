<?php

namespace App\Http\Controllers;

use App\Http\Resources\Episode\EpisodeCollection;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Speaker\SpeakerCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\Episode;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function series()
    {
        return SerieCollection::collection(Auth::user()->series);
    }

    public function speakers()
    {
        return SpeakerCollection::collection(Auth::user()->speakers);
    }

    public function episodes()
    {
        $series = Auth::user()->series->pluck('id');
        $episodes =Episode::whereIn("serie_id", $series)
                ->orderByDesc("updated_at")
                ->simplePaginate(10);
        return EpisodeCollection::collection($episodes);
    }
}
