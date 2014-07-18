@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')


<div class="container">
    <h1>{{ $post->post_title }}</h1>
    {{ apply_filters('the_content',$post->post_content); }}
</div>

<div class="container">
    @include('widgets.artists.artist', array('artist' => $artist))
</div>

@stop