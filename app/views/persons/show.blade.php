@extends('layouts.default')
<!-- app/views/persons/show.blade.php -->

@section('content')
<!-- Carousel
================================================== -->

<div class="jumbotron text-center">
    <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>
    {{ HTML::image($person->img_url()) }}

    <p>{{ $person->meta_description }}</p>
</div>
@stop