<?php

class CatrefsController extends \BaseController {

    protected $catref;

    public function __construct(Catref $catref)
    {
        $this->catref = $catref;
        //$this->beforeFilter('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $catrefs = $this->catref->all();

        return View::make('catrefs.index', ['catrefs' => $catrefs]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return View::make('catrefs.create');
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

        $catref = new Catref;

        if ( ! $this->catref->fill($input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->catref->errors);
        }

        $catref->catalogue_id       = Input::get('catalogue_id');
        $catref->reference_num      = Input::get('reference_num');
        $catref->title      = Input::get('title');
        $catref->title_ext      = Input::get('title_ext');
        $catref->size      = Input::get('size');
        $catref->signed      = Input::get('signed');
        $catref->edition      = Input::get('edition');
        $catref->medium      = Input::get('medium');
        $catref->therest      = Input::get('therest');

        $catref->save();

        Session::flash('message', 'Successfully updated catref!');
        return Redirect::to('catrefs');
    }


    /**
     * Display the specified resource.
     *
     * @param  string $data
     * @return Response
     */
    public function show($artist_url_slug = null, $catalogue_url_slug = null, $id = null)
    {
        //
        // attempt to find catalogue url slug in first param
        if('artists.catrefs.show' != Route::current()->getName()) {
            $id = $artist_url_slug;
        }
        //
        $catref = Catref::find($id);

        $page_title = $catref->title();
//        $catref->img_url = $this->img_url($catref); // should be stored in catrefs model

        return View::make('catrefs.show', ['catref' => $catref, 'page_title' => $page_title]);

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
        $catref = Catref::find($id);

        // show the edit form and pass the catref
        return View::make('catrefs.edit')
            ->with('catref', $catref);
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
        $input = Input::all();

        $catref = Catref::whereId($id)->first();

        if ( ! $this->catref->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->catref->errors);
        }

        // store
        $catref->catalogue_id       = Input::get('catalogue_id');
        $catref->reference_num      = Input::get('reference_num');
        $catref->title      = Input::get('title');
        $catref->title_ext      = Input::get('title_ext');
        $catref->size      = Input::get('size');
        $catref->signed      = Input::get('signed');
        $catref->edition      = Input::get('edition');
        $catref->medium      = Input::get('medium');
        $catref->therest      = Input::get('therest');

        $catref_dir = 'img/catrefs/' . $catref->url_slug . '/profile';

        // should be an easier way to create if not exists, or at least put in function
        if ( ! File::isDirectory($catref_dir)) {
            $result = File::makeDirectory($catref_dir, 0757, true);
        }

        $avatar = Input::file('avatar');

        // resizing an uploaded file
        if ($avatar != null) {
            $mime_type = $avatar->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make(Input::file('avatar')->getRealPath())->resize(ARTIST_MAX_WIDTH, null, true, false)->resize(null, ARTIST_MAX_HEIGHT, true, false)->save($this->img_url($catref));
        }

        $catref->save();

        // redirect
        Session::flash('message', 'Successfully updated catref!');
        return Redirect::to('catrefs');

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
        $catref = Catref::find($id);

        /*
                $catref_dir = $this->img_directory_url($catref);

                if ($catref->url_slug != '') {
                    File::deleteDirectory($catref_dir, false);
                }
        */
        $catref->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the catref!');
        return Redirect::to('catrefs');

    }


}
