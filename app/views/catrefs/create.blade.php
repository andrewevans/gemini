@extends('layouts.default')
<!-- app/views/catrefs/create.blade.php -->

@section('content')

<h1>Creat new Catref</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => 'catrefs')) }}

<div class="form-group">
    {{ Form::label('catalogue_id', 'Catalogue ID') }}
    {{ Form::textarea('catalogue_id', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('reference_num', 'Reference Number') }}
    {{ Form::textarea('reference_num', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('title', 'Title') }}
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

{{ Form::submit('Create the Catref!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop