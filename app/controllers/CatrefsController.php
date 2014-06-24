<?php

class CatrefsController extends \BaseController {

    protected $catref;
    protected $catalogue;

    public function __construct(Catref $catref, Catalogue $catalogue)
    {
        $this->catref = $catref;
        $this->catalogue = $catalogue;
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

        return View::make('catrefs.index', ['catrefs' => $catrefs, 'page_title' => "All the Catrefs"]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $catalogues = DB::table('catalogues')->orderBy('title', 'asc')->lists('title','id');
        $catref_newest = Catref::orderBy('id', 'desc')->first();

        //
        return View::make('catrefs.create', ['catalogues' => $catalogues, 'catref_newest' => $catref_newest, 'page_title' => 'Create Catref']);
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
    public function show($artist_url_slug = null, $catalogue_url_slug = null, $catref_url_slug = null, $id = null)
    {
        //
        // attempt to find catalogue url slug in first param
        if('artists.catrefs.show' != Route::current()->getName()) {
            $id = $artist_url_slug;
        }
        //
        $catref = Catref::find($id);
        $artworks = $catref->catalogue->artist->artworks()->where('hidden', '!=', 1)->take(50)->orderBy('id', 'desc')->get();

//        $catref->img_url = $this->img_url($catref); // should be stored in catrefs model

        return View::make('catrefs.show', ['catref' => $catref, 'artworks' => $artworks, 'page_title' => $catref->title() . ", " . $catref->catalogue->artist->alias . ", from " . $catref->catalogue->title]);

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

        $catalogues = DB::table('catalogues')->orderBy('title', 'desc')->lists('title','id');

        // show the edit form and pass the catref
        return View::make('catrefs.edit')
            ->with('catref', $catref)
            ->with('catalogues', $catalogues)
            ->with('page_title', "Edit: " . $catref->title());
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
        $input = Tools::array_strip_tags($input);

        $catref = Catref::whereId($id)->first();

        if ( ! $this->catref->fill($input)->isValid($id))
        {
            return Redirect::back()->withInput()->withErrors($this->catref->errors);
        }

        // store
        $catref->catalogue_id       = Input::get('catalogue_id');
        $catref->reference_num      = Input::get('reference_num');
        $catref->title      = $input['title'];
        $catref->title_ext      = Input::get('title_ext');
        $catref->size      = Input::get('size');
        $catref->signed      = Input::get('signed');
        $catref->edition      = Input::get('edition');
        $catref->medium      = Input::get('medium');
        $catref->therest      = Input::get('therest');

        $catref_dir = $this->img_directory_url($catref);

        // should be an easier way to create if not exists, or at least put in function
        if ( ! File::isDirectory($catref_dir)) {
            $result = File::makeDirectory($catref_dir, 0757, true);
        }

        $avatar = Input::file('catref_img');

        // resizing an uploaded file
        if ($avatar != null) {
            $mime_type = $avatar->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make(Input::file('catref_img')->getRealPath())->resize(CATREF_MAX_WIDTH, null, true, false)->resize(null, CATREF_MAX_HEIGHT, true, false)->save($this->img_url($catref));
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

    public function img_url($catref)
    {
        return $this->img_directory_url($catref) . '/' . $catref->catalogue->slug . $catref->id . '.jpg';
    }


    public function img_directory_url($catref)
    {
        return 'img/catalogues/' . $catref->catalogue->artist->slug . '/' . $catref->catalogue->slug;
    }


}
