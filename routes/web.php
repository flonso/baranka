<?php

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

Route::redirect('/', '/game', 301);

Route::get("/game", function () {
    return view('game');
});
Route::get("/admin", function () {
    return view('admin');
});
Route::get("/players", 'PlayersViewController@get');
Route::get("/items", 'ItemsViewController@get');
