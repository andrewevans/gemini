@extends('layouts.default')

@section('title') Login @stop

@section('content')

@foreach ($artworks as $artwork)

    <img src="{{ $artwork->img_url() }}" />

@endforeach

@stop
