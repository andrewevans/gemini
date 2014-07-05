@extends('layouts.default')

@section('content')
<!-- app/views/catalogues/index.blade.php -->

<div class="container">
    <h1>{{ $artist->alias }} Catalogue Raisonn&eacute;s</h1>

    @include('widgets.catalogues.card', array('artist' => $artist))
</div>

@stop