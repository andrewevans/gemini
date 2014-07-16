<?php

class SearchController extends \BaseController {

    protected $artist;
    protected $artwork;

    public function __construct(Artist $artist, Artwork $artwork)
    {
        $this->artist = $artist;
        $this->artwork = $artwork;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        $q = Str::lower(Input::get('q'));

        if ($q == '') {
            Session::flash('message', 'Redirected from blank search');
            return Redirect::to('/');
        }

        $q_id = Str::lower(Input::get('q_id'));

        if ($q_id != '') {

            $guid = explode('-', $q_id);

            switch ($guid[0]) {
                case 'a':
                    $artist_match = Artist::find($guid[1]);
                    $destination_url = $artist_match->url();
                    Session::flash('message', 'Directed to artist because exact match!');
                    break;

                case 'w':
                    $artwork_match = Artwork::find($guid[1]);
                    $destination_url = $artwork_match->url();
                    Session::flash('message', 'Directed to artwork because exact match!');
                    break;

                default:
                    $destination_url = '/';
                    Session::flash('message', 'Directed to home because invalid guid.');
                    break;
            }

            return Redirect::to($destination_url);
        }

        $q_all = explode(' ', $q);

        $artists_all = Artist::orderBy('last_name', 'asc')->get();

        $artists_string = '';
        $artists_qualified = [];

        $query_string = '';
        $query_count = 0;

        // add all of the artists whose name is in the search query
        foreach ($q_all as $key => $word) {
            foreach ($artists_all as $artist) {
                $artist_name = Str::lower($artist->first_name . ' ' . $artist->last_name);

                if (strpos($artist_name, $word . ' ') !== false || strpos($artist_name, ' ' . $word) !== false) {

                    if (in_array($artist, $artists_qualified) != true) $artists_qualified[] = $artist;

                    $artists_string .= ' ' . $word;
                    unset($q_all[$key]);
                }
            }
        }

        if ($artists_string != '') {
            $query_string_artists = "artist_id in (select id from artists b where MATCH(b.first_name,b.last_name,b.alias,b.slug) AGAINST('" . $artists_string . "' IN BOOLEAN MODE))";
        } else {
            $query_string_artists = 'true';
        }

        foreach ($q_all as $word) {
            if ($query_count != 0) $query_string .= ' and ';
            $query_string .= "MATCH(title,medium) AGAINST('*" . $word . "*' IN BOOLEAN MODE)";
            $query_count++;
        }

        if ($query_string == '') $query_string = "true";

        $artworks_qualified = Artwork::whereRaw($query_string)
            ->whereRaw($query_string_artists)
            ->where('sold', '!=', 1)
            ->where('hidden', '=', 0)
            ->orderByRaw(Session::get('sortBy.orderBy'))
            ->get();

        // add all of the artists whose arwork was found
        foreach ($artworks_qualified as $artwork) {
            if (in_array($artwork->artist, $artists_qualified) != true)  $artists_qualified[] = $artwork->artist;
        }

        $pages = new WP_Query( 's=' . $q . '&posts_per_page=-1&post_type=page');
        $posts = new WP_Query( 's=' . $q . '&posts_per_page=-1&post_type=post');

        return View::make('search.show')
            ->with('q', $q)
            ->with('artworks', $artworks_qualified)
            ->with('artists', $artists_qualified)
            ->with('pages', $pages)
            ->with('posts', $posts)
            ->with('page_title', $q . " - Artist/Artwork Search");

    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($data)
	{
		//
        return View::make('search.show')
            ->with('data', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
