@extends('layouts.default')

@section('content')
<!-- app/views/artworks/index.blade.php -->

<div class="container">
    <h1>All the Artists</h1>

    @include('widgets.artists.card', array('artists' => $artists))
</div>

@stop