<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('users', 'UserController');

Route::post('talk/{user}/user', 'TalkController@store');
Route::get('all/talks', 'TalkController@all');

Route::get('all_messages', 'MessageController@fetchMessages');
Route::get('messages/{talk}/talk', 'MessageController@talkMessages');
Route::post('messages/{user}/user/{talk}/talk', 'MessageController@sendMessage');


Route::get('talk/{slug}', 'TalkController@chat')->name('chat');
