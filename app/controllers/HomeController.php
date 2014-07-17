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
            $artworks = $this->artwork->whereIn('artist_id', array(23, 44))->whereSold(0)->whereHidden(0)->take(15)->orderBy('price', 'desc')->get();
            $artists = $this->artist->whereIn('id', array(23, 44))->orderBy('id', 'desc')->get();

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
            'number' => 5,
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
            'posts_per_page'   => 5,
            'post_type'        => 'post',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'suppress_filters' => true );

        $posts = get_posts( $args );

        return $posts;
    }

}