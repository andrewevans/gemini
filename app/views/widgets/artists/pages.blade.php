@if (sizeof($posts) > 0)
    <h2><span class="fa fa-file-text"></span> In-Depth with {{ $artist->alias }}</h2>

    @foreach ($posts as $key => $post)
        <ul>
            @if ($key == 0)
                <li class="featured"><a href="/artists/{{ $artist->url_slug }}/bio/{{ $post->post_name }}">{{ $post->post_title }}</a></li>
            @else
                <li><a href="/artists/{{ $artist->url_slug }}/bio/{{ $post->post_name }}">{{ $post->post_title }}</a></li>
            @endif
        </ul>
    @endforeach

    <div class="read-more">
        <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }} &thinsp;&raquo;</a>
    </div>
@endif
