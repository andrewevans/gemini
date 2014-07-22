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
        <div class="item active">
            <div class="color-text" style="cursor: pointer;">
                <div class="ttl" style="position: relative; top: 0px; opacity: 1;">
                    <h1>Pablo Picasso</h1>
                    <h2>It is your work in life that is the ultimate seduction.</h2>
                    <p>Picasso revolutionized the art world and to many is THE artist of the 20th century. He is famous for his role in pioneering Cubism with Georges Braque and for his melancholy Blue Period pieces.</p>
                </div>
                <a href="#">
                    <span>
                        View All
                    </span>
                </a>
                <a href="#">
                    <span>
                         | Ceramics
                    </span>
                </a>
                <a href="#">
                    <span>
                         | Linocuts
                    </span>
                </a>
            </div>

            <img src="http://www.masterworksfineart.com/images/splashes/picasso-jacqueline-for-sale.jpg">                                <div class="container">
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
    @include('widgets.artworks.card', array('artworks' => $artworks))
</div>

<div class="container">
    @include('widgets.artists.card', array('artists' => $artists))
</div>


<div class="row">
    <div class="col-md-5 col-md-offset-1">
        @include('widgets.pages', array('filter' => 'homepage'))
    </div>
    <div class="col-md-5">
        @include('widgets.posts', array('filter' => 'homepage'))
    </div>
</div>

<div class="container">
    <h3>Previously viewed Artworks</h3>

    @include('widgets.artworks.card', array('artworks' => $artworks_previous))
</div>

<div class="container">
    <h3>Previously viewed Artists</h3>

    @include('widgets.artists.card', array('artists' => $artists_previous))
</div>

@stop
