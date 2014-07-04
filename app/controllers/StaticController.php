<?php

class StaticController extends \BaseController {

	/**
	 * Display the specified resource.
	 *
	 * @param  nothing
	 * @return Response
	 */
	public function show()
    {
        $post = get_page_by_path(Request::server('REQUEST_URI'));

        if ($post == null) App::abort(404);

        return View::make('widgets.page', ['post' => $post]);
    }

}
