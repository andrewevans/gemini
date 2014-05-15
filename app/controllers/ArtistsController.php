<?php

class ArtistsController extends \BaseController {

    protected $artist;

    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
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
            return View::make('artists.show', ['artist' => $artist]);
        }

        // get the artist
        $artist = Artist::find($data);

        Session::flash('message', 'You were forwarded here from ' . '<b>artists/' . $data . '</b>');
        return Redirect::to('artists/' . $artist->url_slug);

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
        $artist->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the artist!');
        return Redirect::to('artists');
	}


}
