@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')

<h1>{{ $artist->alias }} {{ $artist->meta_title }}</h1>
<p>{{ $artist->meta_description }}</p>
<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
    </ol>
    <div class="carousel-inner">
        @foreach ($artworks as $key => $artwork)
            <div class="item <?= ($key == 0 ? 'active' : '') ?>">
                <img src="/img/artists/{{ $artwork->artist->url_slug }}/{{ $artwork->id }}/{{ $artwork->artist->slug }}{{ $artwork->id }}.jpg" alt="{{ $artwork->title_short }}">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>{{ $artwork->title_short }}</h1>
                        <p>{{ $artwork->medium_short }}</p>
                        <p><a class="btn btn-lg btn-primary" href="/artworks/{{ $artwork->id }}" role="button">View Artwork</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div><!-- /.carousel -->

<div class="row">
    @foreach ($artworks as $key => $artwork)
        <div class="col-md-4">
            <a href="/artworks/{{ $artwork->id }}">
                @if (file_exists('img/artists/' . $artwork->artist->url_slug . '/' . $artwork->id . '/' . $artwork->artist->slug . $artwork->id . '.jpg'))
                    {{ HTML::image('img/artists/' . $artwork->artist->url_slug . '/' . $artwork->id . '/' . $artwork->artist->slug . $artwork->id . '.jpg') }}<br />
                {{ $artwork->title_short }}
                @else
                    {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artist->alias) }}<br />
                @endif
            </a>

            <b>{{ strip_tags($artwork->artist->alias . ' ' . $artwork->medium_short) }} for sale.</b>
            <i>{{ strip_tags($artwork->title_short) }}</i><br />
            ${{ number_format($artwork->price) }}


        </div>
    @endforeach
</div>

<div class="jumbotron text-center">
    <h1>{{ $artist->first_name }} {{ $artist->last_name }}</h1>
    <p>
        @if (file_exists($artist->img_url))
            {{ HTML::image($artist->img_url, 'Profile of ' . $artist->alias) }}<br />
        @else
            {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artist->alias) }}<br />
        @endif

        {{ $artist->meta_description }}

    </p>
</div>

@stop