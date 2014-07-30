@if (sizeof($posts) > 0)

    @foreach ($posts as $key => $post)
    <div class="col-md-4 post">
        <div class="post-img">
            <img src="{{ wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' )[0] }}" />
        </div>
        <h4><a href="{{ get_permalink($post->ID) }}">{{ $post->post_title }}</a></h4>
    </div>
    @endforeach

@endif
