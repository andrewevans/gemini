@extends('layouts.default')

@section('content')
<!-- app/views/artworks/index.blade.php -->

<div class="container">
    <h1>All the Articles</h1>

    @foreach ($posts_by_category as $key => $posts)

        <h2>{{ $categories_name[$key] }}</h2>
        @foreach ($posts as $post)
            <h3><a href="/articles/{{ $post->post_name }}">{{ $post->post_title }}</a></h3>
        @endforeach

    @endforeach
</div>

@stop