<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Speaker\SpeakerCollection;
use App\Models\Category;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
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
    public function store(CategoryRequest $request)
    {
        $category = new Category();

        $category->name = $request->name;

        $uploadFolder = 'categories';
        $icon = $request->file('icon');
        $icon_uploaded_path = $icon->store($uploadFolder, 'public');

        $category->icon = $icon_uploaded_path;

        $category->color = $request->color;

        $category->save();

        return response([
            'data' => new CategoryResource($category)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return response(['data' => new CategoryResource($category)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Storage::disk('public')->delete($category->icon);
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function series(Category $category, Request $request)
    {
        global $search;
        $search = $request->input('search');

        $series = $category->series()
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

    public function speakers(Category $category, Request $request)
    {
        global $search;
        $search = $request->input('search');

        $array = array_values(array_unique($category->series()->pluck('speaker_id')->toArray(), false));
        $speakers = Speaker::whereIn("id", $array)
                ->where(
                    function ($query) {
                        global $search;
                        $query->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('bio', 'LIKE', "%{$search}%");
                    }
                )
                ->orderByDesc("updated_at")
                ->simplePaginate(10);

        return SpeakerCollection::collection($speakers);
    }
}
