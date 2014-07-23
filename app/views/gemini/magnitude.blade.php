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

    {{ Form::submit('Show this showcaser', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}



    <table class="table table-striped table-bordered">
    <thead>
    <tr>
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
    <tr>
        <td style="background: #aa0000; color: #eeeeee;">{{ $artwork->magnitude }}</td>
        <td></td>
        <td>{{ $artwork->id }}</td>
        <td>{{ $artwork->title }}</td>
        <td>
            <pre>{{ $artwork->artist->last_name }}</pre>
        </td>
        <td class="list-price">{{ '$' . number_format($artwork->price) }}</td>

    </tr>
    @endforeach
    </tbody>
</table>

</div>

@stop