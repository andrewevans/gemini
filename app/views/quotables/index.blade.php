@extends('layouts.default')
<!-- app/views/quotables/index.blade.php -->

@section('content')

<div class="container">
    <div class="row">
        @include('widgets.quotables.card', array('quotes' => $quotes))
    </div>
</div>

@stop