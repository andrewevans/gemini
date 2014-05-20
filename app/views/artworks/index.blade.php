@extends('layouts.default')

@section('content')
<!-- app/views/artworks/index.blade.php -->

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>ID</td>
        <td>Title</td>
        <td>Medium</td>
        <td>Price</td>
        <td>&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    @foreach($artworks as $key => $artwork)
    <tr>
        <td>{{ $artwork->id }}</td>
        <td>{{ $artwork->title }}</td>
        <td>{{ $artwork->medium }}</td>
        <td>{{ $artwork->price }}</td>

        <!-- we will also add show, edit, and delete buttons -->
        <td>

            <!-- delete the artwork (uses the destroy method DESTROY /artworks/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => 'artworks/' . $artwork->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this artwork', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the artwork (uses the show method found at GET /artworks/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('artworks/' . $artwork->id) }}">Show this artwork</a>

            <!-- edit this artwork (uses the edit method found at GET /artworks/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('artworks/' . $artwork->id . '/edit') }}">Edit this artwork</a>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@stop