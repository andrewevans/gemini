@extends('layouts.master')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<div class="container">
    <h1>Welcome to API!</h1>

    <ul>
        <li><a href="/api/v1/url/artists">Artists</a></li>
        <li><a href="/api/v1/url/artworks">Artworks</a></li>
        <li><a href="/api/v1/url/Catalogues">Catalogues</a></li>
        <li><a href="/api/v1/url/Catrefs">Catrefs</a></li>
        <li><a href="/api/v1/newsletter">Newsletter (requires: email)</a></li>
    </ul>
</div>
@stop