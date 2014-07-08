@if (sizeof($pages) > 0)
    <h2><span class="fa fa-file-text"></span> Featured In-Depth Articles</h2>

    @foreach ($pages as $key => $post)
        <div>
            @if ($key == 0)
                <h3 class="featured"><a href="/articles/{{ $post->post_name }}">{{ $post->post_title }}</a></h3>
            @else
                <h3><a href="/articles/{{ $post->post_name }}">{{ $post->post_title }}</a></h3>
            @endif
        </div>
    @endforeach

    <div>
        <a href="/articles">Read more In-Depth Articles</a>
    </div>

@endif
