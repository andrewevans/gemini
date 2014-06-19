@extends('layouts.default')
<!-- app/views/catalogues/index.blade.php -->

@section('content')

<table>
    @foreach ($catalogues as $catalogue)
    <tr>
        <td>
            <a href="{{ $catalogue->url() }}">{{ $catalogue->title }}</a>
        </td>
        <td>


            <!-- delete the artist (uses the destroy method DESTROY /artists/{id} -->
            <!-- we will add this later since its a little more complicated than the other two buttons -->
            {{ Form::open(array('url' => 'catalogues/' . $catalogue->id, 'class' => 'pull-right')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete this catalogue', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}

            <!-- show the artist (uses the show method found at GET /artists/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to($catalogue->url()) }}">Show this catalogue</a>

            <!-- edit this artist (uses the edit method found at GET /artists/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('catalogues/' . $catalogue->id . '/edit') }}">Edit this catalogue</a>
        </td>
    </tr>
    @endforeach

</table>
</ul>

@stop