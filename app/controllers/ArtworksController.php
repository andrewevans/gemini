<?php

class ArtworksController extends \BaseController {

    protected $artwork;

    public function __construct(Artwork $artwork)
    {
        $this->artwork = $artwork;
        $this->beforeFilter('auth');
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
        $artists = DB::table('artists')->orderBy('alias', 'asc')->lists('alias','id');
        $artwork_newest = Artwork::orderBy('id', 'desc')->first();

        return View::make('artworks.create')
            ->with('artists', $artists)
            ->with('artwork_newest', $artwork_newest);
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
        $artwork->img_urls = $this->fetch_images($artwork);

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

        $input = Input::except('img_main', 'img[1]');

        if ( ! $this->artwork->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->artwork->errors);
        }

        $this->update_images($artwork);

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


    public function img_url($artwork, $img_main, $key = null)
    {
        $extension = strtolower($img_main->getClientOriginalExtension());

        if ($key == null)
            return $this->img_directory_url($artwork) . '/' . $artwork->artist->slug . $artwork->id . '.' . $extension;
        else
            return $this->img_directory_url($artwork) . '/' . $artwork->artist->slug . $artwork->id . '_' . $key . '.' . $extension;
    }


    public function img_directory_url($artwork)
    {
        return 'img/artists/' . $artwork->artist->url_slug . '/' . $artwork->id;
    }


    public function update_images($artwork)
    {
        $artwork_dir = $this->img_directory_url($artwork);

        // should be an easier way to create if not exists, or at least put in function
        if ( ! File::isDirectory($artwork_dir)) {
            $result = File::makeDirectory($artwork_dir, 0757, true);
        }

        $img_1 = Input::file('img_1');
        $img_2 = Input::file('img_2');
        $img_3 = Input::file('img_3');

        if ($img_1 != null) {
            $this->make_image($artwork, $img_1);
        }

        if ($img_2 != null) {
            $this->make_image($artwork, $img_2, 2);
        }

        if ($img_3 != null) {
            $this->make_image($artwork, $img_3, 3);
        }

    }

    public function make_image($artwork, $image, $key = null)
    {
        Image::make($image->getRealPath())->resize(ARTWORK_MAX_WIDTH, null, true, false)->resize(null, ARTWORK_MAX_HEIGHT, true, false)->save($this->img_url($artwork, $image, $key));
    }


    public function fetch_images($artwork)
    {
        $img_dir = $this->img_directory_url($artwork);

        if( ! is_dir($img_dir)) return false;

        $list_of_user_files = scandir($img_dir);

        $artwork_images = array();

        foreach ($list_of_user_files as $file) {
            $pos = strpos($file, $artwork->artist->slug);

            if ($pos !== false) {
                $artwork_images[] = $img_dir . '/' . $file;
            }
        }

        return $artwork_images;

    }


}
