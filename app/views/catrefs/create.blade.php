@extends('layouts.default')
<!-- app/views/catrefs/create.blade.php -->

@section('content')

<h1>Creat new Catref</h1>

<!-- if there are creation errors, they will show here -->
@if($errors->has())
<div class="alert alert-danger">
    {{ HTML::ul($errors->all()) }}
</div>
@endif

{{ Form::open(array('url' => 'catrefs', 'files' => true)) }}
* = Required

<div class="form-group">
    {{ Form::label('catalogue_id', 'Catalogue *') }}
    {{ Form::select('catalogue_id', $catalogues , Input::old('catalogue_id') ? Input::old('catalogue_id') : $catref_newest['catalogue_id'], array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('reference_num', 'Reference Number *') }}
    {{ Form::textarea('reference_num', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('title', 'Title *') }}
    {{ Form::textarea('title', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('title_ext', 'Title Extended') }}
    {{ Form::textarea('title_ext', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('size', 'Size') }}
    {{ Form::textarea('size', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('signed', 'Signed') }}
    {{ Form::textarea('signed', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('edition', 'Edition') }}
    {{ Form::textarea('edition', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('medium', 'Medium') }}
    {{ Form::textarea('size', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('therest', 'The rest') }}
    {{ Form::textarea('therest', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('catref_img', 'Catref Image') }}
    {{ Form::file('catref_img', array('class' => 'form-control')) }}
</div>

{{ Form::submit('Create the Catref!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop