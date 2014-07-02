@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<h1>{{ $artwork->artist->alias }}, <i>{{ $artwork->title }}</i></h1>

<div class="jumbotron text-center">
    <p>
        {{ HTML::image($artwork->img_url()) }}
    </p>

    <table class="table text-left">
        <tbody>
        <tr>
            <th>Artist</th><td> <b><a href="{{ $artwork->artist->url() }}">{{ $artwork->artist->first_name }} {{ $artwork->artist->last_name }}</a></b></td>
        </tr>
        <tr>
            <th>Title</th><td> {{ $artwork->title }}</td>
        </tr>
        <tr>
            <th>Medium</th><td> {{ $artwork->medium }}</td>
        </tr>
        <tr>
            <th>Series</th><td> {{ $artwork->series }}</td>
        </tr>
        <tr>
            <th>Signature</th><td> {{ $artwork->signature }}</td>
        </tr>
        <tr>
            <th>Condition</th><td> {{ $artwork->condition }}</td>
        </tr>
        <tr>
            <th>Gallery Price</th><td>{{ $artwork->price_box() }}</td>
        </tr>
        </tbody>
    </table>

        <strong>After:</strong> {{ $artwork->after }}<br />
        <strong>Price on Request:</strong> {{ $artwork->price_on_req }}<br />
        <strong>Sold:</strong> {{ $artwork->sold }}<br />
        <strong>On Hold:</strong> {{ $artwork->onhold }}<br />
        <strong>Hidden:</strong> {{ $artwork->hidden }}<br />

    </p>
</div>

@stop