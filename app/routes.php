<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('artists', 'ArtistsController');
Route::get('artists/{artist_url_slug?}/bio', 'ArtistsController@showBio');
Route::get('artists/{artist_url_slug?}/bio/{wp_url_slug?}', 'ArtistsController@showBio');
Route::resource('artworks', 'ArtworksController');
Route::resource('blog', 'BlogController');
Route::resource('search', 'SearchController');

// Route group for API versioning
Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{
    Route::resource('url', 'UrlController');
});

Route::resource('/user', 'UserController');
Route::controller('/', 'HomeController');
