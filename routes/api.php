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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/items', 'ItemController@list');
Route::post('/items', 'ItemController@create');
Route::patch('/items/{itemId}/found', 'ItemController@found');

Route::get('/players', 'PlayerController@list');
Route::post('/players', 'PlayerController@create');
Route::get('/players/{player}', 'PlayerController@get');
Route::patch('/players/{player}/level', 'PlayerController@updateLevel');
Route::patch('/players/{player}/manual-points', 'PlayerController@applyPoints');

Route::get('/teams', 'TeamController@list');
Route::post('/teams', 'TeamController@create');
Route::get('/teams/{team}', 'TeamController@get');
Route::patch('/teams/{team}', 'TeamController@update');
Route::post('/teams/{team}/players/{playerId}', 'TeamController@addPlayer');
Route::get('/teams/ranking', 'TeamController@ranking');
Route::get('/teams/ranking/{category}', 'TeamController@rankingForCategory');

Route::get('/game-start', 'GameController@start');
Route::get('/game-stop', 'GameController@stop');
