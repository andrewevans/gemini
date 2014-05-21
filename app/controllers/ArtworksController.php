<?php

class ArtworksController extends \BaseController {

    protected $artwork;

    public function __construct(Artwork $artwork)
    {
        $this->artwork = $artwork;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $artworks = $this->artwork->orderBy('artist_id', 'desc')->get();

        // load the view and pass the artworks
        return View::make('artworks.index')
            ->with('artworks', $artworks);
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
        $artwork = Artwork::find($data);
        return View::make('artworks.show', ['artwork' => $artwork]);

        Session::flash('message', 'You were forwarded here from ' . '<b>artworks/' . $data . '</b>');
        return Redirect::to('artworks/' . $artwork->url_slug);

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
        $artwork = Artwork::find($id);
        $artists = DB::table('artists')->orderBy('alias', 'desc')->lists('alias','id');

        // show the edit form and pass the artwork
        return View::make('artworks.edit')
            ->with('artwork', $artwork)
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
        $artwork = Artwork::whereId($id)->first();

        $input = Input::all();

        if ( ! $this->artwork->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->artwork->errors);
        }

        $artwork->update($input);

        // redirect
        Session::flash('message', 'Successfully updated artwork!');
        return Redirect::to('artworks');

    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $artwork = Artwork::find($id);

        $artwork->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the artwork!');
        return Redirect::to('artworks');

    }


}
