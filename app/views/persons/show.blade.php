@extends('layouts.default')
<!-- app/views/persons/show.blade.php -->

@section('content')
<!-- Carousel
================================================== -->

<div class="container">
<div class="intro-header" style="text-align: center; max-width:450px;"> <i class="sprite-h gtitle-deco above"></i>
    <h1>{{ $page_title }}</h1>
    <p>{{ $person->meta_description }}</p>
</div>
</div>


@stop