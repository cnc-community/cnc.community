<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

//
// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function ()
{
    Auth::routes(['register' => false]);

    // Seed local leaderboard development 
    Route::get('/seed-local-development', 'LeaderboardController@seedLocalDevelopment');

    // Admin routes 
    Route::get('/dashboard', 'AdminController@index')->name('admin.index')->middleware('role:admin,editor');
    Route::post('/upload/editor', 'AdminController@uploadImageViaEditor')->name('upload')->middleware('role:admin,editor');

    // Route::get('/leaderboard', 'AdminLeaderboardController@getLeaderboardManager')->name('admin.leaderboard.index')->middleware('role:admin');
    // Route::post('/leaderboard/update', 'AdminLeaderboardController@updateLeaderboard')->name('admin.update:leaderboard')->middleware('role:admin');

    // Admin Users management
    Route::get('/users', 'UsersController@index')->name('admin.users.listing')->middleware('role:admin');
    Route::get('/users/edit/{id}', 'UsersController@edit')->name('admin.users.edit')->middleware('role:admin');
    Route::post('/users/edit/{id}', 'UsersController@save')->middleware('role:admin');
    Route::get('/users/create', 'UsersController@getCreate')->name('admin.users.add')->middleware('role:admin');
    Route::post('/users/create', 'UsersController@create')->name('admin.users.add')->middleware('role:admin');

    // Admin News management 
    Route::get('/news', 'NewsController@index')->name('admin.news.listing')->middleware('role:admin,editor');
    Route::get('/news/add', 'NewsController@getCreate')->name('admin.news.add')->middleware('role:admin,editor');
    Route::post('/news/add', 'NewsController@create')->name('admin.news.add')->middleware('role:admin,editor');
    Route::get('/news/edit/{id}', 'NewsController@edit')->name('admin.news.edit')->middleware('role:admin,editor');
    Route::post('/news/edit/{id}', 'NewsController@save')->middleware('role:admin,editor');


    // Admin Feed management 
    Route::get('/queue', 'QueuedNewsController@index')->name('admin.queue.listing')->middleware('role:admin,editor');
    Route::get('/queue/edit/{id}', 'QueuedNewsController@edit')->name('admin.queue.edit')->middleware('role:admin,editor');
    Route::post('/queue/edit/{id}', 'QueuedNewsController@save')->middleware('role:admin,editor');

    // Admin Page management
    Route::get('/pages', 'PageController@listPages')->name('admin.pages.listing')->middleware('role:admin');

    Route::get('/pages/add', 'PageController@addPage')->name('admin.pages.add')->middleware('role:admin');
    Route::post('/pages/add', 'PageController@createPage')->middleware('role:admin');

    // Page categories and custom fields
    Route::get('/pages/category/add', 'PageController@addPageCategory')->name('admin.pages.category.add')->middleware('role:admin');
    Route::get('/pages/category/edit/{id}', 'PageController@editPageCategory')->name('admin.pages.category.edit')->middleware('role:admin');
    Route::post('/pages/category/edit/{id}', 'PageController@savePageCategory')->middleware('role:admin');
    Route::post('/pages/category/add', 'PageController@createPageCategory')->middleware('role:admin');
    Route::get('/pages/category/{id}/custom-fields', 'PageController@addPageCategoryCustomField')->name('admin.pages.category.fields.add')->middleware('role:admin');
    Route::post('/pages/category/{id}/custom-fields', 'PageController@createPageCategoryCustomField')->middleware('role:admin');

    // Pages and custom fields
    Route::get('/pages/edit/{id}', 'PageController@editPage')->name('admin.pages.edit')->middleware('role:admin');
    Route::post('/pages/edit/{id}', 'PageController@savePage')->middleware('role:admin');

    Route::get('/pages/edit/{id}/custom-fields', 'PageController@addField')->name('admin.pages.fields.add')->middleware('role:admin');
    Route::post('/pages/edit/{id}/custom-fields', 'PageController@createCustomField')->middleware('role:admin');

    // Endpoint if we want to clear cache
    Route::get('/cache/clear', 'SiteController@clearCache')->middleware('role:admin,editor');

    // Ckeditor endpointfor image uploads
    Route::post('/upload/image', 'ImageUploadController@upload')->name('uploadImage');
});


//
// Public routes
Route::get('/', 'SiteController@index')->name('home')->middleware('cache.headers:public;max_age=1800');
Route::get('/funny', 'SiteController@showFunnyListings')->name('pages.funny.listing')->middleware('cache.headers:public;max_age=3600');
Route::get('/donate', 'SiteController@showDonate')->name('pages.donate')->middleware('cache.headers:public;max_age=14400');
Route::get('/stats', 'StatsController@showStats')->name('pages.stats')->middleware('cache.headers:public;max_age=400');
Route::get('/command-and-conquer-ultimate-collection-steam', 'SiteController@showTUCPage')->name('pages.tuc')->middleware('cache.headers:public;max_age=400');
Route::get('/command-and-conquer-ultimate-collection-online', 'SiteController@showTUCMultiplayerPage')->name('pages.tucMultiplayer')->middleware('cache.headers:public;max_age=400');

// Petro games
Route::get('/8bitarmies/leaderboard', 'LadderController@getEightBitArmiesIndex')->name('8bit.leaderboard');
Route::get('/9bitarmies/leaderboard', 'LadderController@getNineBitArmiesIndex')->name('9bit.leaderboard');
Route::get('/command-and-conquer-remastered/leaderboard/{game}', 'LadderController@getRemasteredIndex')->middleware('cache.headers:public;max_age=480');

Route::get('/command-and-conquer-remastered/leaderboard/tiberian-dawn/season/{season}', 'LadderController@getSpecificSeasonTDLeaderboard');

Route::get('/cnc-streamers', 'SiteController@showCreatorsListings')->name('pages.creators.listing')->middleware('cache.headers:public;max_age=1800');
Route::get('/creators', function ()
{
    return Redirect::to('/cnc-streamers', 301);
});
Route::get('/command-and-conquer-25-years', 'AnniversaryController@index')->name('pages.anniversary')->middleware('cache.headers:public;max_age=1800');
Route::get('/command-and-conquer-remastered', 'SiteController@showRemastersListings')->name('pages.remasters.listing')->middleware('cache.headers:public;max_age=1800');
Route::get('/command-and-conquer-remastered/workshop-mods', 'SiteController@showRemastersWorkshopMods')->name('pages.remasters.workshop.listings')->middleware('cache.headers:public;max_age=14400');

Route::get('/news/{categorySlug}', 'SiteController@showNewsByCategorySlug')->name('news.listing')->middleware('cache.headers:public;max_age=14400');
Route::get('/news/{categorySlug?}/{newsSlug}', 'SiteController@showNewsBySlug')->name('news.detail')->middleware('cache.headers:public;max_age=14400');

// Pages by category + slug
Route::get('/{category?}', 'SiteController@showPageByCategory')->name('news.detail')->middleware('cache.headers:public;max_age=3600');
Route::get('/{category?}/{pageSlug?}', 'SiteController@showPageBySlug')->name('pages.detail')->name('news.detail')->middleware('cache.headers:public;max_age=3600');
