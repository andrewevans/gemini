<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
    $user = User::find(12);
    Auth::login($user);

    // omit api calls and non-standard *.php pages
    // @TODO: api calls should always be desktop or special subdomain
    if (strpos(Request::server('REQUEST_URI'), '/api') !== 0
        && strpos(Request::server('REQUEST_URI'), '.php') === false) {

        $original_uri = 'request=' . str_replace('?', '&', Request::server('REQUEST_URI'));

        // desktop but trying m., go to desktop
        if (! Agent::isMobile() && strpos(Request::root(),
                Config::get('app.root_mobile')) !== false) {
            return Redirect::to('//' . Config::get('app.root_desktop') .
                '/?redir=m2d&' . $original_uri, 302);
        }

        // mobile www, go to m.
        if (Agent::isMobile() && strpos(Request::root(),
                Config::get('app.root_desktop')) !== false) {
            return Redirect::to('//' . Config::get('app.root_mobile') .
                '/?redir=d2m&' . $original_uri, 302);
        }

        // @TODO: use regexes to decrease LOC
        // handle redir requests involving /inventory
        if (! Input::get('completed')
            && strpos(Input::get('request'), '/inventory/') === 0) {

            $request_uri = explode('/', trim(Input::get('request'), '/'));
            $request_id_key = array_search('id', $request_uri);
            $path = '';

            if ($request_id_key) {
                // like: /inventory/andy-warhol/screenprint/mick-jagger-1975/id/4886
                $artwork = Artwork::find($request_uri[$request_id_key + 1]);
                $path = $artwork->url();
            } else {

                if (sizeof($request_uri) == 2 && is_numeric($request_uri[1])) {
                    // like: /inventory/5043
                    $artwork = Artwork::find((int)$request_uri[1]);
                    $path = ($artwork == null) ? '' : $artwork->url();
                } else {

                    switch (sizeof($request_uri)) {
                        case 2:
                            // like: /inventory/picasso
                            $artist = Artist::whereSlug($request_uri[1])->first();
                            $path = ($artist == null) ? '' : $artist->url();
                            break;

                        case 3:
                            // like: /inventory/picasso/ceramics
                            $artist = Artist::whereSlug($request_uri[1])->first();
                            $path = ($artist == null) ? '' : $artist->url();
                            $path .= '/' . $request_uri[2];
                            break;
                    }
                }
            }

            return Redirect::to($path
                . '?completed=1&'
                . Request::server('QUERY_STRING'), 302);
        }
    }
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

View::composer('layouts.default', function($view){
    $artists = Artist::
        whereRaw('id !=0')
        ->whereIn('id', function($query)
        {
            $query->select('artist_id')
                ->from('artworks')
                ->whereRaw('sold = 0 and hidden = 0');
        })->orderBy('last_name', 'asc')->get();

    $view->with('artists', $artists);
});

View::composer('widgets.artists.artist', function($view){
    $view->with('artist', $view->artist);
});

View::composer('widgets.artists.bio', function($view){

    $filter = '';

    if (isset($view->filter_slug)) {
        $filter = $view->filter_slug . '-';
    }

    $args = array(
        'category_name'    => $filter . $view->artist->url_slug . '-artist-biography',
        'post_type'        => 'page',
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'post_status'      => 'publish',
        'suppress_filters' => true );

    $biographies = get_posts( $args );

    // If no biographies for that filter, then just show all of them for that artist
    if (sizeof($biographies) < 1) {
        $args['category_name'] = $view->artist->url_slug . '-artist-biography';
        $biographies = get_posts( $args );
    }

    $view->with('artist', $view->artist)->with('biographies', $biographies);
});

View::composer('widgets.artists.pages', function($view){

    $args = array(
        'category_name'    => $view->artist->url_slug,
        'post_type'        => 'page',
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'post_status'      => 'publish',
        'suppress_filters' => true );

    $posts = get_posts( $args );

    $view->with('artist', $view->artist)
        ->with('posts', $posts);
});


View::composer('widgets.pages', function($view){

    if (isset($view->filter)) {
        $category_name = $view->filter;
    } else {
        $category_name = $view->artist->url_slug;
    }

    $args = array(
        'category_name'    => $category_name,
        'post_type'        => 'page',
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'post_status'      => 'publish',
        'suppress_filters' => true );

    $posts = get_posts( $args );

    $view->with('artist', $view->artist)
        ->with('posts', $posts)
        ->with('category_name', $category_name);
});

View::composer('widgets.artists.posts', function($view, $offset = null){
    $args = array(
        'category_name'    => $view->artist->url_slug,
        'post_type'        => 'post',
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'post_status'      => 'publish',
        'suppress_filters' => true );

    $posts = get_posts( $args );

    $view->with('artist', $view->artist)
        ->with('posts', $posts);
});

View::composer('widgets.post', function($view){

    if (isset($view->posts)) {
        $posts = $view->posts;
    } else {
        $args = array(
            'post_type'        => 'post',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'suppress_filters' => true );

        $posts = get_posts( $args );
    }

    if ($view->offset > sizeof($posts)) {
        $view->offset = 0;
    }

    $post = $posts[$view->offset];

    $view->with('artist', $view->artist)
        ->with('post', $post);
});

View::composer('widgets.nav', function($view){
    $parent = get_page_by_path($view->parent);
    $posts = get_pages(array(
        'child_of' => $parent->ID,
        'hierarchical'=> 0,
        'parent'=> $parent->ID
    ));

    $view->with('posts', $posts)
        ->with('parent', $parent);
});

View::composer('widgets.filters.list', function($view){
    $params = Input::all();

    $params['list'] = 'row';
    $queryString = http_build_query($params);
    $current_url['row'] = URL::to(URL::current() . '?' . $queryString);

    $params['list'] = 'card';
    $queryString = http_build_query($params);
    $current_url['card'] = URL::to(URL::current() . '?' . $queryString);

    $view->with('current_url', $current_url);
});

View::composer('widgets.splashes', function($view){

    switch(Route::current()->getName()) {
        case 'artists.show':
            $slug = $view->artist->slug;
            break;

        case 'home.index':
            $slug = 'home';
            break;

        default:
            $slug = null;
            break;
    }

    if ($slug != null) {
        $splashes = DB::table('splashes')
            ->where('location_slug', '=', $slug)
            ->orderBy('position', 'ASC')
            ->get();
    } else {
        $splashes = null;
    }

    $view->with('splashes', $splashes);
});

View::composer('widgets.share', function($view){

    $page_info['message'] = 'Somewhere...';

    switch (Route::current()->getName()) {

        case 'artworks.showOne':
            $page_info['message'] = $view->artwork->artist->alias . ', ' . $view->artwork->medium_short() . ' | ' . $view->artwork->title_short();
            break;

        case 'artists.show.bio.page':
            $page_info['message'] = $view->post->post_title;
            break;

        default:
            break;

    }

    $view->with('page_info', $page_info);
});

View::composer('widgets.splashes*', function($view) {

    if (isset($view->artist)) {
        $location_slug = $view->artist->slug;
    } else {
        $location_slug = 'home';
    }

    $splashes = Splash::where('location_slug', '=', $location_slug)->orderBy('position', 'ASC')->get();

    $view->with('splashes', $splashes);
});