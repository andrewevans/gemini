@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<div class="container">
    <h1>{{ $artwork->artist->alias }}, <i>{{ $artwork->title }}</i></h1>
</div>

<div class="container">
<div class="jumbotron text-center">

    <a name="imageStage" id="imageStage"></a>
    <div class="eachDetailBig">
        <div class="picContainer">

            <div class="imageStage">
                <a href="{{ $artwork->url() }}" style="display:inline-block;">
                    <img src="{{ $artwork->img_url() }}" alt="{{ $artwork->page_title() }}" name="swap" id="swap" />
                </a>
            </div>
        </div>
    </div>

    <a href="#imageStage" onmouseover="MM_swapImage('swap','','{{ $artwork->img_url() }}',1)" class="img-av">
        <img src="{{ $artwork->img_url() }}" class="img-av" alt="{{ $artwork->page_title() }} (image 1)" />
    </a>

    @for ($img_count = 2; $artwork->img_url(null, $img_count) != '/img/no-image.jpg'; $img_count++)

        <a href="#imageStage" onmouseover="MM_swapImage('swap','','{{ $artwork->img_url(null, $img_count) }}',1)" class="img-av">
            <img src="{{ $artwork->img_url(null, $img_count) }}" class="img-av" alt="{{ $artwork->page_title() }} (image 2)" />
        </a>
    @endfor

    <style type="text/css">
        @media (min-width: 768px) {
        .eachDetailBig .picContainer {
            height: {{ $container_height + 15 }}px;
            max-height: {{ $container_height + 15 }}px;
        }
        .eachDetailBig .picContainer table {}
        }
    </style>


    <div class="container">

    <table class="table text-left">
        <tbody>
        <tr>
            <th>Artist</th><td>
                <b><a href="{{ $artwork->artist->url() }}">{{ $artwork->artist->first_name }} {{ $artwork->artist->last_name }}</a></b>
                @if ($artwork->after != '')
                    <span class="artwork-after">({{ $artwork->after }})</span>
                @endif
        </td>
        </tr>
        <tr>
            <th>Title</th><td> {{ $artwork->title }}</td>
        </tr>
        @if ($artwork->reference != '')
        <tr>
            <th>Reference</th><td> {{ $artwork->reference }}</td>
        </tr>
        @endif
        @if ($artwork->medium != '')
        <tr>
            <th>Medium</th><td> {{ $artwork->medium }}</td>
        </tr>
        @endif
        @if ($artwork->series != '')
        <tr>
            <th>Series</th><td> {{ $artwork->series }}</td>
        </tr>
        @endif
        @if ($artwork->edition != '')
        <tr>
            <th>Edition</th><td> {{ $artwork->edition }}</td>
        </tr>
        @endif
        @if ($artwork->signature != '')
        <tr>
            <th>Signature</th><td> {{ $artwork->signature }}</td>
        </tr>
        @endif
        @if ($artwork->condition != '')
        <tr>
            <th>Condition</th><td> {{ $artwork->condition }}</td>
        </tr>
        @endif
        @if ($artwork->size_img != ''
        || $artwork->size_sheet != ''
        || $artwork->size_framed != '')
        <tr>
            <th>Size</th>
            <td>
                @if ($artwork->size_img != '')
                    Image: {{ $artwork->size_img }}.
                @endif
                @if ($artwork->size_sheet != '')
                    Sheet: {{ $artwork->size_sheet }}.
                @endif
                @if ($artwork->size_framed != '')
                    Framed: {{ $artwork->size_framed }}.
                @endif
            </td>
        </tr>
        @endif
        <tr>
            <th>Gallery Price</th>
            <td>
                {{ $artwork->price_box() }}
                @if ($artwork->tagline != '')
                    <span class="artwork-tagline">{{ $artwork->tagline }}</span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    </div>

</div>

    <div class="container">
        <div class="col-md-8">
            <div class="paper">
                <div class="share-btns">
                    @include('widgets.share', array('artwork' => $artwork))
                </div>

                @if ($artwork->artwork_description != null)
                    {{ $artwork->artwork_description }}
                @else
                    <p>We do not currently have a description for this work.</p>
                @endif

                <div class="share-btns">
                    @include('widgets.share', array('artwork' => $artwork))
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @include('widgets.about')
        </div>

    </div>

</div>

@if (! Config::get('app.gemini_lite'))
<div class="container">
    <h3>Related Artworks</h3>

    @include('widgets.artworks.card_sm', array('artworks' => $artworks_related))
</div>
@endif

@if (! Config::get('app.gemini_lite'))
<div class="container">
    <h3>Previously viewed Artworks</h3>

    @include('widgets.artworks.card_sm', array('artworks' => $artworks_previous))
</div>

@endif

@stop