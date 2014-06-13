@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

<div class="container">
    <p style="color: #fff; font-size:2em">Results for "<b>{{ $q }}</b>" found {{ sizeof($artworks) }} artworks from {{ sizeof($artists) }} artists.</p>
    <h2>Artworks</h2>
    @foreach ($artworks as $artwork)
    <div class="col-md-4">
        <a href="{{ $artwork->url() }}">
            @if (file_exists('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg'))
            {{ HTML::image('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg') }}<br />
            @else
            {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artwork->artist->alias) }}<br />
            @endif
        </a>
        {{ $artwork->title_short }}

        <b>{{ strip_tags($artwork->artist->alias . ' ' . $artwork->medium_short) }} for sale.</b>
        <i>{{ strip_tags($artwork->title_short()) }}</i><br />
        ${{ number_format($artwork->price) }}


    </div>
    @endforeach
</div>


<h2>Artists</h2>
@foreach ($artists as $artist)
<div class="jumbotron text-center">
    @include('widgets.artists.bio', array('artist' => $artist))
</div>
@endforeach

<h2>In-Depth Articles</h2>
<div class="jumbotron text-center">
    @include('widgets.search.pages', array('pages' => $pages))
</div>

<h2>Blog Posts</h2>
<div class="jumbotron text-center">
    @include('widgets.search.posts', array('posts' => $posts))
</div>


@stop