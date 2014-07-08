@if (sizeof($posts) > 0)
    <h2><span class="fa fa-rss"></span> Blog Posts with {{ $artist->alias }}</h2>

    @foreach ($posts as $key => $post)
        <div>
            @if ($key == 0)
                <h3 class="featured"><a href="{{ get_permalink($post->ID) }}">{{ $post->post_title }}</a></h3>
            @else
                <h3><a href="{{ get_permalink($post->ID) }}">{{ $post->post_title }}</a></h3>
            @endif
        </div>
    @endforeach

    <div>
        <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }}</a>
    </div>
@endif