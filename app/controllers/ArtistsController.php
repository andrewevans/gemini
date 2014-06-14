<?php

class ArtistsController extends \BaseController {

    protected $artist;

    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
        $this->beforeFilter('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $artists = $this->artist->all();

        // load the view and pass the artists
        return View::make('artists.index')
            ->with('artists', $artists);
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
        return View::make('artists.create');
    }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        //
        $artist = new Artist;

        $input = Input::all();

        if ( ! $this->artist->fill($input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->artist->errors);
        }

        // store
        $artist->slug       = Input::get('slug');
        $artist->alias      = Input::get('alias');
        $artist->first_name      = Input::get('first_name');
        $artist->last_name      = Input::get('last_name');
        $artist->url_slug      = Input::get('url_slug');
        $artist->meta_title      = Input::get('meta_title');
        $artist->meta_description      = Input::get('meta_description');
        $artist->year_begin      = Input::get('year_begin');
        $artist->year_end      = Input::get('year_end');
//        $artist->slug       = $artist->url_slug(Input::get('slug'));

        $artist->save();

        // redirect
        Session::flash('message', 'Successfully updated artist!');
        return Redirect::to('artists');

    }


	/**
	 * Display the specified resource.
	 *
	 * @param  string $data OR int  $data
	 * @return Response
	 */
	public function show($data)
	{
		//
        if (! is_numeric($data)) {
            $artist = Artist::whereUrlSlug($data)->first();

            $page_title = $artist->title();
            $artist->img_url = $this->img_url($artist); // should be stored in artists table
            $artworks = $artist->artworks()->where('hidden', '!=', 1)->take(50)->orderBy('id', 'desc')->get();

            return View::make('artists.show', ['artist' => $artist, 'artworks' => $artworks, 'page_title' => $page_title]);
        }

        // get the artist
        $artist = Artist::find($data);

        Session::flash('message', 'You were forwarded here from ' . '<b>artists/' . $data . '</b>');
        return Redirect::to('artists/' . $artist->url_slug);

    }

    /**
     * Display the specified resource filtered by #data.
     *
     * @param  string $data
     * @return Response
     */
    public function filtered($data, $filter)
    {
        //
        $artist = Artist::whereUrlSlug($data)->first();

        $valid_medium = $artist->filterMediumReadable($filter);

        $valid_series = $artist->filterSeriesReadable($filter);

        if ($valid_medium) {
            $filter_query = $artist->medium_query($filter);
            $page_title = $valid_medium;
        } else if ($valid_series) {
            $filter_query = $artist->series_query($filter);
            $page_title = $valid_series;
        } else {
            // if a medium/series cannot be found for this artist, then redirect to artist page
            Session::flash('message', 'Redirected to artist page not a valid filter for this artist.');
            return Redirect::to($artist->url());
        }
        $artist->img_url = $this->img_url($artist); // should be stored in artists table
        $artworks = $artist->artworks()->whereRaw("(" . $filter_query . ")")->where('sold', '!=', '1')->where('hidden', '=', 0)->orderBy('id', 'desc')->get();


        return View::make('artists.show', ['artist' => $artist, 'artworks' => $artworks, 'page_title' => $artist->title($page_title)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $data OR int  $data
     * @return Response
     */
    public function showBio($artist_url_slug = null, $wp_url_slug = null)
    {
        $artist = Artist::whereUrlSlug($artist_url_slug)->first();
        $artist->img_url = $this->img_url($artist); // should be stored in artists table
        $artworks = $artist->artworks()->where('hidden', '!=', 1)->take(50)->orderBy('id', 'desc')->get();

        $args = array(
            'category_name'    => $artist->url_slug,
            'name'         => $wp_url_slug,
            'post_type'        => 'page',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'suppress_filters' => true );

        $post = current( get_posts( $args ) );

        if ( $wp_url_slug != null ) {
            return View::make('artists.showBioArticle', ['artist' => $artist, 'artworks' => $artworks, 'post' => $post]);
        }
        return View::make('artists.showBio', ['artist' => $artist, 'artworks' => $artworks]);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        // get the artist
        $artist = Artist::find($id);

        // show the edit form and pass the artist
        return View::make('artists.edit')
            ->with('artist', $artist);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        $artist = Artist::whereId($id)->first();

        $input = Input::all();

        if ( ! $this->artist->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->artist->errors);
        }
//  ['slug', 'alias', 'first_name', 'last_name', 'url_slug', 'meta_title', 'meta_description', 'year_begin', 'year_end'];

        // store
        //$artist = Artist::find($id);
        $artist->slug       = Input::get('slug');
        $artist->alias      = Input::get('alias');
        $artist->first_name      = Input::get('first_name');
        $artist->last_name      = Input::get('last_name');
        $artist->url_slug      = Input::get('url_slug');
        $artist->meta_title      = Input::get('meta_title');
        $artist->meta_description      = Input::get('meta_description');
        $artist->year_begin      = Input::get('year_begin');
        $artist->year_end      = Input::get('year_end');
//        $artist->slug       = $artist->url_slug(Input::get('slug'));

        $artist_dir = 'img/artists/' . $artist->url_slug . '/profile';

        // should be an easier way to create if not exists, or at least put in function
        if ( ! File::isDirectory($artist_dir)) {
            $result = File::makeDirectory($artist_dir, 0757, true);
        }

        $avatar = Input::file('avatar');

        // resizing an uploaded file
        if ($avatar != null) {
            $mime_type = $avatar->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make(Input::file('avatar')->getRealPath())->resize(ARTIST_MAX_WIDTH, null, true, false)->resize(null, ARTIST_MAX_HEIGHT, true, false)->save($this->img_url($artist));
        }

        $artist->save();

        // redirect
        Session::flash('message', 'Successfully updated artist!');
        return Redirect::to('artists');

    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        // delete
        $artist = Artist::find($id);

        $artist_dir = $this->img_directory_url($artist);

        if ($artist->url_slug != '') {
            File::deleteDirectory($artist_dir, false);
        }

        $artist->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the artist!');
        return Redirect::to('artists');
	}


    public function img_url($artist)
    {
        return $this->img_directory_url($artist) . '/profile/' . $artist->url_slug . '.jpg';
    }


    public function img_directory_url($artist)
    {
        return $artist_dir = 'img/artists/' . $artist->url_slug;
    }

}
