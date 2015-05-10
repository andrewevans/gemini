<?php

class HomeController extends BaseController {

    protected $posts;

    public function __construct(Artwork $artwork, Artist $artist, Page $page)
    {
        $this->artwork = $artwork;
        $this->artist = $artist;
        $this->pages =  $this->getPages();
        $this->posts = $this->getPosts();
    }

    public function index()
    {

        if (Auth::check())
        {
            $artworks_mags_showcaser = Artwork::leftJoin('object_importance', 'object_importance.object_id', '=', 'artworks.id')
                ->where('object_importance.object_type', '=', 'w-home') // get only artworks for homepage
                ->where('sold', '=', '0')->where('hidden', '!=', 1) // only show available artworks
                ->select('*', 'artworks.id as id') // use artworks ID
                ->orderBy('magnitude', 'ASC') // order by magnitude, where lower is best, like 1 is 1st to show
                ->get();

            $artworks = $this->artwork->where('artist_id', '!=', 0)->whereSold(0)->whereHidden(0)->take(7)->orderBy('id', 'desc')->get();

            $artworks = $artworks_mags_showcaser->merge($artworks);

            $artists_mags_showcaser = Artist::leftJoin('object_importance', 'object_importance.object_id', '=', 'artists.id')
                ->where('object_importance.object_type', '=', 'a-home') // get only artworks for homepage
                ->select('*', 'artists.id as id') // use artworks ID
                ->orderBy('magnitude', 'ASC') // order by magnitude, where lower is best, like 1 is 1st to show
                ->get();


            $artists = $this->artist->whereIn('id', array(23, 44))->orderBy('id', 'desc')->get();

            $artists = $artists_mags_showcaser->merge($artists);

            $artworks_previous = Tools::artworks_previous();
            $artists_previous = Tools::artists_previous();

            // The user is logged in...
            return View::make('home.index')
                ->with('artworks', $artworks)
                ->with('artists', $artists)
                ->with('artists_featured', $artists_mags_showcaser)
                ->with('artworks_previous', $artworks_previous)
                ->with('artists_previous', $artists_previous)
                ->with('pages', $this->pages)
                ->with('posts', $this->posts)
                ->with('page_title', "Original Lithographs, Drawings, Etchings, Sculptures, Prints, Masterworks Fine Art Gallery");
        }
        return Redirect::to('login');
    }

    public function getIndex()
    {

        if (Auth::check())
        {
            $artworks = $this->artwork->whereIn('artist_id', array(23, 44, 36, 41))->whereSold(0)->whereHidden(0)->take(55)->orderBy('price', 'desc')->get();
            $artists = $this->artist->whereIn('id', array(23, 44, 36, 41))->orderBy('id', 'desc')->get();

            // The user is logged in...
            return View::make('home.index')
                ->with('artworks', $artworks)
                ->with('artists', $artists)
                ->with('pages', $this->pages)
                ->with('posts', $this->posts)
                ->with('page_title', "Original Lithographs, Drawings, Etchings, Sculptures, Prints, Masterworks Fine Art Gallery");
        }
        return Redirect::to('login');
    }

    public function postIndex()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        if (Auth::attempt(['username' => $username, 'password' => $password]))
        {
            return Redirect::intended('/');
        }

        return Redirect::back()
            ->withInput()
            ->withErrors('That username/password combo does not exist.');
    }

    public function getLogin()
    {
        return View::make('home.login', ['page_title' => "Log in."]);
    }

    public function getLogout()
    {
        Auth::logout();

        return Redirect::to('/');
    }

    public function getPages()
    {
        $args = array(
            'sort_order' => 'ASC',
            'sort_column' => 'post_date',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => 0,
            'exclude_tree' => '',
            'number' => 3,
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );

        $posts = get_pages($args);

        return $posts;
    }

    public function getPosts()
    {
        $args = array(
            'posts_per_page'   => 3,
            'post_type'        => 'post',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'suppress_filters' => true );

        $posts = get_posts( $args );

        return $posts;
    }

}