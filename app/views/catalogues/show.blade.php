@extends('layouts.default')
<!-- app/views/catalogues/show.blade.php -->

@section('content')

<div class="container">
    <div class="intro-header" style="text-align: center; max-width:450px;"> <i class="sprite-h gtitle-deco above"></i>
        <h1>{{ $page_title }}</h1>
        <p>{{ $catalogue->meta_description }}</p>
    </div>
</div>

<div class="row">
    @foreach ($catrefs as $key => $catref)
    <div class="col-md-4">
        <a href="{{ $catref->url() }}">
            @if ($catref->catalogue->slug == "sorlier")
            {{ HTML::image("http://www.masterworksfineart.com/catalogue/chagall/sorlier/original/sorlier" . $catref->reference_num . ".jpg", 'Image of ' . $catref->title) }}<br />
            @else
            {{ HTML::image('img/no-image.jpg', 'No image available') }}<br />
            @endif
        </a>
        {{ $catref->title }}

        <i>{{ strip_tags($catref->meta_description) }}</i><br />


    </div>
    @endforeach
</div>

@stop