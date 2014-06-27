<h1>{{ $artist->first_name }} {{ $artist->last_name }}</h1>
{{ HTML::image($artist->img_url()) }}

<p>{{ $artist->meta_description }}</p>

<div>
    <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }}</a>
</div>