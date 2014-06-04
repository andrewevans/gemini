@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

@include('widgets.artists.artist', array('artist' => $artist))

@stop