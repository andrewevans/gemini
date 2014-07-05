@extends('layouts.default')
<!-- app/views/catalogues/create.blade.php -->

@section('content')

<h1>Create new Catalogue</h1>

<!-- if there are creation errors, they will show here -->

@if($errors->has())
<div class="alert alert-danger">
    {{ HTML::ul($errors->all()) }}
</div>
@endif

{{ Form::open(array('url' => '/gemini/catalogues')) }}
* = Required
<div class="form-group">
    {{ Form::label('artist_id', 'Artist *') }}
    {{ Form::select('artist_id', $artists , Input::old('artist_id') ? Input::old('artist_id') : $catalogue_newest['artist_id'],
    array('class' => 'form-control',  'data-toggle' => 'tooltip', 'data-original-title' => 'Every catalogue belongs to ONE artist')) }}

</div>

<div class="form-group">
    {{ Form::label('title', 'Title *') }}
    {{ Form::textarea('title', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('slug', 'Slug *') }}<span>Used internally, including for folder name. Author's last name is fine. Only a-z characters, no accents, etc. <i>And you can't change this!</i> (Ex: sorlier)</span>
    {{ Form::text('slug', null,
    array('class' => 'form-control',  'data-toggle' => 'tooltip', 'data-original-title' => 'Only a-z characters, no accents, etc.')) }}
</div>

<div class="form-group">
    {{ Form::label('url_slug', 'URL Slug *') }} <span>Appears in the URL of the catalogue. Author's last name followed by a short version of the title. Only a-z, and use a dash '-' for each space. (ex: ramie-picasso-catalogue-of-the-edited-works)</span>
    {{ Form::text('url_slug', null,
    array('class' => 'form-control',  'data-toggle' => 'tooltip', 'data-original-title' => 'Only a-z characters, and dash \'-\' for spaces')) }}
</div>

<div class="form-group">
    {{ Form::label('meta_description', 'Meta Description') }}
    {{ Form::textarea('meta_description', null,
    array('class' => 'form-control', 'data-toggle' => 'tooltip', 'data-original-title' => 'Use any characters')) }}
</div>

{{ Form::submit('Create the Catalogue!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop