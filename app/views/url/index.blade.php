@extends('layouts.master')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<div class="container">
    <h1>Welcome to API!</h1>

    <ul>
        <li><a href="/api/v1/url/artists">Artists</a></li>
        <li><a href="/api/v1/url/artists_descriptions">Artists' Descriptions</a></li>
        <li><a href="/api/v1/url/artworks">Artworks</a></li>
        <li><a href="/api/v1/url/catalogues">Catalogues</a></li>
        <li><a href="/api/v1/url/catrefs">Catrefs</a></li>
        <li><a href="/api/v1/newsletter">Newsletter</a>
            <ul>
                <li>email (required)</li>
                <li>first_name</li>
                <li>last_name</li>
                <li>email lists (comma delimited)</li>
            </ul>
        </li>
    </ul>
</div>
@stop