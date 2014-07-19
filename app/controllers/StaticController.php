<?php

class StaticController extends \BaseController {


    public function __construct()
    {
        $this->beforeFilter('auth');
    }

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

    public function showArticle( $wp_url_slug = null)
    {
        if ( $wp_url_slug != null ) {
            $args = array(
                'name'         => $wp_url_slug,
                'post_type'        => 'page',
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_status'      => 'publish',
                'suppress_filters' => true );

            $post = current( get_posts( $args ) );

            $breadcrumb = $this->breadcrumb($post);

            return View::make('articles.show', ['breadcrumb' => $breadcrumb, 'post' => $post]);
        }

        $args_cat = array(
            'type'                     => 'page',
            'child_of'                 => 0,
            'parent'                   => '',
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'exclude'                  => '',
            'include'                  => '',
            'number'                   => '',
            'taxonomy'                 => 'category',
            'pad_counts'               => false
        );

        $categories = get_categories($args_cat);

        foreach ($categories as $category) {
            $args = array(
                'category_name'    => $category->slug,
                'post_type'        => 'page',
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_status'      => 'publish',
                'suppress_filters' => true );

            $posts = get_posts( $args );

            if ($posts != null) {
                    $posts_by_category[$category->slug] = $posts;
                    $categories_name[$category->slug] = $category->name;
            }
        }

        return View::make('articles.index', ['posts_by_category' => $posts_by_category, 'categories_name' => $categories_name]);
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
