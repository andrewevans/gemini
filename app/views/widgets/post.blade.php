    <div>
        <h3><a href="{{ get_permalink($post->ID) }}">{{ $post->post_title }}</a></h3>
        {{ apply_filters('the_excerpt',$post->post_excerpt); }} <a href="{{ get_permalink($post->ID) }}">Read more&hellip;</a>
    </div>
