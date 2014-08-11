@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')


<div class="container">
    <div class="col-md-3">
        @include('widgets.artists.ribbon', ['artist' => $artist, 'filter_slug' => null])
    </div>
    <div class="col-md-8">
        <h1>{{ $post->post_title }}</h1>
        @include('widgets.share', ['post' => $post])

        {{ apply_filters('the_content',$post->post_content); }}

        @include('widgets.share')
    </div>

</div>

<div class="container">
    @include('widgets.artists.artist', array('artist' => $artist))
</div>

@stop