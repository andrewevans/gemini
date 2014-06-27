<?php

class ArtistsController extends \BaseController {

    protected $artist;
    protected $person;

    public function __construct(Artist $artist, Person $person)
    {
        $this->artist = $artist;
        $this->person = $person;
        //$this->beforeFilter('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ($this->isNonartist()) {
            $persons = $this->person->all();

            return View::make('persons.index')
                ->with('persons', $persons)
                ->with('page_title', "All the People");
        }

        $artists = $this->artist->all();

        // load the view and pass the artists
        return View::make('artists.index')
            ->with('artists', $artists)
            ->with('page_title', "All the Artists");
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
        return View::make('artists.create')
            ->with('page_title', "Create Artist or Person");
    }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        //
        $input = Input::all();

        if ($input['person_niche'] != 'niche_artist') {
            $artist = new Person;
        } else {
            $artist = new Artist;
        }

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
        if ($this->isNonartist()) {
            $person = Person::whereUrlSlug($data)->first();
            $person->catalogues = [];
            $person->artworks = [];

            $page_title = $person->title();

            return View::make('persons.show', ['person' => $person, 'page_title' => $page_title]);
        }

        $artist = Artist::whereUrlSlug($data)->first();

        $page_title = $artist->title();
        $artworks = $artist->artworks()->where('hidden', '!=', 1)->take(50)->orderBy('id', 'desc')->get();

        return View::make('artists.show', ['artist' => $artist, 'artworks' => $artworks, 'page_title' => $page_title]);
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
            $valid_filter = $valid_medium;
            $filter_query = $artist->medium_query($filter);
            $page_title = $valid_medium;
        } else if ($valid_series) {
            $valid_filter = $valid_series;
            $filter_query = $artist->series_query($filter);
            $page_title = $valid_series;
        } else {
            // if a medium/series cannot be found for this artist, then redirect to artist page
            Session::flash('message', 'Redirected to artist page not a valid filter for this artist.');
            return Redirect::to($artist->url());
        }

        $artworks = $artist->artworks()->whereRaw("(" . $filter_query . ")")->where('sold', '!=', '1')->where('hidden', '=', 0)->orderBy('id', 'desc')->get();

        return View::make('artists.show', ['artist' => $artist, 'artworks' => $artworks, 'page_title' => $artist->title($page_title), 'filter' => $valid_filter]);
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

        // if this is a page/post, then display it
        if ( $wp_url_slug != null ) {
            return View::make('artists.showBioArticle', ['artist' => $artist, 'artworks' => $artworks, 'post' => $post]);
        }

        return View::make('artists.showBio', ['artist' => $artist, 'artworks' => $artworks, 'page_title' => $artist->alias . " Biography"]);
    }


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if ($this->isNonartist()) {
            $person = Person::find($id);

            // show the edit form and pass the artist
            return View::make('persons.edit')
                ->with('person', $person)
                ->with('page_title', "Edit: " . $person->alias);
        }

        // get the artist
        $artist = Artist::find($id);

        // show the edit form and pass the artist
        return View::make('artists.edit')
            ->with('artist', $artist)
            ->with('page_title', "Edit: " . $artist->alias);
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
        $input = Input::all();

        if ($this->isNonartist()) {
            $artist = Person::whereId($id)->first();
        } else {
            $artist = Artist::whereId($id)->first();
        }

        if ( ! $this->artist->fill($input)->isValid($id))
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

        // should be an easier way to create if not exists, or at least put in function
        if ( ! File::isDirectory($artist->img_directory_url())) {
            $result = File::makeDirectory($artist->img_directory_url(), 0757, true);
        }

        $avatar = Input::file('avatar');

        // resizing an uploaded file
        if ($avatar != null) {
            $mime_type = $avatar->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make(Input::file('avatar')->getRealPath())->resize(ARTIST_MAX_WIDTH, null, true, false)->resize(null, ARTIST_MAX_HEIGHT, true, false)->save($artist->img_url(true));
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
        if ($this->isNonartist()) {
            $artist = Person::find($id);
        } else {
            $artist = Artist::find($id);
        }

        $artist_dir = $artist->img_directory_url();

        if ($artist->url_slug != '') {
            File::deleteDirectory($artist_dir, false);
        }

        $artist->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the artist!');
        return Redirect::to('artists');
	}


    public function isNonartist()
    {
        $current_route = Route::currentRouteName();

        // if this is a non-artist...
        if (strpos($current_route, 'people') !== false) {
            return true;
        }

        return false;
    }

}
