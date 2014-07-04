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

        $breadcrumb = $this->breadcrumb($post);

        return View::make('widgets.page', ['breadcrumb' => $breadcrumb, 'post' => $post]);
    }

    public function breadcrumb($post)
    {
        $breadcrumb[] = '<li class="active">' . $post->post_title . '</li>';

        while ($this->the_parent($post)) {
            $post = $this->the_parent($post);
            $breadcrumb[] = '<li><a href="' . str_replace(get_site_url() , '', get_permalink($post->ID)) . '">' . $post->post_title . '</a></li>';
        }

        return implode(' ', array_reverse($breadcrumb));
    }

    public function the_parent($post) {
        if($post->post_parent == 0) return false;
        $post_data = get_post($post->post_parent);
        return $post_data;
    }

}
