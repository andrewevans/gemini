@extends('layouts.default')

@section('content')
<!-- app/views/artworks/index.blade.php -->

<div class="container">
    <h1>Newest Artworks</h1>

    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

@stop