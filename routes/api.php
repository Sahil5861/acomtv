<?php

use App\Http\Controllers\AppApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/userregister',[AppApiController::class,'userRegister']);

Route::post('/login',[AppApiController::class,'login_pin']);
Route::get('/get-slider',[AppApiController::class,'getSlider']);
Route::get('/get-channels',[AppApiController::class,'getChannels']);
Route::get('/get-channels-with-genre',[AppApiController::class,'getChannelsWithGenre']);
Route::get('/get-channels-with-genre-new',[AppApiController::class,'getChannelsWithGenreNew']);
Route::get('/get-channels-with-genre-popular',[AppApiController::class,'getChannelsWithGenrePopular']);
Route::get('/pages',[AppApiController::class,'pages']);
Route::post('/upload-profile-image',[AppApiController::class,'uploadProfile']);
Route::post('/update-profile',[AppApiController::class,'updateProfile']);
Route::get('/get-active-plan',[AppApiController::class,'getActivePlan']);
Route::get('/check-plan',[AppApiController::class,'checkPlan']);


// new 11 june
Route::get('/getAllMovies', [AppApiController::class, 'getAllMovies']);
Route::get('/getAllWebSeries', [AppApiController::class, 'getAllWebSeries']);
Route::get('/getSeasons/{id}', [AppApiController::class, 'getSeasons']);
Route::get('/getEpisodes/{id}/0', [AppApiController::class, 'getEpisodes']);
Route::get('/getMoviePlayLinks/{id}/0', [AppApiController::class, 'getMoviePlayLinks']);

Route::get('/getNetworks', [AppApiController::class, 'getNetworks']);
Route::get('/getAllContentsOfNetwork/{networkId}', [AppApiController::class, 'getAllContentsOfNetwork']);
Route::get('/getMovieDetails/{contentId}', [AppApiController::class, 'getMovieDetails']);
Route::get('/searchContent/{searchTerm}/0', [AppApiController::class, 'searchContent']);
Route::get('/getFeaturedLiveTV', [AppApiController::class, 'getFeaturedLiveTV']);
Route::get('/getCustomImageSlider', [AppApiController::class, 'getCustomImageSlider']);


Route::get('/getTvChannels', [AppApiController::class, 'getTvChannels']);
Route::get('/getTvShows/{id}', [AppApiController::class, 'getTvShows']);
Route::get('/getShowSeasons/{id}', [AppApiController::class, 'getTvShowSeasons']);
Route::get('/getShowSeasonsEpisodes/{id}', [AppApiController::class, 'getTvShowEpisodes']);