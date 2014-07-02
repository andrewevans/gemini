@extends('layouts.default')

@section('content')

<div class="container">

<h1>Your Information</h1>
<p>We will ONLY use this information for sending and replying to this inquiry.</p>

<div class="row">

<div class="col-md-6">
    {{ HTML::ul($errors->all()) }}

    {{ Form::open(array('url' => 'offer')) }}

    <div class="form-group">
        {{ Form::label('cust_name', 'Your name') }}
        {{ Form::text('cust_name', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('cust_email', 'Your email') }}
        {{ Form::text('cust_email', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('cust_phone', 'Your phone number') }}
        {{ Form::text('cust_phone', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('cust_address', 'Your shipping address') }}
        {{ Form::text('cust_address', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('cust_country', 'Country') }}
        {{ Form::text('cust_country', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('cust_offer', 'Your offer') }}
        ${{ Form::text('cust_offer', null, array('class' => 'form-control')) }}
    </div>

    {{ Form::hidden('artwork_id', $id, array('class' => 'form-control')) }}
    {{ Form::submit('Send purchase inquiry', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

    @include('widgets.artworks.card', array('artworks' => $artworks))

</div>

</div>


@stop