@if (sizeof($posts) > 0)
    <h2>In-Depth with {{ $artist->alias }}</h2>

    @foreach ($posts as $post)
    <div>
        <h2><a href="/artists/{{ $artist->url_slug }}/bio/{{ $post->post_name }}">{{ $post->post_title }}</a></h2>
    </div>
    @endforeach

    <div>
        <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }}</a>
    </div>
@endif
