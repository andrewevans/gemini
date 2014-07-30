@extends('layouts.default')

@section('title') Login @stop

@section('content')

<div class="container spacy">
    <div class="row">
        @include('widgets.splashes_netty')
    </div>
</div>

<div class="container spacy">
    <h3>Featured Artists</h3>
    <div class="row">
        @include('widgets.artists.card_sm', array('artists' => $artists_featured))
    </div>
    <div class="read-more">
        <a href="/artists">Browse All Artists</a>
    </div>
</div>

<div class="container spacy">
    <h3>Our Featured Collection</h3>
    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

<div class="container spacy">
    <h3><a href="/articles"><span class="fa fa-file-text"></span> Featured In-Depth Articles</a></h3>
    <div class="row">
        @include('widgets.pages', array('filter' => 'homepage'))
    </div>
    <div class="read-more">
        <a href="/articles">Read more In-Depth Articles</a>
    </div>
</div>

<div class="container spacy">
    <h3><a href=""><span class="fa fa-rss"></span> Featured Posts</a></h3>
    <div class="row">
        @include('widgets.posts', array('filter' => 'homepage'))
    </div>
    <div class="read-more">
        <a href="http://wp.andrew.com">Read more Blog posts</a>
    </div>

</div>

@if (sizeof($artworks_previous) > 0)
    <div class="container">
        <h3>Previously viewed Artworks</h3>
        @include('widgets.artworks.card_sm', array('artworks' => $artworks_previous))
    </div>
@endif

@stop
