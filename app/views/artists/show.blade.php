@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

<h1>Showing {{ $artist->alias }}</h1>

<div class="jumbotron text-center">
    <h2>{{ $artist->first_name }} {{ $artist->last_name }}</h2>
    <p>
        <strong>slug:</strong> {{ $artist->slug }}<br />
        <strong>url_slug:</strong> {{ $artist->url_slug }}<br />
        @if (file_exists($artist->img_url))
            <strong>Avatar:</strong> {{ HTML::image($artist->img_url, 'Profile of ' . $artist->alias) }}<br />
        @else
            <strong>Avatar:</strong> {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artist->alias) }}<br />
        @endif

    </p>
</div>

@stop