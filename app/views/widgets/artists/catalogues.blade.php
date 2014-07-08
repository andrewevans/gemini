@if (sizeof($artist->catalogues) > 0)
<h2><span class="fa fa-book"></span> Catalogues of {{ $artist->alias }}</h2>

@foreach ($artist->catalogues as $catalogue)
<div>
    <h3><a href="{{ $catalogue->url() }}">{{ $catalogue->title }}</a></h3>
</div>
@endforeach

<div>
    <a href="/artists/{{ $artist->url_slug }}/bio/catalogue-raisonnes">{{ $artist->alias }} Catalogue Raisonn&eacute;s</a>
</div>
@endif