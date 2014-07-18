@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

<div class="container">
    @include('widgets.artists.artist', array('artist' => $artist))
</div>

@stop