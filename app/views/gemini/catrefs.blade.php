@extends('layouts.admin')

@section('content')
<!-- app/views/catrefs/index.blade.php -->

<div class="container">

<a class="btn btn-small btn-success" href="/gemini/catrefs/create">Create Catref</a>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Img</th>
        <th>ID</th>
        <th>Title</th>
        <th>Artist</th>
        <th style="width: 500px">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($catrefs as $key => $catref)
    <tr>
        <td></td>
        <td>{{ $catref->id }}</td>
        <td>{{ $catref->title }}</td>
        <td>
            <pre>{{ $catref->catalogue->artist->last_name }}</pre>
        </td>

        <!-- we will also add show, edit, and delete buttons -->
        <td>

            <!-- delete the catref (uses the destroy method DESTROY /catrefs/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => '/gemini/catrefs/' . $catref->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this catref', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the catref (uses the show method found at GET /catrefs/{id} -->
            <a class="btn btn-small btn-success" href="/catrefs/{{ $catref->id }}">Show this catref</a>

            <!-- edit this catref (uses the edit method found at GET /catrefs/{id}/edit -->
            <a class="btn btn-small btn-info" href="/gemini/catrefs/{{ $catref->id }}/edit">Edit this catref</a>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

</div>

@stop