@extends('layouts.default')

@section('title') Login @stop

@section('content')

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
        <?php $count = 0; ?>
        @foreach ($artworks as $key => $artwork)
        <div class="item <?= ($key == 0 ? 'active' : '') ?>">
            @if (file_exists('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg'))
            {{ HTML::image('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg') }}
            @else
            {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artwork->artist->alias) }}<br />
            @endif
            <div class="container">
                <div class="carousel-caption">
                    <h1>{{ $artwork->title_short() }}</h1>
                    <p>{{ $artwork->medium_short() }}</p>
                    <p><a class="btn btn-lg btn-primary" href="/artworks/{{ $artwork->id }}" role="button">View Artwork</a></p>
                </div>
            </div>
        </div>
        <?php
        $count++;
        if ($count > 3) break;
        ?>

        @endforeach
    </div>

    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div><!-- /.carousel -->

<div class="row">
    @foreach ($artworks as $key => $artwork)
    <div class="col-md-4">
        <a href="/artworks/{{ $artwork->id }}">
            @if (file_exists('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg'))
            {{ HTML::image('img/artists/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg') }}<br />
            @else
            {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artwork->artist->alias) }}<br />
            @endif
        </a>
        {{ $artwork->title_short }}

        <b>{{ strip_tags($artwork->artist->alias . ' ' . $artwork->medium_short) }} for sale.</b>
        <i>{{ strip_tags($artwork->title_short()) }}</i><br />
        ${{ number_format($artwork->price) }}


    </div>
    @endforeach
</div>

<div class="jumbotron text-center">
    @foreach ($artists as $artist)
        <h1>{{ $artist->first_name }} {{ $artist->last_name }}</h1>
        <p>
            @if (file_exists($artist->img_url))
            {{ HTML::image($artist->img_url, 'Profile of ' . $artwork->artist->alias) }}<br />
            @else
            {{ HTML::image('img/no-image.jpg', 'Profile of ' . $artwork->artist->alias) }}<br />
            @endif

            {{ $artist->meta_description }}

        </p>
    @endforeach
</div>

@stop