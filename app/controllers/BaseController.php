<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
        View::share('page_title', SITE_NAME);

        if (Input::get('list')) {
            Session::put('list', $_GET['list']);
        } else {
            if (! Session::has('list')) Session::put('list', 'card');
        }

        Session::put('sortBy', Filterby::sort(Input::get('sort', 'featured')));

        Session::put('sortList', Filterby::sortList());

        if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
