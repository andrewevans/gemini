@if (sizeof($posts) > 0)
    <h2><span class="fa fa-rss"></span> Blog Posts with {{ $artist->alias }}</h2>

    @foreach ($posts as $key => $post)
        <ul>
            @if ($key == 0)
                <li class="featured"><a href="{{ get_permalink($post->ID) }}">{{ $post->post_title }}</a></li>
            @else
                <li><a href="{{ get_permalink($post->ID) }}">{{ $post->post_title }}</a></li>
            @endif
        </ul>
    @endforeach

    <div class="read-more">
        <a href="http://wp.{{ $_SERVER['HTTP_HOST'] }}">Up-to-date art news on our blog &thinsp;&raquo;</a>
    </div>
@endif