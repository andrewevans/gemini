@extends('layouts.master')

@section('title') Setup @stop

@section('content')

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-user"></i> Artists</h1>
        <a href="/gemini/artists/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Artist
        </a>

        <a href="/gemini/artists" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Artist
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-file-image-o"></i> Artworks</h1>
        <a href="/gemini/artworks/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Artwork
        </a>

        <a href="/gemini/artworks" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Artwork
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-book"></i> Catalogues</h1>
        <a href="/gemini/catalogues/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Catalogue
        </a>

        <a href="/gemini/catalogues" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Catalogue
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-file-text"></i> Catrefs</h1>
        <a href="/gemini/catrefs/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Catref
        </a>

        <a href="/gemini/catrefs" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Catref
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-file-text"></i> Users</h1>
        <a href="/gemini/user/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add User
        </a>

        <a href="/gemini/user" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit User
        </a>




    </div>
</div>



<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-trophy"></i> Showcaser</h1>
        <a href="/gemini/magnitude" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit a Showcaser
        </a>

        <a href="#" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Newsletter
        </a>

        <a href="#" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Presentation
        </a>



    </div>
</div>


@stop