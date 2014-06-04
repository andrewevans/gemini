<h1>{{ $artist->first_name }} {{ $artist->last_name }}</h1>
<p>
    @if (file_exists($artist->img_url))
    {{ HTML::image($artist->img_url, 'Profile of ' . $artist->alias) }}<br />
    @else
    {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artist->alias) }}<br />
    @endif

    {{ $artist->meta_description }}
</p>
