@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')
<div class="container">
    <h1>{{ $post->post_title }}</h1>

    <div class="row">
        <div class="col-md-9">
            {{ apply_filters('the_content',$post->post_content); }}
        </div>
        <div class="col-md-3">

        </div>

</div>

@stop