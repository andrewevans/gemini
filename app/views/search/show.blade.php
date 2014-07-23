@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

<div class="container filters">
    <div class="pull-right">
        @include('widgets.filters.sort', array('artist' => null))
        @include('widgets.filters.list', array('artist' => null))
    </div>

</div>

<div class="container listable">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-10">
            <p style="color: #fff; font-size:2em">Results for "<b>{{ $q }}</b>" found {{ sizeof($artworks) }} artworks from {{ sizeof($artists) }} artists.</p>
            <h2>Artworks</h2>
            @if (sizeof($artworks) > 0)
                @include('widgets.artworks.card', array('artworks' => $artworks))
            @else
                <p>We don't have works to show that match your search, but please feel free to <a href="/contact">contact us</a> about works that you are looking for. We would be happy to look into it for you.</p>
            @endif

        </div>
    </div>
</div>

<h2>Artists</h2>
<div class="jumbotron text-center">
    @include('widgets.artists.card', array('artists' => $artists))
</div>

<h2>In-Depth Articles</h2>
<div class="jumbotron text-center">
    @include('widgets.search.pages', array('pages' => $pages))
</div>

<h2>Blog Posts</h2>
<div class="jumbotron text-center">
    @include('widgets.search.posts', array('posts' => $posts))
</div>


@stop