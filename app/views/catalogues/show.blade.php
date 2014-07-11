@extends('layouts.default')
<!-- app/views/catalogues/show.blade.php -->

@section('content')

<div class="container">
    <div class="intro-header" style="text-align: center; max-width:450px;"> <i class="sprite-h gtitle-deco above"></i>
        <h1>{{ $page_title }}</h1>
        <p>{{ $catalogue->meta_description }}</p>
    </div>
</div>

<div class="container">
    @include('widgets.filters.list', array('artist' => $catalogue->artist))
</div>


<div class="container">
    @include('widgets.catrefs.card', array('catrefs' => $catrefs))
</div>

@stop