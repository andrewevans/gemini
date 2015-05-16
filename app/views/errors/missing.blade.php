@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<div class="container">
    {{ HTML::ul($errors->all()) }}
</div>

<div class="container">
    <h1><b>404</b> Whoops! We could not find the page you are looking for.</h1>
</div>

@stop