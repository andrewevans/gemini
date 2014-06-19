@extends('layouts.default')
<!-- app/views/catrefs/index.blade.php -->

@section('content')

<a class="btn btn-small btn-success" href="/catrefs/create">Create new catref</a>

<table>
    @foreach ($catrefs as $catref)
    <tr>
        <td>
            <a href="/catrefs/{{ $catref->id }}">{{ $catref->title }}</a>
        </td>
        <td>
            <!-- delete the artist (uses the destroy method DESTROY /artists/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => 'catrefs/' . $catref->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this catref', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the artist (uses the show method found at GET /artists/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('catrefs/' . $catref->id) }}">Show this catref</a>

            <!-- edit this artist (uses the edit method found at GET /artists/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('catrefs/' . $catref->id . '/edit') }}">Edit this catref</a>
        </td>
    </tr>
    @endforeach

</table>
</ul>

@stop