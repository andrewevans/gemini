<?php

class UrlController extends \BaseController {

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
