@extends('layouts.admin')

@section('content')
<!-- app/views/artworks/index.blade.php -->

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <h2>Mags</h2>
            <!-- if there are creation errors, they will show here -->
            {{ HTML::ul($errors->all()) }}

            {{ Form::open(array('route' => array('gemini.magnitude'), 'method' => 'GET')) }}

            <div class="form-group">
                {{ Form::label('artist_id', 'Artist ID') }}
                {{ Form::select('artist_id', $artists, $artist->id, array('class' => 'form-control')) }}
            </div>

            {{ Form::submit('Show this artist', array('class' => 'btn btn-primary')) }}
            <a href="/gemini/magnitude"><div class="btn btn-secondary">Reset</div></a>

            {{ Form::close() }}



        </div>
        <div class="col-md-6">
            <h2>Selected Mags for: {{ $artist->alias }}</h2>
            {{ Form::open(array('route' => array('gemini.magnitude'), 'method' => 'POST')) }}
            <h1 class="ui-widget">Customers</h1>
            <table id="table1" class="ui-widget connectedSortable table table-striped table-bordered">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th style="background: #aa0000; color: #eeeeee;">Magnitude</th>
                    <th>Img</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <?php $key_connected = 0; ?>
                @foreach($artworks as $key => $artwork)
                <tr class="ui-state-default">
                    <td style="vertical-align: middle; font-size:2em"><span class="fa fa-sort"></span></td>
                    <td style="background: #aa0000; color: #eeeeee;">{{ $artwork->magnitude }}</td>
                    <td><img src="{{ $artwork->img_url() }}" style="width:100px" /></td>
                    <td>{{ $artwork->id }}<br />
                        (Mag id #: {{ $artwork->object_importance_id }})
                        {{ Form::hidden('piece['. $key_connected . '][object_importance_id]', $artwork->object_importance_id, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][artwork_id]', $artwork->id, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][object_type]', 'w-' . $artwork->artist->slug, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][magnitude]', null, array('class' => 'form-control')) }}

                    </td>
                    <td>{{ $artwork->title }}</td>
                    <td>
                        <pre>{{ $artwork->artist->last_name }}</pre>
                    </td>
                    <td class="list-price">{{ '$' . number_format($artwork->price) }}</td>

                </tr>
                <?php $key_connected++; ?>
                @endforeach
                </tbody>
            </table>
            @if (sizeof($artworks) > 0)
            {{ Form::submit('Reorder these!', array('class' => 'btn btn-primary')) }}
            @else
            <p>Nothing to reorder.</p>
            @endif

            {{ Form::close() }}

        </div>
        @if ($artworks_from_artist != null)
        <div class="col-md-6">
            <h3>Available works by {{ $artist->alias }} ({{ sizeof($artworks_from_artist) }})</h3>

            <h1 class="ui-widget">Administrators</h1>
            <table id="table1" class="ui-widget connectedSortable table table-striped table-bordered">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th style="background: #aa0000; color: #eeeeee;">Magnitude</th>
                    <th>Img</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($artworks_from_artist as $key => $artwork)
                <tr class="ui-state-default">
                    <td style="vertical-align: middle; font-size:2em"><span class="fa fa-sort"></span></td>
                    <td style="background: #aa0000; color: #eeeeee;">{{ $artwork->magnitude }}</td>
                    <td><img src="{{ $artwork->img_url() }}" style="width:100px" /></td>
                    <td>{{ $artwork->id }}<br />
                        (Mag id #: {{ $artwork->object_importance_id }})
                        {{ Form::hidden('piece['. $key_connected . '][object_importance_id]', $artwork->object_importance_id, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][artwork_id]', $artwork->id, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][object_type]', 'w-' . $artwork->artist->slug, array('class' => 'form-control')) }}
                        {{ Form::hidden('piece['. $key_connected . '][magnitude]', null, array('class' => 'form-control')) }}

                    </td>
                    <td>{{ $artwork->title }}</td>
                    <td>
                        <pre>{{ $artwork->artist->last_name }}</pre>
                    </td>
                    <td class="list-price">{{ '$' . number_format($artwork->price) }}</td>

                </tr>
                <?php $key_connected++; ?>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
<a class="btn btn-small btn-success" href="/gemini/magnitude/create">Create Magnitude/Showcaser</a>





</div>

@stop