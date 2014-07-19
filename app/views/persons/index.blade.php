@extends('layouts.default')

@section('content')
<!-- app/views/persons/index.blade.php -->

<div class="container">
    <h1>All the Persons</h1>

    @include('widgets.artists.card', array('artists' => $persons))
</div>

@stop