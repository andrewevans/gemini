@extends('layouts.default')
<!-- app/views/artworks/edit.blade.php -->

@section('content')

<h1>Edit {{ $artwork->title }}</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::model($artwork, array('route' => array('artworks.update', $artwork->id), 'files' => true, 'method' => 'PUT')) }}

<div class="form-group">
    {{ Form::label('Title', 'Title') }}
    {{ Form::text('title', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('price', 'price') }}
    {{ Form::text('price', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('medium', 'Medium') }}
    {{ Form::text('medium', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('thumb', 'Thumbnail') }}
    {{ Form::file('thumb', array('class' => 'form-control')) }}
</div>


{{ Form::submit('Edit the Artwork!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop