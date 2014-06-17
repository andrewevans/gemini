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
Route::get('artists/id/{artwork_id}', 'ArtworksController@show');
Route::get('artists/{artist_url_slug}/{filter}', ['as' => 'artists.show.filter', 'uses' =>'ArtistsController@filtered']);
Route::get('artists/{artist_url_slug?}/bio', 'ArtistsController@showBio');
Route::get('artists/{artist_url_slug?}/bio/{wp_url_slug?}', 'ArtistsController@showBio');
Route::resource('artworks', 'ArtworksController');
Route::get('artists/{artist_url_slug}/{artwork_url_slug?}/id/{id}', array('as' => 'artworks.showOne', 'uses' => 'ArtworksController@show'))->where('artwork_url_slug', '(.*)');
Route::resource('blog', 'BlogController');
Route::resource('search', 'SearchController');

// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('url', 'UrlController');
});

Route::resource('/user', 'UserController');
Route::controller('/', 'HomeController');
