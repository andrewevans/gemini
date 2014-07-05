@extends('layouts.admin')

@section('content')
<!-- app/views/catalogues/index.blade.php -->

<div class="container">

<a class="btn btn-small btn-success" href="/gemini/catalogues/create">Create Catalogue</a>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>ID</td>
        <td>Title</td>
        <td>Catrefs</td>
        <td>&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    @foreach($catalogues as $key => $catalogue)
    <tr>
        <td>{{ $catalogue->id }}</td>
        <td>{{ $catalogue->title }}</td>
        <td>
            {{ sizeof($catalogue->catrefs) }}
        </td>

        <!-- we will also add show, edit, and delete buttons -->
        <td>

            <!-- delete the catalogue (uses the destroy method DESTROY /catalogues/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => '/gemini/catalogues/' . $catalogue->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this catalogue', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the catalogue (uses the show method found at GET /catalogues/{id} -->
            <a class="btn btn-small btn-success" href="{{ $catalogue->url() }}">Show this catalogue</a>

            <!-- edit this catalogue (uses the edit method found at GET /catalogues/{id}/edit -->
            <a class="btn btn-small btn-info" href="/gemini/catalogues/{{ $catalogue->id }}/edit">Edit this catalogue</a>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

</div>
@stop