@extends('layouts.master')

@section('title') Setup @stop

@section('content')

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-user"></i> Artists</h1>
        <a href="/artists/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Artist
        </a>

        <a href="/artists" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Artist
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-file-image-o"></i> Artworks</h1>
        <a href="/artworks/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Artwork
        </a>

        <a href="/artworks" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Artwork
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-book"></i> Catalogues</h1>
        <a href="/catalogues/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Catalogue
        </a>

        <a href="/catalogues" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Catalogue
        </a>

    </div>
</div>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        <h1><i class="fa fa-file-text"></i> Catrefs</h1>
        <a href="/catrefs/create" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-plus"></span> Add Catref
        </a>

        <a href="/catrefs" type="button" class="btn btn-default btn-lag">
            <span class="glyphicon glyphicon-pencil"></span> Edit Catref
        </a>

    </div>
</div>


<div class="col-lg-10 col-lg-offset-1">

    <h1><i class="fa fa-users"></i> User Administration <a href="/logout" class="btn btn-default pull-right">Logout</a></h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->getFullName() }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                <td>
                    <a href="/user/{{ $user->id }}/edit" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                    {{ Form::open(['url' => '/user/' . $user->id, 'method' => 'DELETE']) }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    <a href="/user/create" class="btn btn-success">Add User</a>

</div>

@stop