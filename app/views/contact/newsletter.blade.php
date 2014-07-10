@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<div class="container">
        {{ HTML::ul($errors->all()) }}
</div>

<div class="container">
    <h1>Fine Art Updates, from the source.</h1>
</div>

<div class="container">
    <div class="row">
    @if ($submitted != true)

        <div class="col-md-6">
            {{ Form::open(array('url' => 'newsletter', 'method' => 'post')) }}

            <div class="form-group">
                {{ Form::label('cust_first_name', 'Your first name') }}
                {{ Form::text('cust_first_name', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('cust_last_name', 'Your last name') }}
                {{ Form::text('cust_last_name', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('cust_email', 'Your email') }}
                {{ Form::text('cust_email', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                <ul>
                    @foreach($artists as $key => $artist)
                        <li>
                            <label>
                            {{ Form::checkbox('artists[' . $key . ']', $artist->slug, false) }}
                            {{ $artist->alias }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>


            {{ Form::submit('Send message', array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}

        </div>
    @else
        <div class="col-md-6">
            <p>Thank you for your inquiry. We'll get back to you shortly!</p>
        </div>
        @endif
    </div>

</div>

@stop