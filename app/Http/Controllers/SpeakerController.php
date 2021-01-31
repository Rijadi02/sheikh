<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpeakerRequest;
use App\Http\Resources\Speaker\SpeakerCollection;
use App\Http\Resources\Speaker\SpeakerResource;
use App\Models\Speaker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function index()
    {
        return SpeakerCollection::collection(Speaker::paginate(10));
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
        $speaker->image = $request->image;

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
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function subscribe($id)
    {
        $id = Auth::id();
        $speaker = Speaker::find($id);
        $toogled = $speaker->subscribed->contains($id);

        if ($toogled) {
            $speaker->subscribed()->detach($id);
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            $speaker->subscribed()->attach([$id => ['subscribed' => Carbon::now()]]);
            return response(["message" => "Succesfully subscribed!"], Response::HTTP_CREATED);
        }
    }
}
