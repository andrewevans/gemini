@extends('layouts.admin')
<!-- app/views/artworks/edit.blade.php -->

@section('content')

<h1>Creat new Artwork</h1>
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => '/gemini/artworks')) }}
<div class="form-group">
    {{ Form::label('artist_id', 'Artist ID') }}
    {{ Form::select('artist_id', $artists , Input::old('artist_id') ? Input::old('artist_id') : $artwork_newest['artist_id'], array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('price', 'price') }}
    {{ Form::text('price', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('Title', 'Title') }}
    {{ Form::textarea('title', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('title_short', 'Title SHORT') }}
    {{ Form::textarea('title_short', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('series', 'Series') }}
    {{ Form::textarea('series', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('series_short', 'Series SHORT') }}
    {{ Form::textarea('series_short', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('medium', 'Medium') }}
    {{ Form::textarea('medium', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('medium_short', 'Medium SHORT') }}
    {{ Form::textarea('medium_short', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('after', 'After') }}
    {{ Form::textarea('after', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('signature', 'Signature') }}
    {{ Form::textarea('signature', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('condition', 'Condition') }}
    {{ Form::textarea('condition', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('price_on_req', 'Price on Request') }}
    {{ Form::text('price_on_req', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('sold', 'Sold') }}
    {{ Form::text('sold', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('onhold', 'On Hold') }}
    {{ Form::text('onhold', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('hidden', 'Hidden') }}
    {{ Form::text('hidden', null, array('class' => 'form-control')) }}
</div>

{{ Form::submit('Create the Artwork!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop