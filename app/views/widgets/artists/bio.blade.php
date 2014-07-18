<h2>{{ $artist->first_name }} {{ $artist->last_name }} ({{ $artist->year_begin }} - {{ $artist->year_end }})</h2>

{{ HTML::image($artist->img_url()) }}

@foreach ($biographies as $bio)
<div>
    <h3>{{ $bio->post_title }}</h3>
    {{ apply_filters('the_content',$bio->post_content); }}
</div>
@endforeach

<div class="read-more">
    <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }} &thinsp;&raquo;</a>
</div>