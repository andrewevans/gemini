@extends('layouts.flipboard')

@section('title') Login @stop

@section('content')

@foreach ($artworks as $key => $artwork)

    <div class="f-page">
        <div class="f-title">
            <a href="/offline/flipboard">Back to cover</a>
            <h2>Masterworks Fine Art Gallery</h2>
            <a href="">Contact us!</a>
        </div>
        <div class="box w-100 h-100">
            <div class="img-cont"><img src="{{ $artwork->img_url() }}" data-src="{{ $artwork->img_url() }}" /> </div>

            <div class="img-text">
                <h3>{{ strtoupper($artwork->artist->alias) }}<br /> {{ $artwork->title }} <span>{{ $artwork->medium_short() }}</span></h3>
                <p>{{ $artwork->signed }}<br />
                    {{ $artwork->edition }}</p>
            </div>
        </div>
    </div>

@endforeach


<div class="f-page f-cover-back">
    <div id="codrops-ad-wrapper">
        <a href="?skip={{ $skip+15 }}&page=1">Show more</a>
    </div>
</div>
</div>

@stop