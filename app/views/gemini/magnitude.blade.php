@extends('layouts.admin')

@section('content')
<!-- app/views/artworks/index.blade.php -->

<div class="container">

<a class="btn btn-small btn-success" href="/gemini/magnitude/create">Create Magnitude/Showcaser</a>



<h2>Mags</h2>
    <!-- if there are creation errors, they will show here -->
    {{ HTML::ul($errors->all()) }}

    {{ Form::open(array('route' => array('gemini.magnitude'), 'method' => 'GET')) }}

    <div class="form-group">
        {{ Form::label('artist_id', 'Artist ID') }}
        {{ Form::select('artist_id', $artists, $artist->id, array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Show this artist', array('class' => 'btn btn-primary')) }}
    <a href="/gemini/magnitude"><div class="btn btn-secondary">Reset</div></a>

    {{ Form::close() }}



    <h2>Selected Mags for: {{ $artist->alias }}</h2>
    {{ Form::open(array('route' => array('gemini.magnitude'), 'method' => 'POST')) }}

    <table id="sortable" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th style="background: #aa0000; color: #eeeeee;">Magnitude</th>
        <th>Img</th>
        <th>ID</th>
        <th>Title</th>
        <th>Artist</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($artworks as $key => $artwork)
    <tr class="ui-state-default">
        <td style="vertical-align: middle; font-size:2em"><span class="fa fa-sort"></span></td>
        <td style="background: #aa0000; color: #eeeeee;">{{ $artwork->magnitude }}</td>
        <td></td>
        <td>{{ $artwork->artwork_id }}<br />
            (Mag id #: {{ $artwork->object_importance_id }})
            {{ Form::hidden('piece[]', $artwork->object_importance_id, array('class' => 'form-control')) }}

        </td>
        <td>{{ $artwork->title }}</td>
        <td>
            <pre>{{ $artwork->artist->last_name }}</pre>
        </td>
        <td class="list-price">{{ '$' . number_format($artwork->price) }}</td>

    </tr>
    @endforeach
    </tbody>
</table>
    @if (sizeof($artworks) > 0)
    {{ Form::submit('Reorder these!', array('class' => 'btn btn-primary')) }}
    @else
    <p>Nothing to reorder.</p>
    @endif

    {{ Form::close() }}


</div>

@stop