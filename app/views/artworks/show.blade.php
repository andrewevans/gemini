@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<h1>{{ $artwork->artist->alias }}, <i>{{ $artwork->title }}</i></h1>

<div class="jumbotron text-center">
    <p>
        {{ HTML::image($artwork->img_url()) }}
    </p>

    <div class="container">

    <table class="table text-left">
        <tbody>
        <tr>
            <th>Artist</th><td> <b><a href="{{ $artwork->artist->url() }}">{{ $artwork->artist->first_name }} {{ $artwork->artist->last_name }}</a></b></td>
        </tr>
        <tr>
            <th>Title</th><td> {{ $artwork->title }}</td>
        </tr>
        @if ($artwork->medium != '')
        <tr>
            <th>Medium</th><td> {{ $artwork->medium }}</td>
        </tr>
        @endif
        @if ($artwork->series != '')
        <tr>
            <th>Series</th><td> {{ $artwork->series }}</td>
        </tr>
        @endif
        @if ($artwork->signature != '')
        <tr>
            <th>Signature</th><td> {{ $artwork->signature }}</td>
        </tr>
        @endif
        @if ($artwork->condition != '')
        <tr>
            <th>Condition</th><td> {{ $artwork->condition }}</td>
        </tr>
        @endif
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
    </div>

</div>

@stop