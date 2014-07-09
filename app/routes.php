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

Route::resource('people', 'ArtistsController');

Route::get('artists',  ['as' => 'artists.index', 'uses' => 'ArtistsController@index']);
Route::get('artists/{artist_url_slug}',  ['as' => 'artists.show', 'uses' => 'ArtistsController@show']);
Route::get('artists/{artist_url_slug}/bio/catalogue-raisonnes', ['as' => 'artists.catalogues.index', 'uses' => 'CataloguesController@index']);
Route::get('artists/{artist_url_slug}/bio/catalogue-raisonnes/{catalogue_url_slug}', ['as' => 'artists.catalogues.show', 'uses' => 'CataloguesController@show']);
Route::get('artists/{artist_url_slug}/bio/catalogue-raisonnes/{catalogue_url_slug}/{catref_url_slug}/id/{catref_id}', ['as' => 'artists.catrefs.show', 'uses' => 'CatrefsController@show']);
Route::get('artists/id/{artwork_id}', 'ArtworksController@show');
Route::get('artists/{artist_url_slug}/{artwork_url_slug?}/id/{id}', array('as' => 'artworks.showOne', 'uses' => 'ArtworksController@show'))->where('artwork_url_slug', '(.*)');
Route::get('artists/{artist_url_slug}/{filter}', ['as' => 'artists.show.filter', 'uses' =>'ArtistsController@filtered'])->where('filter', '^(?!bio).*$');
Route::get('artists/{artist_url_slug?}/bio', ['as' => 'artists.show.bio', 'uses' => 'ArtistsController@showBio']);
Route::get('artists/{artist_url_slug?}/bio/{wp_url_slug}', ['as' => 'artists.show.bio.page', 'uses' => 'ArtistsController@showBio'])->where('wp_url_slug', '^((?!catalogue-raisonne).)*$');

Route::get('articles', ['as' => 'articles.index', 'uses' => 'StaticController@showArticle']);
Route::get('articles/{wp_url_slug}', ['as' => 'articles.show', 'uses' => 'StaticController@showArticle']);

Route::get('artworks', ['as' => 'artworks.index', 'uses' => 'ArtworksController@index']);
Route::get('artworks/{id}', ['as' => 'artworks.show', 'uses' => 'ArtworksController@show']);

Route::get('catalogues', ['as' => 'catalogues.index', 'uses' => 'CataloguesController@index']);
Route::get('catalogues/{id}', ['as' => 'catalogues.show', 'uses' => 'CataloguesController@show']);

Route::get('catrefs', ['as' => 'catrefs.index', 'uses' => 'CatrefsController@index']);
Route::get('catrefs/{id}', ['as' => 'catrefs.show', 'uses' => 'CatrefsController@show']);

Route::resource('blog', 'BlogController');
Route::resource('search', 'SearchController');
Route::resource('contact', 'ContactController');
Route::resource('sell', 'SellController');
Route::resource('purchase', 'PurchaseController');
Route::resource('offer', 'PurchaseController');
Route::resource('login', 'HomeController@getLogin');

// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('url', 'UrlController');
    Route::get('newsletter/{cust_email}/{first_name?}/{last_name?}/{lists?}', ['as' => 'api.newsletter', 'uses' => 'UrlController@newsletter']);
});

Route::get('gemini', ['as' => 'gemini.index', 'uses' => 'GeminiController@index'])->before('auth');;

Route::group(array('prefix' => 'gemini', 'before' => 'auth.basic'), function()
{

    Route::resource('artists', 'ArtistsController');
    Route::get('artists', ['as' => 'gemini.artists', 'uses' => 'GeminiController@artists']);

    Route::resource('artworks', 'ArtworksController');
    Route::get('artworks', ['as' => 'gemini.artworks', 'uses' => 'GeminiController@artworks']);

    Route::resource('catalogues', 'CataloguesController');
    Route::get('catalogues', ['as' => 'gemini.catalogues', 'uses' => 'GeminiController@catalogues']);

    Route::resource('catrefs', 'CatrefsController');
    Route::get('catrefs', ['as' => 'gemini.catrefs', 'uses' => 'GeminiController@catrefs']);

    Route::resource('user', 'UserController');
    Route::get('user', ['as' => 'gemini.user', 'uses' => 'GeminiController@users']);

});



Route::get('{tree_stump}/{tree_branches?}',['as' => 'static.show', 'uses' => 'StaticController@show'])->where('tree_branches', '(.*)');
Route::controller('/', 'HomeController');