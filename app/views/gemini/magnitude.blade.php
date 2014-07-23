@extends('layouts.admin')

@section('content')
<!-- app/views/artworks/index.blade.php -->

<div class="container">

<a class="btn btn-small btn-success" href="/gemini/artworks/create">Create Artwork</a>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th style="background: #aa0000; color: #eeeeee;">Magnitude</th>
        <th>Img</th>
        <th>ID</th>
        <th>Title</th>
        <th>Artist</th>
        <th>Price</th>
        <th style="width: 500px">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($artworks as $key => $artwork)
    <tr>
        <td style="background: #aa0000; color: #eeeeee;">{{ $artwork->magnitude }}</td>
        <td></td>
        <td>{{ $artwork->id }}</td>
        <td>{{ $artwork->title }}</td>
        <td>
            <pre>{{ $artwork->artist->last_name }}</pre>
        </td>
        <td class="list-price">{{ '$' . number_format($artwork->price) }}</td>

        <!-- we will also add show, edit, and delete buttons -->
        <td>

            <!-- delete the artwork (uses the destroy method DESTROY /artworks/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => '/gemini/artworks/' . $artwork->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this artwork', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the artwork (uses the show method found at GET /artworks/{id} -->
            <a class="btn btn-small btn-success" href="/artworks/{{ $artwork->id }}">Show this artwork</a>

            <!-- edit this artwork (uses the edit method found at GET /artworks/{id}/edit -->
            <a class="btn btn-small btn-info" href="/gemini/artworks/{{ $artwork->id }}/edit">Edit this artwork</a>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

</div>

@stop