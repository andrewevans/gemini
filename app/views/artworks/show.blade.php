@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<h1>Showing "{{ $artwork->title }}"</h1>

<div class="jumbotron text-center">
    <h2>{{ $artwork->title }}</h2>
    <p>
        <strong>Price:</strong> {{ $artwork->price }}<br />
        <strong>Title:</strong> {{ $artwork->title }}<br />
        <strong>Title SHORT:</strong> {{ $artwork->title_short }}<br />
        <strong>Series:</strong> {{ $artwork->series }}<br />
        <strong>Series SHORT:</strong> {{ $artwork->series_short }}<br />
        <strong>Medium:</strong> {{ $artwork->medium }}<br />
        <strong>Medium SHORT:</strong> {{ $artwork->medium_short }}<br />
        <strong>After:</strong> {{ $artwork->after }}<br />
        <strong>Signature:</strong> {{ $artwork->signature }}<br />
        <strong>Condition:</strong> {{ $artwork->condition }}<br />
        <strong>Price on Request:</strong> {{ $artwork->price_on_req }}<br />
        <strong>Sold:</strong> {{ $artwork->sold }}<br />
        <strong>On Hold:</strong> {{ $artwork->onhold }}<br />
        <strong>Hidden:</strong> {{ $artwork->hidden }}<br />

    </p>
</div>

@stop