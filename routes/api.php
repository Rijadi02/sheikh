<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\SpeakerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('/categories',CategoryController::class);

Route::apiResource('/speakers',SpeakerController::class);
Route::get('/speakers/{speaker}/subscribe', [SpeakerController::class, "subscribe"]);

Route::apiResource('/episodes', EpisodeController::class);
Route::post('/episodes/{episode}/activity', [EpisodeController::class, "activity"]);

Route::apiResource('/series', SerieController::class);
Route::get('/series/{serie}/subscribe', [SerieController::class, "subscribe"]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
