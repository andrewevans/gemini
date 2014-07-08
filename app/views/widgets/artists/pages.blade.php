@if (sizeof($posts) > 0)
    <h2><span class="fa fa-file-text"></span> In-Depth with {{ $artist->alias }}</h2>

    @foreach ($posts as $key => $post)
        <div>
            @if ($key == 0)
                <h3 class="featured"><a href="/artists/{{ $artist->url_slug }}/bio/{{ $post->post_name }}">{{ $post->post_title }}</a></h3>
            @else
                <h3><a href="/artists/{{ $artist->url_slug }}/bio/{{ $post->post_name }}">{{ $post->post_title }}</a></h3>
            @endif
        </div>
    @endforeach

    <div>
        <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }}</a>
    </div>
@endif
