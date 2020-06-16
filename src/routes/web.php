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
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () 
{
    Auth::routes();
    
    Route::get('/dashboard', 'AdminController@index')->name('admin.index')->middleware('role:admin,editor');
    
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
    
    // Feed endpoint - eventually hit by task runner
    Route::get('/feed', 'FeedController@index')->name('admin.feed')->middleware('role:admin,editor');
    
    // Endpoint if we want to clear cache
    Route::get('/cache/clear', 'SiteController@clearCache')->middleware('role:admin,editor');
});


//
// Public routes
Route::get('/', 'SiteController@index')->name('home');
Route::get('/funny', 'SiteController@showFunnyListings')->name('pages.funny.listing');
Route::get('/creators', 'SiteController@showCreatorsListings')->name('pages.creators.listing');
Route::get('/command-and-conquer-remastered', 'SiteController@showRemastersListings')->name('pages.remasters.listing');
Route::get('/command-and-conquer-remastered/workshop-mods', 'SiteController@showRemastersWorkshopMods')->name('pages.remasters.workshop.listings');
Route::get('/command-and-conquer-remastered/leaderboard', 'LeaderboardController@getLeaderboardListings')->name('pages.remasters.leaderboard.listings');
Route::get('/command-and-conquer-remastered/leaderboard/{game}', 'LeaderboardController@getLeaderboardListingsByGame')->name('pages.remasters.leaderboard.detail');
Route::get('/command-and-conquer-remastered/leaderboard/{game}/player/{playerId}', 'LeaderboardController@getPlayerLeaderboardProfile')->name('pages.remasters.leaderboard.player-detail');

Route::get('/news/{categorySlug}', 'SiteController@showNewsByCategorySlug')->name('news.listing');
Route::get('/news/{categorySlug?}/{newsSlug}', 'SiteController@showNewsBySlug')->name('news.detail');

// Pages by category + slug
Route::get('/{category?}', 'SiteController@showPageByCategory');
Route::get('/{category?}/{pageSlug?}', 'SiteController@showPageBySlug')->name('pages.detail');