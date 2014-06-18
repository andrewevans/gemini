@extends('layouts.default')

@section('content')
<!-- app/views/persons/index.blade.php -->

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
    @foreach($persons as $key => $person)
    <tr>
        <td>{{ $person->id }}</td>
        <td>{{ $person->alias }}</td>
        <td>{{ $person->first_name }} {{ $person->last_name }} ({{ $person->year_begin }} - {{ $person->year_end }})</td>
        <td><b>{{ $person->meta_title }}:</b> {{ $person->meta_description }}</td>
        <td>
        </td>

        <!-- we will also add show, edit, and delete buttons -->
        <td>

            <!-- delete the person (uses the destroy method DESTROY /people/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => 'people/' . $person->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this person', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the person (uses the show method found at GET /persons/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('people/' . $person->url_slug) }}">Show this person</a>

            <!-- edit this person (uses the edit method found at GET /persons/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('people/' . $person->id . '/edit') }}">Edit this person</a>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@stop