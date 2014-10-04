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
        $get_vars = '';

        $masters[1] = ['chagall','miro','picasso','braque'];
        $masters[3] = ['agam','arman','calder','chia','close','francis','haring','lichtenstein','nierman','noland','stella','vasarely','warhol','young', 'yvaral'];
        $masters[4] = ['appel','archipenko','cocteau','dechirico','fantinlatour','hundertwasser','johns','kollwiz','leger','magritte','manray','mtisse','minne','moore','rouault','villon','vlaminck'];
        $masters[5] = ['callot','castiglione','durer','rembrandt','schongauer','vandyck'];
        $masters[6] = ['cassatt','monet','renoir','rodin','toulouse'];

        if ( $artist_url_slug !=  null ) {
            // one artist with artworks
            $artist = Artist::whereUrlSlug($artist_url_slug)->first();
            $artworks_size = sizeof(Artwork::whereArtistId($artist->id)->whereSold(0)->whereHidden(0)->get());
            $artworks = Artwork::whereArtistId($artist->id)->whereSold(0)->whereHidden(0)->orderBy('id', 'DESC')->skip($skip)->take(PAGINATION_NUM)->get();
            $artists = null;


            if ( in_array($artist->slug, $masters[1])) {
                $chapter = 1;

            } else if ( in_array($artist->slug, $masters[3])) {
                $chapter = 3;

            } else if ( in_array($artist->slug, $masters[4])) {
                $chapter = 4;

            } else if ( in_array($artist->slug, $masters[5])) {
                $chapter = 5;

            } else if ( in_array($artist->slug, $masters[6])) {
                $chapter = 6;

            } else {
                exit();
            }

            $get_vars = '?chapter=' .$chapter;

        } else {
            // no artist, so list all artists but no artworks
            $artist = null;
            $artist_url_slug = 0;
            $artworks_size = 0;
            $artworks = null;

            switch ((int)Input::get('chapter')) {
                case 1:
                    // featured
                    $chapter = 1;
                    $get_vars = '?chapter=1';
                    $artists_filter = "slug in ('" . implode('\',\'', $masters[$chapter]) . "')";
                    break;

                case 3:
                    // contemporary
                    $chapter = 3;
                    $get_vars = '?chapter=3';
                    $artists_filter = "slug in ('" . implode('\',\'', $masters[$chapter]) . "')";
                    break;

                case 4:
                    // modern
                    $chapter = 4;
                    $get_vars = '?chapter=4';
                    $artists_filter = "slug in ('" . implode('\',\'', $masters[$chapter]) . "')";
                    break;

                case 5:
                    // old
                    $chapter = 5;
                    $get_vars = '?chapter=5';
                    $artists_filter = "slug in ('" . implode('\',\'', $masters[$chapter]) . "')";
                    break;

                case 6:
                    // impressionist
                    $chapter = 6;
                    $get_vars = '?chapter=6';
                    $artists_filter = "slug in ('" . implode('\',\'', $masters[$chapter]) . "')";
                    break;

                default:
                    $chapter = 2;
                    $artists_filter = "slug not in ('chagall','miro','picasso','braque')";
                    break;
            }

            $artists = Artist::
                whereRaw('id !=0')
                ->whereIn('id', function($query)
                {
                    $query->select('artist_id')
                        ->from('artworks')
                        ->whereRaw('sold = 0 and hidden = 0');
                })->whereRaw($artists_filter)->orderBy('last_name', 'asc')->get();

        }


        return View::make('flipboard.index')
            ->with('chapter', $chapter)
            ->with('get_vars', $get_vars)
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
