<?php

class HomeController extends BaseController {

    protected $posts;

    public function __construct(Artwork $artwork, Artist $artist)
    {
        $this->artwork = $artwork;
        $this->artist = $artist;
        $this->posts = $this->getPosts();
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

    public function getPosts()
    {
        $args = array(
            'posts_per_page'   => 10,
            'post_type'        => 'post',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'suppress_filters' => true );

        $posts = get_posts( $args );

        return $posts;
    }

}