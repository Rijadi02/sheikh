<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpeakerRequest;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Speaker\SpeakerCollection;
use App\Http\Resources\Speaker\SpeakerResource;
use App\Models\Speaker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SpeakerController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:api");
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $episodes = Speaker::orderByDesc("updated_at")
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('bio', 'LIKE', "%{$search}%")
                ->simplePaginate(10);

        return SpeakerCollection::collection($episodes);
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
    public function store(SpeakerRequest $request)
    {
        $speaker = new Speaker();

        $speaker->name = $request->name;
        $speaker->bio = $request->bio;

        $uploadFolder = 'speakers';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $speaker->image = $image_uploaded_path;

        $speaker->save();

        return response([
            'data' => new SpeakerResource($speaker)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show(Speaker $speaker)
    {
        return new SpeakerResource($speaker);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function edit(Speaker $speaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speaker $speaker)
    {
        $speaker->update($request->all());
        return response(['data' => new SpeakerResource($speaker)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speaker $speaker)
    {
        $speaker->delete();
        Storage::disk('public')->delete($speaker->image);
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function subscribe(Speaker $speaker)
    {
        return $speaker->subscribed()->toggle(Auth::id());
    }

    public function series(Speaker $speaker, Request $request)
    {
        global $search;
        $search = $request->input('search');

        $series = $speaker->series()
                ->where(
                    function ($query) {
                        global $search;
                        $query->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('description', 'LIKE', "%{$search}%");
                    }
                )
                ->orderByDesc("updated_at")
                ->simplePaginate(10);

        return SerieCollection::collection($series);
    }
}
