@extends('layouts.admin')

@section('content')
<!-- app/views/artists/index.blade.php -->

<div class="container">

<a class="btn btn-small btn-success" href="/gemini/artists/create">Create Artist or Person</a>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Alias</td>
        <td>Artworks</td>
        <td>&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    @foreach($artists as $key => $artist)
    <tr>
        <td>{{ $artist->id }}</td>
        <td>{{ $artist->last_name }}, {{ $artist->last_name }}</td>
        <td>{{ $artist->alias }}</td>
        <td>
            {{ sizeof($artist->artworks) }}
        </td>

        <!-- we will also add show, edit, and delete buttons -->
        <td>

            <!-- delete the artist (uses the destroy method DESTROY /artists/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => '/gemini/artists/' . $artist->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this artist', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the artist (uses the show method found at GET /artists/{id} -->
            <a class="btn btn-small btn-success" href="{{ $artist->url() }}">Show this artist</a>

            <!-- edit this artist (uses the edit method found at GET /artists/{id}/edit -->
            <a class="btn btn-small btn-info" href="/gemini/artists/{{ $artist->id }}/edit">Edit this artist</a>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

</div>
@stop