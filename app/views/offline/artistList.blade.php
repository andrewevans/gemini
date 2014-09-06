@extends('layouts.offline')

@section('title') Login @stop

@section('content')

@foreach ($artists as $artist)

<div>
    <a href="/offline{{ $artist->url() }}">{{ $artist->inverted_alias() }}</a>
</div>

@endforeach

@stop
