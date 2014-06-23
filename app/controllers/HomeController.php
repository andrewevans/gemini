<?php

class HomeController extends BaseController {

    public function __construct(Artwork $artwork, Artist $artist)
    {
        $this->artwork = $artwork;
        $this->artist = $artist;
    }

    public function getIndex()
    {

        if (Auth::check())
        {
            $artworks = $this->artwork->whereIn('artist_id', array(23, 44, 36, 41))->whereSold(0)->whereHidden(0)->take(20)->orderBy('artist_id', 'desc')->orderBy('id', 'desc')->get();
            $artists = $this->artist->whereIn('id', array(23, 44, 36, 41))->orderBy('id', 'desc')->get();

            // The user is logged in...
            return View::make('home.index')
                ->with('artworks', $artworks)
                ->with('artists', $artists)
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

}