@extends('layouts.admin')

@section('content')
<!-- app/views/splashes/index.blade.php -->

<div class="jumbotron">
    <div class="row">
        <div class="col-md-12">
            <!-- if there are creation errors, they will show here -->
            {{ HTML::ul($errors->all()) }}
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">

            <h2>Splashes</h2>

            {{ Form::open(array('route' => array('gemini.splashes'), 'method' => 'GET')) }}

            <div class="form-group">
                {{ Form::label('artist_id', 'Artist ID') }}
                {{ Form::select('artist_id', $artists, $artist->id, array('class' => 'form-control')) }}
            </div>

            {{ Form::submit('Show this artist', array('class' => 'btn btn-primary')) }}
            <a href="/gemini/splashes"><div class="btn btn-secondary">Reset</div></a>

            {{ Form::close() }}



        </div>
        <div class="col-md-6">
            <h2>Create new splash</h2>

            {{ Form::open(array('route' => array('gemini.splashes.store'), 'method' => 'POST')) }}

            <div class="form-group">
                {{ Form::label('destination_url', 'Destination URL') }}
                {{ Form::text('destination_url', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('asset_url', 'Asset URL') }}
                {{ Form::text('asset_url', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('title', 'Title') }}
                {{ Form::text('title', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::text('description', null, array('class' => 'form-control')) }}
            </div>

            {{ Form::submit('Create splash!', array('class' => 'btn btn-primary')) }}
            {{ Form::close() }}



        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php $key_connected = 0; ?>
            @if ($splashes_from_artist != null)
            <h3>Selected Splashes for: {{ $artist->alias }}</h3>
            {{ Form::open(array('route' => array('gemini.splashes.update'), 'method' => 'PUT')) }}
            {{ Form::hidden('artist_slug', $artist->slug, array('class' => 'form-control')) }}

            <table id="table1" class="ui-widget connectedSortable table table-striped table-bordered">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th style="background: #aa0000; color: #eeeeee;">Position</th>
                    <th style="width:200px">asset url</th>
                    <th>Title/desc</th>
                    <th>destination</th>
                </tr>
                </thead>
                <tbody>
                @foreach($splashes_from_artist as $key => $splash)
                <tr class="ui-state-default">
                    <td style="vertical-align: middle; font-size:2em"><span class="fa fa-sort"></span></td>
                    <td style="background: #aa0000; color: #eeeeee;">{{ $splash->position }}
                    <br />@ {{ $splash->location_slug }}</td>
                    <td><img src="{{ $splash->asset_url }}" style="width:100px" /></td>
                    <td>{{ $splash->title }}<br />
                        {{ $splash->description }}<br />
                        (Splash id #: {{ $splash->id }})
                        {{ Form::hidden('piece['. $key_connected . '][id]', $splash->id, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][position]', null, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][location_slug]', $splash->location_slug, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][title]', $splash->title, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][description]', $splash->description, array('class' => 'form-control')) }}
                    </td>
                    <td>{{ $splash->destination_url }}</td>

                </tr>
                <?php $key_connected++; ?>
                @endforeach

                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                </tbody>
            </table>
            {{ Form::submit('Reorder these!', array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}
            @endif
        </div>
        <div class="col-md-6">
            <h3>Available Splashes</h3>

            <table id="table1" class="ui-widget connectedSortable table table-striped table-bordered">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th style="background: #aa0000; color: #eeeeee;">Position</th>
                    <th style="width:200px">asset url</th>
                    <th>Title</th>
                    <th>destination</th>
                </tr>
                </thead>
                <tbody>
                @foreach($splashes_not_from_artist as $key => $splash)
                <tr class="ui-state-default">
                    <td style="vertical-align: middle; font-size:2em"><span class="fa fa-sort"></span></td>
                    <td style="background: #aa0000; color: #eeeeee;">{{ $splash->position }}
                        <br />@ {{ $splash->location_slug }}</td>
                    <td><img src="{{ $splash->asset_url }}" style="width:100px" /></td>
                    <td>{{ $splash->title }}<br />
                        (Splash id #: {{ $splash->id }})
                        {{ Form::hidden('piece['. $key_connected . '][id]', $splash->id, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][position]', null, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][location_slug]', $splash->location_slug, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][title]', $splash->title, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][description]', $splash->description, array('class' => 'form-control')) }}
                    </td>
                    <td>{{ $splash->destination_url }}</td>

                </tr>
                <?php $key_connected++; ?>
                @endforeach
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>

                </tbody>
            </table>
        </div>
    </div>





</div>

@stop