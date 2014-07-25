@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

<div class="container">
<div class="intro-header" style="text-align: center; max-width:450px;"> <i class="sprite-h gtitle-deco above"></i>
    <h1>{{ $page_title }}</h1>
    <p>{{ $artist->meta_description }}</p>
    <div class="read-more"><a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }} &thinsp;&raquo;</a></div>
</div>
</div>

<div class="container filters">
    @include('widgets.artists.filters', array('artist' => $artist))
    @include('widgets.artists.series', array('artist' => $artist))
    <div class="pull-right">
        @include('widgets.filters.sort', array('artist' => $artist))
        @include('widgets.filters.list', array('artist' => $artist))
    </div>
</div>

<div class="container listable">
    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

<div class="container">
    @include('widgets.artists.artist', array('artist' => $artist))
</div>

<div class="container">
    <h3>Previously viewed Artists</h3>

    @include('widgets.artists.card', array('artists' => $artists_previous))
</div>

@stop