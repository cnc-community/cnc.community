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

Route::get('/leaderboard/top/ra', 'LeaderboardController@getTopRALeadeboard1vs1');
Route::get('/petroglyph/leaderboard', 'LeaderboardController@runTasks');

Route::get('/twitch/streams/count', 'APIController@streamCount');
Route::get('/twitch/streams/total-count', 'APIController@totalStreamCount');