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

Route::post('login', 'UserController@login')->name('login');
Route::post('register', 'UserController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
   return $request->user();
});

Route::apiResource('users', 'UserController');
// Route::get('user', 'UserController@user')->name('me');
Route::get('user/{user}/logout', 'UserController@logout')->name('logout');

Route::post('talk/{user}/user', 'TalkController@store');
Route::get('all/talks', 'TalkController@all');
Route::get('talk/{talk}/users', 'TalkController@talkUsers')->name('talk.users');
Route::get('talk/{slug}', 'TalkController@show')->name('talk.show');

Route::get('all_messages', 'MessageController@fetchMessages');
Route::get('messages/{talk}/talk', 'MessageController@talkMessages')->name('talk.messages');
Route::post('messages/{user}/user/{talk}/talk', 'MessageController@sendMessage');


Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');