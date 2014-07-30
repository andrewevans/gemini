@if (sizeof($posts) > 0)

@foreach ($pages as $key => $post)
<div class="col-md-4 post">
    <div class="post-img">
        <a href="/articles/{{ $post->post_name }}">
            <img src="{{ wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' )[0] }}" />
        </a>
    </div>
    <h4><a href="/articles/{{ $post->post_name }}">{{ $post->post_title }}</a></h4>
</div>
@endforeach

@endif
