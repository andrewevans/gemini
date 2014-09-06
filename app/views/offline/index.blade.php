@extends('layouts.offline')

@section('title') Login @stop

@section('content')

@foreach ($artworks as $artwork)

<div>
    <a href="/offline{{ $artwork->url() }}"><img src="{{ $artwork->img_url() }}" /></a>
<p>{{ $artwork->title }}<br />
{{ $artwork->artist->alias }}</p>
</div>

@endforeach

@stop
