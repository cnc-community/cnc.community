<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/news/{categorySlug}', 'SiteController@showNewsByCategorySlug')->name('news.listing');

// Admin routes
Auth::routes();

Route::get('/admin/news', 'NewsController@index')->name('admin.news.listing');
Route::get('/admin/news/edit/{id}', 'NewsController@edit')->name('admin.news.edit');
Route::post('/admin/news/edit/{id}', 'NewsController@save')->name('admin.news.edit');

Route::get('/admin/queue', 'QueuedNewsController@index')->name('admin.queue.listing');
Route::get('/admin/queue/edit/{id}', 'QueuedNewsController@edit')->name('admin.queue.edit');
Route::post('/admin/queue/edit/{id}', 'QueuedNewsController@save')->name('admin.queue.edit');
