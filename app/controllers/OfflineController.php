<?php

class OfflineController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if (null !==Input::get('artist_id')) {
            $artist_id_query = "id = " . Str::lower(Input::get('artist_id'));
        } else {
            $artist_id_query = "id != 0";
        }

        $artworks = Artwork::whereIn('artist_id', function($query) use ($artist_id_query)
            {
                $query->select('id')
                    ->from('artists')
                    ->whereRaw($artist_id_query);
            })->whereSold(0)->whereHidden(0)->orderBy('id', 'DESC')->get();

        return View::make('offline.index')
            ->with('artworks', $artworks)
            ->with('artist_id_query', $artist_id_query)
            ->with('page_title', "Offline app");
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
