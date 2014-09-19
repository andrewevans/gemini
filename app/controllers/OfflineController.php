<?php

class OfflineController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return 'This if Offline homepage';
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function artists($data)
    {
        $artist = Artist::whereUrlSlug($data)->first();

        $artworks = $artist->artworks()->whereSold(0)->whereHidden(0)->orderBy('id', 'DESC')->get();

        return View::make('offline.index')
            ->with('artworks', $artworks)
            ->with('manifest_artist_id', $artist->id)
            ->with('page_title', "Artist");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function artistsList()
    {
        $artists = Artist::
            whereRaw('id !=0')
            ->whereIn('id', function($query)
            {
                $query->select('artist_id')
                    ->from('artworks')
                    ->whereRaw('sold = 0 and hidden = 0');
            })->orderBy('id', 'asc')->get();

        return View::make('offline.artistList')
            ->with('artists', $artists)
            ->with('manifest_artist_id', 0)
            ->with('page_title', "Artist List");
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function artworks($artist_url_slug = null, $artwork_url_slug = null, $id = null)
    {
        $artwork = Artwork::find($id);

        return View::make('offline.artwork')
            ->with('artwork', $artwork)
            ->with('manifest_artist_id', $artwork->artist->id)
            ->with('page_title', "Artwork");
    }

    public function flipboard($artist_url_slug = null, $skip = 0)
    {
        $skip = (int)$skip;

        if ( $artist_url_slug !=  null ) {
            // one artist with artworks
            $artist = Artist::whereUrlSlug($artist_url_slug)->first();
            $artworks_size = sizeof(Artwork::whereArtistId($artist->id)->whereSold(0)->whereHidden(0)->get());
            $artworks = Artwork::whereArtistId($artist->id)->whereSold(0)->whereHidden(0)->orderBy('id', 'DESC')->skip($skip)->take(PAGINATION_NUM)->get();
            $artists = null;
        } else {
            // no artist, so list all artists but no artworks
            $artist = null;
            $artist_url_slug = 0;
            $artworks_size = 0;
            $artworks = null;

            $artists = Artist::
                whereRaw('id !=0')
                ->whereIn('id', function($query)
                {
                    $query->select('artist_id')
                        ->from('artworks')
                        ->whereRaw('sold = 0 and hidden = 0');
                })->orderBy('last_name', 'asc')->get();

        }


        return View::make('flipboard.index')
            ->with('artists', $artists)
            ->with('artist', $artist)
            ->with('artworks', $artworks)
            ->with('artist_url_slug', $artist_url_slug)
            ->with('artworks_size', $artworks_size)
            ->with('skip', $skip);
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


}
