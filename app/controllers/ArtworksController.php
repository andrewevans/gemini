<?php

class ArtworksController extends \BaseController {

    protected $artwork;
    protected $artists_previous;
    protected $artworks_previous;
    protected $artwork_description;

    public function __construct(Artwork $artwork, ArtworkDescription $artwork_description)
    {
        $this->artwork = $artwork;
        $this->beforeFilter('auth');
        $this->artwork_description = $artwork_description;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id = null)
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
        return View::make('artworks.index', [
            'artworks' => $artworks,
            'page_title' => "All the Artworks"]);
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
            ->with('artwork_newest', $artwork_newest)
            ->with('page_title', "Create Artwork");
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
        return Redirect::to('/gemini/artworks');

    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($artist_url_slug = null, $artwork_url_slug = null, $id = null)
	{
        // if we only get the ID, then set it
        if (is_numeric($artist_url_slug)) $id = $artist_url_slug;

		//
        $artwork = Artwork::find_by_key($id);

        if ($artwork->hidden == 1) {
            Session::flash('message', 'You were forwarded here from item #' . $artwork->id . ' because it is currently not available.');
            return Redirect::to($artwork->artist->url());
        }

        $artwork->img_urls = $this->fetch_images($artwork);

        $artwork->artwork_description = ArtworkDescription::whereArtworkId($id)->first();

        if ($artwork->artwork_description != null) $artwork->artwork_description = $artwork->artwork_description->description;

        $artworks_related = $artwork->artworks_related();

        $container_height = 0;
        foreach ($artwork->img_urls as $img_url) {

            if ( strpos($img_url, 'http') === false) $img_url = public_path() . $img_url;

            $height = getimagesize($img_url)[1];

            if ($height > $container_height) $container_height = $height;
        }

        if (is_numeric($artist_url_slug)) {
            Session::flash('message', 'You were forwarded here from ' . '<b>artworks/' . $artist_url_slug . '</b>');
            return Redirect::to($artwork->url());
        }

        $this->artworks_previous = $artwork->artworks_previous();

        return View::make('artworks.show', ['artwork' => $artwork, 'artworks_related' => $artworks_related, 'artworks_previous' => $this->artworks_previous, 'container_height' => $container_height, 'page_title' => $artwork->page_title()]);


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

        $artwork_description = ArtworkDescription::whereArtworkId($id)->first();

        if ($artwork_description != null) {
            $artwork->artwork_description = $artwork_description->description;
        } else {
            $artwork->artwork_description = null;
        }

        $artists = DB::table('artists')->orderBy('alias', 'desc')->lists('alias','id');

        // show the edit form and pass the artwork
        return View::make('artworks.edit')
            ->with('artwork', $artwork)
            ->with('artists', $artists)
            ->with('page_title', "Edit: " . $artwork->artist->alias . " -> " . $artwork->title_short());

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

        $input_all = Input::all();

        $input = Input::except('img_main', 'img[1]', 'artwork_description');

        if ( ! $this->artwork->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->artwork->errors);
        }

        $this->update_images($artwork);

        $artwork_description = ArtworkDescription::firstOrCreate(array('artwork_id' => $id));
        $artwork_description->description = $input_all['artwork_description'];
        $artwork_description->save();

        $artwork->update($input);

        // redirect
        Session::flash('message', 'Successfully updated artwork!');
        return Redirect::to('/gemini/artworks');

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
        return Redirect::to('/gemini/artworks');

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
        return 'img/artists/' . $artwork->artist->slug . '/original';
        //return 'img/artists/' . $artwork->artist->url_slug . '/' . $artwork->id;
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

        $img_1 = Input::file('img_1_hardcount');
        $img_2 = Input::file('img_2_hardcount');
        $img_3 = Input::file('img_3_hardcount');

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
        $artwork_images = array();

        $artwork_images[] = $artwork->img_url();

        for ($img_count = 2; $artwork->img_url(null, $img_count) != '/img/no-image.jpg'; $img_count++) {
            $artwork_images[] = $artwork->img_url(null, $img_count);
        }

        return $artwork_images;
    }


}
