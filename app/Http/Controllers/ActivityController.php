<?php

namespace App\Http\Controllers;

use App\Http\Resources\Episode\EpisodeCollection;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Speaker\SpeakerCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function history()
    {
        $episodes = Auth::user()->episodes()
                    ->where('episode_user.history',"!=", null)
                    ->orderByDesc("episode_user.history")
                    ->simplePaginate(10);
        return EpisodeCollection::collection($episodes);
    }

    public function downloads()
    {
        $episodes = Auth::user()->episodes()
                    ->where('episode_user.download',"!=", null)
                    ->orderByDesc("episode_user.download")
                    ->simplePaginate(10);
        return EpisodeCollection::collection($episodes);
    }

    public function watch_later()
    {
        $episodes = Auth::user()->episodes()
                    ->where('episode_user.watch_later',"!=", null)
                    ->orderByDesc("episode_user.watch_later")
                    ->simplePaginate(10);
        return EpisodeCollection::collection($episodes);
    }

    public function s_speakers()
    {
        $speakers = Auth::user()->speakers()
                    ->orderByDesc("speaker_user.id")
                    ->simplePaginate(10);
        return SpeakerCollection::collection($speakers);
    }

    public function s_series()
    {
        $series = Auth::user()->series()
                    ->orderByDesc("serie_user.id")
                    ->simplePaginate(10);
        return SerieCollection::collection($series);
    }
}
