<h1>{{ $artist->first_name }} {{ $artist->last_name }} ({{ $artist->year_begin }} - {{ $artist->year_end }})</h1>

{{ HTML::image($artist->img_url()) }}

@foreach ($biographies as $bio)
<div>
    <h2>{{ $bio->post_title }}</h2>
    {{ apply_filters('the_content',$bio->post_content); }}
</div>
@endforeach

<div>
    <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }}</a>
</div>