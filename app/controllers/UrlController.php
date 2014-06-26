<?php

class UrlController extends \BaseController {

    protected $artist;
    protected $artwork;
    protected $catalogue;
    protected $catref;

    public function __construct(Artist $artist, Artwork $artwork, Catalogue $catalogue, Catref $catref)
    {
        $this->artist = $artist;
        $this->artwork = $artwork;
        $this->catalogue = $catalogue;
        $this->catref =$catref;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
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
        $term = Str::lower(Input::get('term'));
        $return_array = array();

        switch ($data) {
            case 'artists':
                $artists = $this->artist->orderBy('last_name', 'asc')->get();

                foreach ($artists as $artist) {
                    $return_array[] = array(
                        'value' => $artist->alias,
                        'year_begin' => $artist->year_begin,
                        'year_end' => $artist->year_end,
                        'guid' => 'a-' . $artist->id,
                        'id' => $artist->id);
                }
                break;

            case 'artworks':
                $artworks = $this->artwork->whereSold(0)->whereHidden(0)->orderBy('id', 'DESC')->get();

                foreach ($artworks as $artwork) {
                    $return_array[] = array(
                        'value' => $artwork->title_short,
                        'medium_short' => $artwork->medium_short,
                        'guid' => 'w-' . $artwork->id,
                        'id' => $artwork->id);
                }
                break;

            case 'catalogues':
                $catalogues = $this->catalogue->orderBy('id', 'DESC')->get();

                foreach ($catalogues as $catalogue) {
                    $return_array[] = array(
                        'value' => $catalogue->title,
                        'url_slug' => $catalogue->url_slug,
                        'artist_id' => $catalogue->artist_id,
                        'guid' => 'c-' . $catalogue->id,
                        'id' => $catalogue->id);
                }
                break;

            case 'catrefs':
                $catrefs = $this->catref->orderBy('id', 'DESC')->get();

                foreach ($catrefs as $catref) {
                    $return_array[] = array(
                        'value' => $catref->title,
                        'size' => $catref->size,
                        'signed' => $catref->signed,
                        'edition' => $catref->edition,
                        'medium' => $catref->medium,
                        'therest' => $catref->therest,
                        'reference_num' => $catref->reference_num,
                        'catalogue_id' => $catref->catalogue_id,
                        'guid' => 'r-' . $catref->id,
                        'id' => $catref->id);
                }
                break;

            default:
                return Response::json(array(), 404);
                break;
        }

        return Response::json($return_array, 200);
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
