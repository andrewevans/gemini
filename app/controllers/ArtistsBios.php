<?php

class ArtistsBiosController extends \BaseController {

    protected $artists;
    protected $arists_bios;

    public function __construct(Artist $artist, ArtistBio $artist_bio)
    {
        $this->artist = $artist;
        $this->artist_bio = $artist_bio;
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
        //
        $input = Input::all();

        if ( ! $this->project->fill($input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->project->errors);
        }

        // store
        $project = new Project;
        $project->name       = trim(strip_tags(Input::get('name')));
        $project->cost      = Input::get('cost');
        $project->save();

        // redirect
        Session::flash('message', 'Successfully created PROJECT!');
        return Redirect::to('projects');

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
