@extends('layouts.default')
<!-- app/views/catrefs/show.blade.php -->

@section('content')

<div class="jumbotron text-center">
    <p>
        <a href="{{ "http://www.masterworksfineart.com/catalogue/chagall/sorlier/original/sorlier" . $catref->reference_num . ".jpg" }}">
            @if ($catref->catalogue->slug == "sorlier")
            {{ HTML::image("http://www.masterworksfineart.com/catalogue/chagall/sorlier/original/sorlier" . $catref->reference_num . ".jpg", 'Image of ' . $catref->title) }}<br />
            @else
            {{ HTML::image('img/no-image.jpg', 'No image available') }}<br />
            @endif
        </a>
    </p>

    <table class="table text-left">
        <tbody>
        <tr>
            <th>Artist</th><td> <b><a href="{{ $catref->catalogue->artist->url_slug }}">{{ $catref->catalogue->artist->last_name }}, {{ $catref->catalogue->artist->first_name }}</a></b></td>
        </tr>
        <tr>
            <th>Catalogue</th><td> {{ $catref->catalogue->title }}</td>
        </tr>
        <tr>
            <th>Reference #</th><td> {{ $catref->reference_num }}</td>
        </tr>
        <tr>
            <th>Title</th><td> {{ $catref->title }}</td>
        </tr>
        <tr>
            <th>Size</th><td> {{ $catref->size }}</td>
        </tr>
        <tr>
            <th>Edition</th><td> {{ $catref->edition }}</td>
        </tr>
        <tr>
            <th>Medium</th><td> {{ $catref->medium }}</td>
        </tr>
        <tr>
            <th>Signature</th><td> {{ $catref->signed }}</td>
        </tr>
        </tbody>
    </table>

    </p>
</div>
@stop