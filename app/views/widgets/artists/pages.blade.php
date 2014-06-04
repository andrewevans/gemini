<h2>In-Depth with {{ $artist->alias }}</h2>

@foreach ($posts as $post)
<div>
    <h2><a href="/artists/{{ $artist->url_slug }}/bio/{{ $post->post_name }}">({{ $post->post_type }}) ({{ $post->ID }}) {{ $post->post_title }}</a></h2>
</div>
@endforeach