@if (sizeof($posts) > 0)
    <h2>In-Depth Articles</h2>

    @foreach ($posts as $post)
    <div>
        <h2><a href="/articles/{{ $post->post_name }}">{{ $post->post_title }}</a></h2>
    </div>
    @endforeach

@endif
