<?php

namespace App\Http\Controllers;

use App\Http\Resources\Episode\EpisodeCollection;
use App\Http\Resources\Episode\EpisodeResource;
use App\Models\Episode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

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
    public function index()
    {
        return EpisodeCollection::collection(Episode::paginate(10));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function show(Episode $episode)
    {
        return $episode;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Episode $episode)
    {
        //
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
