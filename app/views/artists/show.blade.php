@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

@if (! Config::get('app.gemini_lite'))
<div class="container" style="margin-top: 3em">
    <div class="row">
        @include('widgets.splashes_netty')
    </div>
</div>
@endif

<div class="container">
<div class="intro-header" style="text-align: center; max-width:450px;"> <i class="sprite-h gtitle-deco above"></i>
    <h1>{{ $page_title }}</h1>
    @if (! Config::get('app.gemini_lite'))
    <p>{{ $artist->meta_description }}</p>
    @endif
    <div class="read-more"><a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }} &thinsp;&raquo;</a></div>
</div>
</div>

<div class="container filters">
    <div class="pull-left">
    @include('widgets.artists.filters', array('artist' => $artist))
    @include('widgets.artists.series', array('artist' => $artist))
    </div>
    <div class="pull-right">
        @include('widgets.filters.sort', array('artist' => $artist))

        @if (! Config::get('app.gemini_lite'))
        @include('widgets.filters.list', array('artist' => $artist))
        @endif
    </div>
</div>

<div class="container listable">
    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

<div class="container">
    @include('widgets.artists.artist', array('artist' => $artist))
</div>

@if (! Config::get('app.gemini_lite'))
<div class="container spacy">
    <h3>Previously Viewed Artists</h3>
    <div class="row">
        @include('widgets.artists.card_sm', array('artists' => $artists_previous))
    </div>
    <div class="read-more">
        <a href="/artists">Browse All Artists</a>
    </div>
</div>
@endif

@stop