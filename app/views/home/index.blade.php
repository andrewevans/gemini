@extends('layouts.default')

@section('title') Login @stop

@section('content')

<div class="container">
    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

<div class="container">
    @include('widgets.artists.card', array('artists' => $artists))
</div>


<div class="row">
    <div class="col-md-5 col-md-offset-1">
        @include('widgets.pages', array('filter' => 'homepage'))
    </div>
    <div class="col-md-5">
        @include('widgets.posts', array('filter' => 'homepage'))
    </div>
</div>

<div class="container">
    <h3>Previously viewed Artworks</h3>

    @include('widgets.artworks.card', array('artworks' => $artworks_previous))
</div>

<div class="container">
    <h3>Previously viewed Artists</h3>

    @include('widgets.artists.card', array('artists' => $artists_previous))
</div>

@stop
