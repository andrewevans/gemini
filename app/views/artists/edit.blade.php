@extends('layouts.default')
<!-- app/views/artists/edit.blade.php -->

@section('content')

<h1>Edit {{ $artist->alias }}</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::model($artist, array('route' => array('artists.update', $artist->id), 'files' => true, 'method' => 'PUT')) }}

<div class="form-group">
    {{ Form::label('first_name', 'First Name') }}
    {{ Form::textarea('first_name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('last_name', 'Last Name') }}
    {{ Form::textarea('last_name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('alias', 'Alias') }}
    {{ Form::textarea('alias', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('slug', 'Slug') }}
    {{ Form::text('slug', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
</div>

<div class="form-group">
    {{ Form::label('url_slug', 'URL Slug') }}
    {{ Form::text('url_slug', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}
</div>

<div class="form-group">
    {{ Form::label('meta_title', 'meta Title') }}
    {{ Form::textarea('meta_title', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('meta_description', 'meta Description') }}
    {{ Form::textarea('meta_description', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('year_begin', 'Year Begin') }}
    {{ Form::text('year_begin', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('year_end', 'Year End') }}
    {{ Form::text('year_end', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('avatar', 'Avatar') }}
    {{ Form::file('avatar', array('class' => 'form-control')) }}
</div>


{{ Form::submit('Edit the Artist!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop