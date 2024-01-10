<?php

use App\Http\Controllers\SocialAccountsController;
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



Route::get('/profile','App\Http\Controllers\YoutubeController@profile')->name('profile');
Route::get('/testphp','App\Http\Controllers\SocialAccountsController@testphp')->name('testphp');
// Route::get('/ProfileAnalytics','App\Http\Controllers\YoutubeController@analytics')->name('analytics');


Route::group(['as' => 'api.'], function () {
    Route::get('social-accounts/auth/{provider}', [SocialAccountsController::class, 'auth']);
    Route::get('social-accounts/auth/{provider}/callback', [SocialAccountsController::class, 'authCallback'])->name('authCallback');
});


// TODO Implement login and logout using Google (Hassen or Chedli)