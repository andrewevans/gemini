<?php

class SplashesController extends \BaseController {

    protected $splash;

    public function __construct(Splash $splash)
    {
        $this->splash = $splash;
        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
        $input = Input::all();

        if ( ! $this->splash->fill($input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->splash->errors);
        }

        $splash = new Splash;
        $splash->position = 0;
        $splash->location_slug = '';
        $splash->destination_url = $input['destination_url'];
        $splash->asset_url = $input['asset_url'];
        $splash->title = $input['title'];
        $splash->save();

        Session::flash('message', 'Splash created!.');
        return Redirect::to('/gemini/splashes');
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
        $input = Input::all();

        if (! isset($input['piece'])) return Redirect::to('/gemini/splashes');

        $pieces = array_values($input['piece']);

        foreach ($pieces as $key => $piece) {

            $splash = Splash::find($piece['id']);

            $splash->position = $key+1;
            $splash->location_slug = $input['artist_slug'];
            $splash->save();
        }

        Session::flash('message', 'Splashes reordered.');
        return Redirect::to('/gemini/splashes');
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
