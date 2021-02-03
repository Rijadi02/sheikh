<?php

namespace App\Http\Controllers;

use App\Http\Requests\SerieRequest;
use App\Http\Resources\Episode\EpisodeCollection;
use App\Http\Resources\Episode\EpisodeSerieResource;
use App\Models\Serie;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Serie\SerieResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SerieController extends Controller
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

        $series = Serie::where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orderByDesc("updated_at")
                ->simplePaginate(10);

        return SerieCollection::collection($series);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SerieRequest $request)
    {
        $serie = new Serie();

        $serie->name = $request->name;
        $serie->description = $request->description;

        $uploadFolder = 'series';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $serie->image = $image_uploaded_path;

        $serie->speaker_id = $request->speaker_id;
        $serie->category_id = $request->category_id;

        $serie->save();

        return response([
            'data' => new SerieResource($serie)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function show(Serie $serie)
    {
        return new SerieResource($serie);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Serie $serie)
    {
        $serie->update($request->all());
        return response(['data' => new SerieResource($serie)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serie $serie)
    {
        $serie->delete();
        Storage::disk('public')->delete($serie->image);
        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function subscribe(Serie $serie)
    {
        return $serie->subscribed()->toggle(Auth::id());

        // if ($toogled) {
        //     $serie->subscribed()->detach($id);
        //     return response(null, Response::HTTP_NO_CONTENT);
        // } else {
        //     $serie->subscribed()->attach([$id => ['subscribed' => Carbon::now()]]);
        //     return response(["message" => "Succesfully subscribed!"], Response::HTTP_CREATED);
        // }
    }

    public function episodes(Serie $serie, Request $request)
    {
        $search = $request->input('search');

        $episodes = $serie->episodes()
                ->where('name', 'LIKE', "%{$search}%")
                ->orderByDesc("updated_at")
                ->simplePaginate(10);

        return EpisodeSerieResource::collection($episodes);
    }
}
