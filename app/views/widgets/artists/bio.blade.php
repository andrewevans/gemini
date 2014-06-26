<h1>{{ $artist->first_name }} {{ $artist->last_name }}</h1>
    @if (file_exists($artist->img_url))
    {{ HTML::image($artist->img_url, 'Profile of ' . $artist->alias) }}<br />
    @else
    {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artist->alias) }}<br />
    @endif

    {{ $artist->meta_description }}

<div>
    <a href="/artists/{{ $artist->url_slug }}/bio">Read more about {{ $artist->alias }}</a>
</div>