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

        if (isset ($_GET['list'])) {
            Session::put('list', $_GET['list']);
        } else {
            if (! Session::has('list')) Session::put('list', 'card');
        }

		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
