<?php

class CataloguesController extends \BaseController {

    protected $catalogue;
    protected $artist;

    public function __construct(Catalogue $catalogue, Artist $artist)
    {
        $this->catalogue = $catalogue;
        $this->artist = $artist;
        //$this->beforeFilter('auth');
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($artist_url_slug = null)
	{
		//
        if ($artist_url_slug == null) {
            $catalogues = $this->catalogue->all();
        } else {
            $artist = Artist::whereUrlSlug($artist_url_slug)->first();
            $catalogues = $this->catalogue->whereArtistId($artist->id)->get();
        }

        return View::make('catalogues.index', ['catalogues' => $catalogues]);
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
        $artists = DB::table('artists')->orderBy('alias', 'asc')->lists('alias','id');
        $catalogue_newest = Catalogue::orderBy('id', 'desc')->first();

        return View::make('catalogues.create', ['artists' => $artists, 'catalogue_newest' => $catalogue_newest]);
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

        $catalogue = new Catalogue;

        if ( ! $this->catalogue->fill($input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->catalogue->errors);
        }

        $catalogue->artist_id   = Input::get('artist_id');
        $catalogue->slug       = Input::get('slug');
        $catalogue->title      = Input::get('title');
        $catalogue->url_slug      = Input::get('url_slug');
        $catalogue->meta_description      = Input::get('meta_description');

        $catalogue->save();

        Session::flash('message', 'Successfully updated catalogue!');
        return Redirect::to('catalogues');
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  string $data
	 * @return Response
	 */
    public function show($artist_url_slug = null, $catalogue_url_slug = null)
    {
		//
        // attempt to find catalogue url slug in first param
        if('artists.catalogues.show' != Route::current()->getName()) {
            $catalogue_url_slug = $artist_url_slug;
        }

        $catalogue = Catalogue::whereUrlSlug($catalogue_url_slug)->first();
        $catrefs = Catref::whereCatalogueId($catalogue->id)->get();

        $page_title = $catalogue->title();
//        $catalogue->img_url = $this->img_url($catalogue); // should be stored in catalogues model

        return View::make('catalogues.show', ['catalogue' => $catalogue, 'page_title' => $page_title, 'catrefs' => $catrefs]);

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
        $catalogue = Catalogue::find($id);
        $artists = DB::table('artists')->orderBy('alias', 'desc')->lists('alias','id');

        // show the edit form and pass the catalogue
        return View::make('catalogues.edit')
            ->with('catalogue', $catalogue)
            ->with('artists', $artists);
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

        $catalogue = Catalogue::whereId($id)->first();

        if ( ! $this->catalogue->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->catalogue->errors);
        }

        // store
        $catalogue->artist_id       = Input::get('artist_id');
        $catalogue->slug       = Input::get('slug');
        $catalogue->title      = Input::get('title');
        $catalogue->url_slug      = Input::get('url_slug');
        $catalogue->meta_description      = Input::get('meta_description');

        $catalogue_dir = 'img/catalogues/' . $catalogue->url_slug . '/profile';

        // should be an easier way to create if not exists, or at least put in function
        if ( ! File::isDirectory($catalogue_dir)) {
            $result = File::makeDirectory($catalogue_dir, 0757, true);
        }

        $avatar = Input::file('avatar');

        // resizing an uploaded file
        if ($avatar != null) {
            $mime_type = $avatar->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make(Input::file('avatar')->getRealPath())->resize(ARTIST_MAX_WIDTH, null, true, false)->resize(null, ARTIST_MAX_HEIGHT, true, false)->save($this->img_url($catalogue));
        }

        $catalogue->save();

        // redirect
        Session::flash('message', 'Successfully updated catalogue!');
        return Redirect::to('catalogues');

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
        $catalogue = Catalogue::find($id);

        /*
                $catalogue_dir = $this->img_directory_url($catalogue);

                if ($catalogue->url_slug != '') {
                    File::deleteDirectory($catalogue_dir, false);
                }
        */
        $catalogue->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the catalogue!');
        return Redirect::to('catalogues');

    }


}
