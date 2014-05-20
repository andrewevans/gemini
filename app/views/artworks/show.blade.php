@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<h1>Showing "{{ $artwork->title }}"</h1>

<div class="jumbotron text-center">
    <h2>{{ $artwork->title }}</h2>
    <p>
        <strong>Price:</strong> {{ $artwork->price }}<br />
        <strong>Medium:</strong> {{ $artwork->medium }}<br />

    </p>
</div>

@stop