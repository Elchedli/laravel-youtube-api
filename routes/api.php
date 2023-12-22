<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('/searchVideo','App\Http\Controllers\YoutubeController@searchVideos')->name('searchVideos');
Route::get('/test','App\Http\Controllers\YoutubeController@test')->name('test');
Route::get('/ProfileData','App\Http\Controllers\YoutubeController@profile')->name('profile');
Route::get('/ProfileAnalytics','App\Http\Controllers\YoutubeController@analytics')->name('analytics');
