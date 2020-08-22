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

Route::get("/error", "APIController@showError");

Route::get('/twitch/streams/count', 'APIController@streamCount')->middleware('cache.headers:public;max_age=900');
Route::get('/twitch/streams/total-count', 'APIController@totalStreamCount')->middleware('cache.headers:public;max_age=900');

Route::get('/leaderboard/{game}/player/{playerId}', 'APIController@getPlayerRank')->middleware('cache.headers:public;max_age=900');
Route::get('/leaderboard/{game}/player/{playerId}/webview', 'APIController@getPlayerRankWebView')->middleware('cache.headers:public;max_age=900')->name("api.player.webview");
Route::get('/leaderboard/{game}/player/{playerId}/webview/config', 'APIController@configRankWebView')->middleware('cache.headers:public;max_age=0');
