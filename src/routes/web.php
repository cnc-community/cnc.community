<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
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

//
// Admin routes
Auth::routes();

// Admin Users management
Route::get('/admin/users', 'UsersController@index')->name('admin.users.listing')->middleware('role:admin');
Route::get('/admin/users/edit/{id}', 'UsersController@edit')->name('admin.users.edit')->middleware('role:admin');
Route::post('/admin/users/edit/{id}', 'UsersController@save')->name('admin.users.edit')->middleware('role:admin');

// Admin News management 
Route::get('/admin/news', 'NewsController@index')->name('admin.news.listing')->middleware('role:admin,editor');
Route::get('/admin/news/edit/{id}', 'NewsController@edit')->name('admin.news.edit')->middleware('role:admin,editor');
Route::post('/admin/news/edit/{id}', 'NewsController@save')->name('admin.news.edit')->middleware('role:admin,editor');

// Admin Feed management 
Route::get('/admin/queue', 'QueuedNewsController@index')->name('admin.queue.listing')->middleware('role:admin,editor');
Route::get('/admin/queue/edit/{id}', 'QueuedNewsController@edit')->name('admin.queue.edit')->middleware('role:admin,editor');
Route::post('/admin/queue/edit/{id}', 'QueuedNewsController@save')->name('admin.queue.edit')->middleware('role:admin,editor');

// Admin Page management
Route::get('/admin/pages', 'PageController@listPages')->name('admin.pages.listing')->middleware('role:admin');

Route::get('/admin/pages/add', 'PageController@addPage')->name('admin.pages.add')->middleware('role:admin');
Route::post('/admin/pages/add', 'PageController@createPage')->name('admin.pages.add')->middleware('role:admin');

// Page categories and custom fields
Route::get('/admin/pages/category/add', 'PageController@addPageCategory')->name('admin.pages.category.add')->middleware('role:admin');
Route::get('/admin/pages/category/edit/{id}', 'PageController@editPageCategory')->name('admin.pages.category.edit')->middleware('role:admin');
Route::post('/admin/pages/category/edit/{id}', 'PageController@savePageCategory')->name('admin.pages.category.edit')->middleware('role:admin');
Route::post('/admin/pages/category/add', 'PageController@createPageCategory')->name('admin.pages.category.add')->middleware('role:admin');
Route::get('/admin/pages/category/{id}/custom-fields', 'PageController@addPageCategoryCustomField')->name('admin.pages.category.fields.add')->middleware('role:admin');
Route::post('/admin/pages/category/{id}/custom-fields', 'PageController@createPageCategoryCustomField')->name('admin.pages.category.fields.add')->middleware('role:admin');


// Pages and custom fields
Route::get('/admin/pages/edit/{id}', 'PageController@editPage')->name('admin.pages.edit')->middleware('role:admin');
Route::post('/admin/pages/edit/{id}', 'PageController@savePage')->name('admin.pages.edit')->middleware('role:admin');

Route::get('/admin/pages/edit/{id}/custom-fields', 'PageController@addField')->name('admin.pages.fields.add')->middleware('role:admin');
Route::post('/admin/pages/edit/{id}/custom-fields', 'PageController@createCustomField')->name('admin.pages.fields.add')->middleware('role:admin');

// Feed endpoint - eventually hit by task runner
Route::get('/admin/feed', 'FeedController@index')->name('admin.feed')->middleware('role:admin,editor');

// Endpoint if we want to clear cache
Route::get('/admin/cache/clear', function(){ Cache::flush(); })->middleware('role:admin,editor');

// ----


//
// Public routes
Route::get('/', 'SiteController@index')->name('home');
Route::get('/news/{categorySlug}', 'SiteController@showNewsByCategorySlug')->name('news.listing');

// Pages by category + slug
Route::get('/{category?}', 'PageController@showPageByCategory');
Route::get('/{category}/{pageSlug?}', 'PageController@showPageBySlug')->name('pages.detail');