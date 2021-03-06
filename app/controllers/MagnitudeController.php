<?php

class MagnitudeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return 'mag index';
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

        $pieces = array_values($input['piece']);

        foreach ($pieces as $key => $piece) {
            $mag = Magnitude::find($piece['object_importance_id']);

            if ($mag == null) {
                $mag = new Magnitude;
                $mag->object_type = $piece['object_type'];
                $mag->object_id = $piece['artwork_id'];
            }

            $mag->magnitude = $key+1;
            $mag->save();
        }

        Session::flash('message', 'Magnitudes stored.');
        return Redirect::to('/gemini/magnitude');
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
