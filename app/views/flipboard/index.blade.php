@extends('layouts.flipboard')

@section('title') Login @stop

@section('content')

@if ($artist != null && sizeof($artworks) > 0)
@foreach ($artworks as $key => $artwork)

    <div class="f-page">
        <div class="f-title">
            <a href="/offline/flipboard{{ $get_vars }}">Back to cover</a>
            <h2>Masterworks Fine Art Gallery</h2>
            <a href="">Contact us!</a>
        </div>
        <div class="box w-100 h-100">
            <div class="img-cont"><img src="{{ $artwork->img_url() }}" data-src="{{ $artwork->img_url() }}" /> </div>

            <div class="img-text">
                <h3>{{ strtoupper($artwork->artist->alias) }}<br /> {{ $artwork->title }} <span>{{ $artwork->medium_short() }}</span></h3>
                <p>{{ $artwork->signature }}<br />
                    This is from an edition.</p>
                <p>item #{{ $artwork->id }}</p>

                <div class="img-desc">
                    <p>Pug freegan DIY, bicycle rights kogi cardigan biodiesel flannel keffiyeh sustainable 8-bit small batch twee flexitarian Schlitz. Bespoke chambray keytar Bushwick seitan 3 wolf moon selvage hella stumptown, Tonx synth quinoa locavore. Letterpress sartorial beard, Brooklyn gluten-free deep v Wes Anderson viral. Blog chambray freegan put a bird on it Portland cred, Shoreditch you probably haven't heard of them flexitarian quinoa Etsy. Occupy farm-to-table Odd Future pickled, viral fingerstache DIY gastropub craft beer art party Echo Park before they sold out. Polaroid sartorial Pitchfork banh mi McSweeney's. You probably haven't heard of them artisan Neutra plaid, jean shorts fixie Schlitz raw denim umami iPhone gentrify.</p>
                    <p>Banh mi actually Intelligentsia crucifix pickled literally. +1 Tumblr flannel, Pitchfork wayfarers pop-up trust fund aesthetic cred vinyl Godard tousled. Quinoa PBR church-key, occupy locavore bespoke salvia. Next level fap mustache, organic art party chambray slow-carb. Marfa chia Brooklyn wayfarers fixie. Carles cred PBR&B Pinterest, Intelligentsia Pitchfork pork belly cliche brunch Vice occupy. Semiotics vegan fashion axe heirloom occupy cornhole.</p>

                    <p><b>Catalogue Raisonné & COA:</b></p>
                    <p>A Certificate of Authenticity will accompany this work.</p>
                </div>
            </div>
        </div>
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

@for ($page_num = 0; $page_num * 21 < (sizeof($artists)); $page_num++)
    @include('partial/flipboard/page-artists', ['artists' => $artists, 'page_num' => $page_num])
@endfor

<div class="f-page">
    <div class="f-title">
        <a href="/offline/flipboard{{ $get_vars }}">Back to cover</a>
        <h2>Masterworks Fine Art Gallery</h2>
        <a href="">Contact us!</a>
    </div>
    <div class="box w-100 h-100">


    </div>
</div>
@endif

</div>

@stop