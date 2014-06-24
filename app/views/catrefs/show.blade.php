@extends('layouts.default')
<!-- app/views/catrefs/show.blade.php -->

@section('content')

<div class="jumbotron text-center card-details">

    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <figure>
                @if ($catref->catalogue->slug == "sorlier")
                {{ HTML::image("http://www.masterworksfineart.com/catalogue/chagall/sorlier/original/sorlier" . $catref->reference_num . ".jpg", 'Image of ' . $catref->title) }}<br />
                @else
                {{ HTML::image('img/no-image.jpg', 'No image available') }}<br />
                @endif
                <figcaption>
                    <i>{{ $catref->title }}</i>, {{ $catref->catalogue->artist->alias }}, from {{ $catref->catalogue->title }}
                </figcaption>

            </figure>

        </div>
        <div class="col-md-4">
            <table class="table text-left catref specs">
                <tbody>
                <tr>
                    <th>Artist</th><td> <b><a href="{{ $catref->catalogue->artist->url_slug }}">{{ $catref->catalogue->artist->last_name }}, {{ $catref->catalogue->artist->first_name }}</a></b></td>
                </tr>
                <tr>
                    <th>Title</th><td> {{ $catref->title }}</td>
                </tr>
                <tr>
                    <th>Catalogue</th><td> {{ $catref->catalogue->title }}</td>
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


    <div class="row">
        <h2>Currently in our gallery</h2>
        @foreach ($artworks as $key => $artwork)
        <div class="col-md-4 card">
            <a href="{{ $artwork->url() }}">
                @if (file_exists('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg'))
                {{ HTML::image('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg') }}<br />
                @else
                {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artwork->artist->alias) }}<br />
                @endif
            </a>

            <b>{{ strip_tags($artwork->artist->alias . ' ' . $artwork->medium_short) }} for sale.</b>
            <i>{{ strip_tags($artwork->title_short()) }}</i><br />
            ${{ number_format($artwork->price) }}


        </div>
        @endforeach
    </div>

    @include('widgets.artists.artist', array('artist' => $catref->catalogue->artist))

</div>
@stop