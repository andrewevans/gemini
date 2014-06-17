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

		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
