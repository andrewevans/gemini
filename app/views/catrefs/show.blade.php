@extends('layouts.default')
<!-- app/views/catrefs/show.blade.php -->

@section('content')

<div class="jumbotron text-center card-details">

    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <figure>
                {{ HTML::image($catref->img_url()) }}
                <figcaption>
                    <i>{{ $catref->title }}</i>, {{ $catref->catalogue->artist->alias }}, from {{ $catref->catalogue->title }}
                </figcaption>

            </figure>

        </div>
        <div class="col-md-4">
            <table class="table text-left catref specs">
                <tbody>
                <tr>
                    <th>Artist</th><td> <b><a href="{{ $catref->catalogue->artist->url() }}">{{ $catref->catalogue->artist->last_name }}, {{ $catref->catalogue->artist->first_name }}</a></b></td>
                </tr>
                <tr>
                    <th>Title</th><td> {{ $catref->title }}</td>
                </tr>
                <tr>
                    <th>Catalogue</th><td> <a href="{{ $catref->catalogue->url() }}">{{ $catref->catalogue->title }}</a></td>
                </tr>
                <tr>
                    <th>Reference #</th><td> {{ $catref->reference_num }}</td>
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

        </div>
    </div>
</div>


<div class="container">
    <h2>Currently in our gallery</h2>
    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

@include('widgets.artists.artist', array('artist' => $catref->catalogue->artist))

@stop