<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::post('/admin/users/edit/{id}', 'UsersController@save')->middleware('role:admin');

// Admin News management 
Route::get('/admin/news', 'NewsController@index')->name('admin.news.listing')->middleware('role:admin,editor');
Route::get('/admin/news/add', 'NewsController@getCreate')->name('admin.news.add')->middleware('role:admin,editor');
Route::post('/admin/news/add', 'NewsController@create')->name('admin.news.add')->middleware('role:admin,editor');
Route::get('/admin/news/edit/{id}', 'NewsController@edit')->name('admin.news.edit')->middleware('role:admin,editor');
Route::post('/admin/news/edit/{id}', 'NewsController@save')->middleware('role:admin,editor');

// Admin Feed management 
Route::get('/admin/queue', 'QueuedNewsController@index')->name('admin.queue.listing')->middleware('role:admin,editor');
Route::get('/admin/queue/edit/{id}', 'QueuedNewsController@edit')->name('admin.queue.edit')->middleware('role:admin,editor');
Route::post('/admin/queue/edit/{id}', 'QueuedNewsController@save')->middleware('role:admin,editor');

// Admin Page management
Route::get('/admin/pages', 'PageController@listPages')->name('admin.pages.listing')->middleware('role:admin');

Route::get('/admin/pages/add', 'PageController@addPage')->name('admin.pages.add')->middleware('role:admin');
Route::post('/admin/pages/add', 'PageController@createPage')->middleware('role:admin');

// Page categories and custom fields
Route::get('/admin/pages/category/add', 'PageController@addPageCategory')->name('admin.pages.category.add')->middleware('role:admin');
Route::get('/admin/pages/category/edit/{id}', 'PageController@editPageCategory')->name('admin.pages.category.edit')->middleware('role:admin');
Route::post('/admin/pages/category/edit/{id}', 'PageController@savePageCategory')->middleware('role:admin');
Route::post('/admin/pages/category/add', 'PageController@createPageCategory')->middleware('role:admin');
Route::get('/admin/pages/category/{id}/custom-fields', 'PageController@addPageCategoryCustomField')->name('admin.pages.category.fields.add')->middleware('role:admin');
Route::post('/admin/pages/category/{id}/custom-fields', 'PageController@createPageCategoryCustomField')->middleware('role:admin');


// Pages and custom fields
Route::get('/admin/pages/edit/{id}', 'PageController@editPage')->name('admin.pages.edit')->middleware('role:admin');
Route::post('/admin/pages/edit/{id}', 'PageController@savePage')->middleware('role:admin');

Route::get('/admin/pages/edit/{id}/custom-fields', 'PageController@addField')->name('admin.pages.fields.add')->middleware('role:admin');
Route::post('/admin/pages/edit/{id}/custom-fields', 'PageController@createCustomField')->middleware('role:admin');

// Feed endpoint - eventually hit by task runner
Route::get('/admin/feed', 'FeedController@index')->name('admin.feed')->middleware('role:admin,editor');

// Endpoint if we want to clear cache
Route::get('/admin/cache/clear', 'SiteController@clearCache')->middleware('role:admin,editor');


//
// Public routes
Route::get('/', 'SiteController@index')->name('home');
Route::get('/funny', 'SiteController@showFunnyListings')->name('pages.funny.listing');
Route::get('/creators', 'SiteController@showCreatorsListings')->name('pages.creators.listing');
Route::get('/remasters', 'SiteController@showRemastersListings')->name('pages.remasters.listing');

Route::get('/news/{categorySlug}', 'SiteController@showNewsByCategorySlug')->name('news.listing');
Route::get('/news/{categorySlug?}/{newsSlug}', 'SiteController@showNewsBySlug')->name('news.detail');

// Pages by category + slug
Route::get('/{category?}', 'PageController@showPageByCategory');
Route::get('/{category}/{pageSlug?}', 'PageController@showPageBySlug')->name('pages.detail');