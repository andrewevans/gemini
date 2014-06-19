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
Route::resource('people', 'ArtistsController');
Route::resource('catalogues', 'CataloguesController');
Route::resource('catrefs', 'CatrefsController');
Route::get('artists/{artist_url_slug}/bio/catalogue-raisonnes', ['as' => 'artists.catalogues.index', 'uses' => 'CataloguesController@index']);
Route::get('artists/{artist_url_slug}/bio/catalogue-raisonnes/{catalogue_url_slug}', ['as' => 'artists.catalogues.show', 'uses' => 'CataloguesController@show']);
Route::get('artists/{artist_url_slug}/bio/catalogue-raisonnes/{catalogue_url_slug}/{catref_url_slug}/id/{catref_id}', ['as' => 'artists.catrefs.show', 'uses' => 'CatrefsController@show']);
Route::get('artists/id/{artwork_id}', 'ArtworksController@show');
Route::get('artists/{artist_url_slug}/{filter}', ['as' => 'artists.show.filter', 'uses' =>'ArtistsController@filtered'])->where('filter', '^(?!bio)$');
Route::get('artists/{artist_url_slug?}/bio', ['as' => 'artists.show.bio', 'uses' => 'ArtistsController@showBio']);
Route::get('artists/{artist_url_slug?}/bio/{wp_url_slug?}', 'ArtistsController@showBio')->where('wp_url_slug', '^(?!catalogue\-raisonne)$');
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
