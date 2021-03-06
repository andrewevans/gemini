<?php

class GeminiController extends \BaseController {

    public function __construct(Artwork $artwork, Artist $artist, Person $person, Catalogue $catalogue, Catref $catref, User $user)
    {
        $this->artwork = $artwork;
        $this->artist = $artist;
        $this->person = $person;
        $this->catalogue = $catalogue;
        $this->catref = $catref;
        $this->user = $user;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('gemini.index');
    }


    /**
     * Display a listing of artists
     *
     * @return Response
     */
    public function artists()
    {
        if ($this->isNonartist()) {
            $persons = $this->person->all();

            return View::make('gemini.persons')
                ->with('persons', $persons)
                ->with('page_title', "All the People");
        }

        $artists = $this->artist->all();

        // load the view and pass the artists
        return View::make('gemini.artists')
            ->with('artists', $artists)
            ->with('page_title', "All the Artists");
    }


    /**
     * Display a listing of artworks
     *
     * @return Response
     */
    public function artworks($id = null)
    {
        if ($id == null) {
            $artworks = $this->artwork
                ->whereIn('artist_id', function($query)
                {
                    $query->select('id')
                        ->from('artists')
                        ->whereRaw('id != 0');
                })->orderBy('id', 'desc')->limit(30)->get();
        } else {
            $artworks[] = $this->artwork->find($id);

            if ($artworks[0] == null) {
                $artworks = $this->artwork->whereRaw('title like "%' . $id .'%"')->get();
            }
        }

        // load the view and pass the artworks
        return View::make('gemini.artworks', [
        'artworks' => $artworks,
        'page_title' => "All the Artworks"]);
    }


    /**
     * Display a listing of catalogues
     *
     * @return Response
     */
    public function catalogues($id = null)
    {
        if ($id == null) {
            $catalogues = $this->catalogue->whereIn('artist_id', function($query)
            {
                $query->select('id')
                    ->from('artists')
                    ->whereRaw('id != 0');
            })->orderBy('id', 'desc')->get();
        } else {
            $catalogues[] = $this->catalogue->find($id);

            if ($catalogues[0] == null) {
                $catalogues = $this->catalogue->whereRaw('title like "%' . $id .'%"')->get();
            }
        }

        // load the view and pass the catalogues
        return View::make('gemini.catalogues', [
            'catalogues' => $catalogues,
            'page_title' => "All the Catalogues"]);
    }


    /**
     * Display a listing of catrefs
     *
     * @return Response
     */
    public function catrefs($id = null)
    {
        if ($id == null) {
            $catrefs = $this->catref->whereIn('catalogue_id', function($query)
            {
                $query->select('id')
                    ->from('catalogues')
                    ->whereIn('artist_id', function($query)
                    {
                        $query->select('id')
                            ->from('artists')
                            ->whereRaw('id != 0');
                    })->orderBy('id', 'desc');
            })->orderBy('id', 'desc')->get();
        } else {
            $catrefs[] = $this->catref->find($id);

            if ($catrefs[0] == null) {
                $catrefs = $this->catref->whereRaw('title like "%' . $id .'%"')->get();
            }
        }

        // load the view and pass the catrefs
        return View::make('gemini.catrefs', [
            'catrefs' => $catrefs,
            'page_title' => "All the Catrefs"]);
    }


    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function users($id = null)
    {
        if ($id == null) {
            $users = $this->user->all();
        } else {
            $users[] = $this->user->find($id);

            if ($users[0] == null) {
                $users = $this->user->whereRaw('title like "%' . $id .'%"')->get();
            }
        }

        // load the view and pass the users
        return View::make('gemini.users', [
            'users' => $users,
            'page_title' => "All the Users"]);
    }


    public function magnitudes()
    {
        $input = Input::all();

        $artists = DB::table('artists')->orderBy('alias', 'desc')->lists('alias','id');

        if (isset($input['artist_id'])) {
            $artist = Artist::find($input['artist_id']);
            $artworks_mags = $artist->artworks()
                ->join('object_importance', 'object_importance.object_id', '=', 'artworks.id')
                ->where('object_importance.object_type', '=', 'w-' . $artist->slug) // get only artworks
                ->select('*', 'object_importance.id as object_importance_id', 'artworks.id as id')
                ->orderBy('magnitude', 'ASC')
                ->get();

            $artworks_from_artist = $artist->artworks()->whereNotExists(function($query)
            {
                $query->select(DB::raw(1))
                    ->from('object_importance')
                    ->whereRaw('artworks.id = object_importance.object_id');
            })->where('sold', '!=', '1')->where('hidden', '!=', 1)->orderBy('id', 'DESC')->get();
        } else {
            $artist = new Artist;
            $artist->id = null;
            $artist->alias = "Global Features (not artist specific)";
            $artworks_from_artist = null;

            $artworks_mags = Artwork::
                join('object_importance', 'object_importance.object_id', '=', 'artworks.id')
                ->where('object_importance.object_type', '=', 'w') // get only artworks
                ->select('*', 'object_importance.id as object_importance_id', 'artworks.id as id')
                ->orderBy('magnitude', 'ASC')
                ->get();
        }

        return View::make('gemini.magnitude')
            ->with('artworks', $artworks_mags)
            ->with('artworks_from_artist', $artworks_from_artist)
            ->with('artists', $artists)
            ->with('artist', $artist)
            ->with('page_title', "Magnitudes");

    }

    public function splashes()
    {
        $input = Input::all();

        $artists = DB::table('artists')->orderBy('alias', 'desc')->lists('alias','id');

        if (isset($input['artist_id'])) {
            $artist = Artist::find($input['artist_id']);
            $splashes_from_artist = Splash::where('location_slug', '=', $artist->slug)->orderBy('location_slug', 'ASC')->orderBy('position', 'ASC')->get();
            $splashes_not_from_artist = Splash::where('location_slug', '!=', $artist->slug)->orderBy('location_slug', 'ASC')->orderBy('position', 'ASC')->get();
        } else {
            $artist = new Artist;
            $artist->id = null;
            $artist->alias = "Homepage!";
            $artist->slug = 'home';
            $splashes_from_artist = Splash::where('location_slug', '=', 'home')->orderBy('location_slug', 'ASC')->orderBy('position', 'ASC')->get();
            $splashes_not_from_artist = Splash::where('location_slug', '!=', 'home')->orderBy('location_slug', 'ASC')->orderBy('position', 'ASC')->get();
        }

        return View::make('gemini.splashes',
        ['artists' => $artists,
        'artist' => $artist,
        'splashes_not_from_artist' => $splashes_not_from_artist,
        'splashes_from_artist' => $splashes_from_artist
        ]);
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
	public function show($id)
	{
		//
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
