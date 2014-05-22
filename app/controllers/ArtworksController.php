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
        $artists = DB::table('artists')->orderBy('alias', 'desc')->lists('alias','id');

        return View::make('artworks.create')
            ->with('artists', $artists);
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

        if ( ! $this->artwork->fill($input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->artwork->errors);
        }

        Artwork::create($input);

        // redirect
        Session::flash('message', 'Successfully created artwork!');
        return Redirect::to('artworks');

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
        $artwork->img_urls = $this->fetch_images($artwork);
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

        $input = Input::except('img_main');

        if ( ! $this->artwork->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->artwork->errors);
        }

        $this->update_image($artwork);

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


    public function img_url($artwork, $img_main)
    {
        $extension = strtolower($img_main->getClientOriginalExtension());
        return $this->img_directory_url($artwork) . '/' . $artwork->artist->slug . $artwork->id . '.' . $extension;
    }


    public function img_directory_url($artwork)
    {
        return 'img/artists/' . $artwork->artist->url_slug . '/' . $artwork->id;
    }


    public function update_image($artwork)
    {
        $artwork_dir = $this->img_directory_url($artwork);

        // should be an easier way to create if not exists, or at least put in function
        if ( ! File::isDirectory($artwork_dir)) {
            $result = File::makeDirectory($artwork_dir, 0757, true);
        }

        $img_main = Input::file('img_main');

        if ($img_main != null) {
            $image['main'] = Image::make($img_main->getRealPath())->resize(ARTWORK_MAX_WIDTH, null, true, false)->resize(null, ARTWORK_MAX_HEIGHT, true, false)->save($this->img_url($artwork, $img_main));
        }

    }


    public function fetch_images($artwork)
    {
        $list_of_user_files = scandir($this->img_directory_url($artwork));

        $artwork_images = array();

        foreach ($list_of_user_files as $file) {
            $pos = strpos($file, $artwork->artist->slug);

            if ($pos !== false) {
                $artwork_images[] = $this->img_directory_url($artwork) . '/' . $file;
            }
        }

        return $artwork_images;

    }


}
