@extends('layouts.default')
<!-- app/views/catrefs/show.blade.php -->

@section('content')

<div class="container">
    <div class="intro-header" style="text-align: center; max-width:450px;"> <i class="sprite-h gtitle-deco above"></i>
        <h1>{{ $page_title }}</h1>
        <p>{{ $catref->reference_num }}</p>
    </div>
</div>

@stop