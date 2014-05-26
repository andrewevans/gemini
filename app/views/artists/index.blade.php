@extends('layouts.default')

@section('content')
<!-- app/views/artists/index.blade.php -->

<div class="starter-template">
    <h1>Welcome to The Gemini Project</h1>
    <p class="lead">Austin Echo Park mumblecore kitsch, Schlitz Cosby sweater forage fanny pack VHS Helvetica Etsy mlkshk sustainable drinking vinegar.
        <br> All you get is this text and a mostly barebones HTML document.</p>
</div>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>ID</td>
        <td>Alias</td>
        <td>Name</td>
        <td>metas</td>
        <td>Artworks</td>
        <td>&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    @foreach($artists as $key => $artist)
    <tr>
        <td>{{ $artist->id }}</td>
        <td>{{ $artist->alias }}</td>
        <td>{{ $artist->first_name }} {{ $artist->last_name }} ({{ $artist->year_begin }} - {{ $artist->year_end }})</td>
        <td><b>{{ $artist->meta_title }}:</b> {{ $artist->meta_description }}</td>
        <td>
            @foreach($artist->artworks as $artwork)
            <pre>{{ $artwork->title }}</pre>
            @endforeach
        </td>

        <!-- we will also add show, edit, and delete buttons -->
        <td>

            <!-- delete the artist (uses the destroy method DESTROY /artists/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => 'artists/' . $artist->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this artist', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the artist (uses the show method found at GET /artists/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('artists/' . $artist->url_slug) }}">Show this artist</a>

            <!-- edit this artist (uses the edit method found at GET /artists/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('artists/' . $artist->id . '/edit') }}">Edit this artist</a>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@stop