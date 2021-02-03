<?php

namespace App\Http\Controllers;

use App\Http\Requests\Episode\EpisodeRequest;
use App\Http\Resources\Episode\EpisodeCollection;
use App\Http\Resources\Episode\EpisodeResource;
use App\Models\Episode;
use App\Models\Serie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use wapmorgan\Mp3Info\Mp3Info;

class EpisodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $episodes = Episode::orderByDesc("updated_at")
                ->where('name', 'LIKE', "%{$search}%")
                ->simplePaginate(10);

        return EpisodeCollection::collection($episodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EpisodeRequest $request)
    {
        $episode = new Episode();

        $serie = $request->serie_id;

        $episode->name = $request->name;
        $episode->serie_id = $serie;

        $uploadFolder = 'episodes';
        $file = $request->file('file');
        $file_uploaded_path = $file->store($uploadFolder, 'public');

        $episode->file = $file_uploaded_path;

        $audio = new Mp3Info(Storage::disk('public')->path($file_uploaded_path));

        if (!isset($request->number)) {
            $max = Serie::find($serie)->episodes->max('number');
            $episode->number = $max ? $max + 1 : 1;
        } else {
            $episode->number = $request->number;
        }

        $episode->file_size = intval($file->getSize());
        $episode->file_length = intval($audio->duration);

        $episode->save();

        return response([
            'data' => new EpisodeResource($episode)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function show(Episode $episode)
    {
        return new EpisodeResource($episode);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function edit(Episode $episode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Episode $episode)
    {
        $episode->update($request->all());
        return response(['data' => new EpisodeResource($episode)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Episode $episode)
    {
        $episode->delete();
        Storage::disk('public')->delete($episode->file);
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function activity(Episode $episode, Request $request)
    {
        $values = [];
        $requests = $request->all();

        $id = Auth::id();

        if (array_sum($requests) == 0) {
            $episode->activity()->detach($id);
            return response(["data" => $requests], Response::HTTP_ACCEPTED);
        }

        foreach ($requests as $key => $i) {
            $values[$key] = $i == 0 ? null : Carbon::now();
        }

        $toogled = $episode->activity->contains($id);

        if ($toogled) {
            $episode->activity()->updateExistingPivot($id, $values);
            return response(["data" => $requests], Response::HTTP_CREATED);
        } else {
            $episode->activity()->attach([$id => $values]);
            return response(["data" => $requests], Response::HTTP_CREATED);
        }
    }
}
