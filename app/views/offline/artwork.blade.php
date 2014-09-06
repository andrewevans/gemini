@extends('layouts.offline')

@section('title') Login @stop

@section('content')

<div>
    <img src="{{ $artwork->img_url() }}" />
    <p>{{ $artwork->title }}<br />
    {{ $artwork->artist->alias }}</p>
</div>


@stop
