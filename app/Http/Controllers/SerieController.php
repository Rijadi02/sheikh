<?php

namespace App\Http\Controllers;

use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Serie;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function index()
    {
        return SerieCollection::collection(Serie::paginate(10));
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
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new SerieResource(Serie::find($id));
    }


    public function subscribe(Serie $serie)
    {
        $id = Auth::id();
        $toogled = $serie->subscribed->contains($id);

        if ($toogled) {
            $serie->subscribed()->detach($id);
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            $serie->subscribed()->attach([$id => ['subscribed' => Carbon::now()]]);
            return response(["message" => "Succesfully subscribed!"], Response::HTTP_CREATED);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function edit(Serie $serie)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serie $serie)
    {
        //
    }
}
