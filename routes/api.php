<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\HomeApiController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\SerieController;
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


Route::post('user/register', [RegisterController::class, "create_api"]);

Route::group(['prefix' => 'user'], function () {
    Route::post('register', [RegisterController::class, "create_api"]);
    Route::post('password/forgot', [ForgotPasswordController::class, "sendResetLinkEmail"]);
});


Route::apiResource('/categories',CategoryController::class);
Route::group(['prefix' => 'categories'], function () {
    Route::get('{category}/speakers', [CategoryController::class, "speakers"])->name('speaker.speakers');;
    Route::get('{category}/series', [CategoryController::class, "series"])->name('speaker.series');
});


Route::apiResource('/speakers', SpeakerController::class);
Route::group(['prefix' => 'speakers'], function () {
    Route::put('{speaker}/subscribe', [SpeakerController::class, "subscribe"]);
    Route::get('{speaker}/series', [SpeakerController::class, "series"])->name('speaker.series');
});

Route::apiResource('/episodes', EpisodeController::class);
Route::post('/episodes/{episode}/activity', [EpisodeController::class, "activity"]);

Route::apiResource('series', SerieController::class)->parameters(['series' => 'serie']);
Route::group(['prefix' => 'series'], function () {
    Route::put('{serie}/subscribe', [SerieController::class, "subscribe"]);
    Route::get('{serie}/episodes', [SerieController::class, "episodes"])->name('serie.episodes');
});




Route::group(['prefix' => 'home'], function () {
    Route::get('series', [HomeApiController::class, "series"]);
    Route::get('episodes', [HomeApiController::class, "episodes"]);
    Route::get('speakers', [HomeApiController::class, "speakers"]);
});


Route::group(['prefix' => 'activities'], function () {
    Route::get('history', [ActivityController::class, "history"]);
    Route::get('downloads', [ActivityController::class, "downloads"]);
    Route::get('watch_later', [ActivityController::class, "watch_later"]);
    Route::get('subscribes/speakers', [ActivityController::class, 's_speakers']);
    Route::get('subscribes/series', [ActivityController::class, "s_series"]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
