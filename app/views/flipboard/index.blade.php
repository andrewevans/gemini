@extends('layouts.flipboard')

@section('title') Login @stop

@section('content')

@if ($artist != null && sizeof($artworks) > 0)
@foreach ($artworks as $key => $artwork)

    <div class="f-page">
        <div class="f-title">
            <a href="/offline/flipboard{{ $get_vars }}">
                <div class="f-cover-back">&lt; Back to Artists</div>
            </a>
            <h2>Masterworks Fine Art Gallery</h2>
            <a href="">Contact us!</a>
        </div>
        <div class="box w-100 h-100">
            <div class="img-cont"><img src="{{ $artwork->img_url() }}" data-src="{{ $artwork->img_url() }}" /> </div>

            <div class="img-text">
                <h3>{{ strtoupper($artwork->artist->alias) }}<br /> {{ $artwork->title }} <span>{{ $artwork->medium_short() }}</span></h3>
                <p>{{ $artwork->signature }}
                    {{ $artwork->edition }}</p>
                <p>item #{{ $artwork->id }}</p>

                <div class="f-cover-back f-cover-click" style="width: 350px">&star; Click to Read More&hellip;</div>
                <div class="img-desc">
                    <img src="{{ $artwork->img_url() }}" data-src="{{ $artwork->img_url() }}" />
                    <div>&nbsp;</div>
                    {{ $artwork->description }}
                </div>
            </div>
        </div>
        <div class="f-cover-flip">&lt; Flip</div>
    </div>

@endforeach

@if (($artworks_size - $skip - PAGINATION_NUM) > 0)
<div class="f-page f-cover-back">
    <div id="codrops-ad-wrapper">
        <a href="/offline/flipboard/{{ $artist->url_slug }}/{{ $skip+PAGINATION_NUM-1 }}?page=1">Show more</a>
    </div>
</div>
@else
<div class="f-page f-cover-back">
    <div id="codrops-ad-wrapper">
        <a href="/offline/flipboard{{ $get_vars }}">Back to Artist List</a>
    </div>
</div>

@endif

@else

@for ($page_num = 0; $page_num * PAGINATION_NUM_ARTISTS < (sizeof($artists)); $page_num++)
    @include('partial/flipboard/page-artists', ['artists' => $artists, 'page_num' => $page_num])
@endfor

<div class="f-page">
    <div class="f-title">
        <a href="/offline/flipboard{{ $get_vars }}">
            <div class="f-cover-back">&lt; Back to Artists</div>
        </a>
        <h2>Masterworks Fine Art Gallery</h2>
        <a href="">Contact us!</a>
    </div>
    <div class="box w-100 h-100">


    </div>
</div>
@endif

</div>

@stop