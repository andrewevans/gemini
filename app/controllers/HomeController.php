<?php

class HomeController extends BaseController {

    public function __construct(Artwork $artwork, Artist $artist)
    {
        $this->artwork = $artwork;
        $this->artist = $artist;
    }

    public function getIndex()
    {
        $artworks = $this->artwork->whereIn('artist_id', array(23, 44, 36, 41))->whereSold(0)->whereHidden(0)->take(20)->orderBy('artist_id', 'desc')->orderBy('id', 'desc')->get();
        $artists = $this->artist->whereIn('id', array(23, 44, 36, 41))->orderBy('id', 'desc')->get();

        $query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 2,
            'order' => 'ASC',
            'orderby' => 'post_title',
        ));

        $posts = $query->get_posts();

        if (Auth::check())
        {
            // The user is logged in...
            return View::make('home.index')
                ->with('artworks', $artworks)
                ->with('artists', $artists)
                ->with('posts', $posts);
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
        return View::make('home.login');
    }

    public function getLogout()
    {
        Auth::logout();

        return Redirect::to('/');
    }

}