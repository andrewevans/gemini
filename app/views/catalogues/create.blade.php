@extends('layouts.default')
<!-- app/views/catalogues/create.blade.php -->

@section('content')

<h1>Creat new Catalogue</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => 'catalogues')) }}

<div class="form-group">
    {{ Form::label('title', 'Title') }}
    {{ Form::textarea('title', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('alias', 'Alias') }}
    {{ Form::textarea('alias', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('slug', 'Slug') }}
    {{ Form::text('slug', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('url_slug', 'URL Slug') }}
    {{ Form::text('url_slug', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('meta_title', 'meta Title') }}
    {{ Form::textarea('meta_title', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('meta_description', 'meta Description') }}
    {{ Form::textarea('meta_description', null, array('class' => 'form-control')) }}
</div>

{{ Form::submit('Create the Catalogue!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop