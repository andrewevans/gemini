@extends('layouts.default')
<!-- app/views/artists/show.blade.php -->

@section('content')
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
        <div class="item active">
            <div class="color-text" style="cursor: pointer;">
                <div class="ttl" style="position: relative; top: 0px; opacity: 1;">
                    <h1>Pablo Picasso</h1>
                    <h2>It is your work in life that is the ultimate seduction.</h2>
                    <p>Picasso revolutionized the art world and to many is THE artist of the 20th century. He is famous for his role in pioneering Cubism with Georges Braque and for his melancholy Blue Period pieces.</p>
                </div>
                <a href="/artists/pablo-picasso">
                    <span>
                        View All
                    </span>
                </a>
                <a href="/artists/pablo-picasso/ceramics">
                    <span>
                         | Ceramics
                    </span>
                </a>
                <a href="/artists/pablo-picasso/linocuts">
                    <span>
                         | Linocuts
                    </span>
                </a>
            </div>

            <a href="/artists/pablo-picasso">
                <img src="http://www.masterworksfineart.com/images/splashes/picasso-jacqueline-for-sale.jpg">
            </a>

                <div class="container">
                <div class="carousel-caption">
                </div>
            </div>
        </div>

        <?php $count = 1; ?>
        @foreach ($artworks as $key => $artwork)
            <div class="item <?= ($key == -1 ? 'active' : '') ?>">
                {{ HTML::image($artwork->img_url()) }}
                <div class="container">
                    <div class="carousel-caption">
                        <h1>{{ $artwork->title_short() }}</h1>
                        <p>{{ $artwork->medium_short() }}</p>
                        <p><a class="btn btn-lg btn-primary" href="{{ $artwork->url() }}" role="button">View Artwork</a></p>
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

<div class="container">
<div class="intro-header" style="text-align: center; max-width:450px;"> <i class="sprite-h gtitle-deco above"></i>
    <h1>{{ $page_title }}</h1>
    <p>{{ $artist->meta_description }} <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }}</a></p>
</div>
</div>

<div class="container">
    @include('widgets.artists.filters', array('artist' => $artist))
    @include('widgets.artists.series', array('artist' => $artist))
    @include('widgets.filters.list', array('artist' => $artist))

</div>

<div class="container">
    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

@include('widgets.artists.artist', array('artist' => $artist))

@stop