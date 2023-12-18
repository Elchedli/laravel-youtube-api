<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Routing part
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/students', function () {
    return view('students');
});

Route::get('/student', function () {
    return response()->json([
        'name' => 'name1',
        'lastname' => 'lastname1',
    ]);
});

Route::get('/student1', function () {
    return redirect('/welcome');
});

//Controller part

//Method 1
// Route::get('/student',[studentController::class,'Student']);

//Method 2
Route::get('student','App\Http\Controllers\studentController@Student');



//Passing data part

Route::get('users',[UsersController::class,'getUsers']);