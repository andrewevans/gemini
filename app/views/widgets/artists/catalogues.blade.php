@if (sizeof($artist->catalogues) > 0)
<h2><span class="fa fa-book"></span> Catalogues of {{ $artist->alias }}</h2>

<ul>
    @foreach ($artist->catalogues as $catalogue)
        <li><a href="{{ $catalogue->url() }}">{{ $catalogue->title }}</a></li>
    @endforeach
</ul>

<div class="read-more">
    <a href="/artists/{{ $artist->url_slug }}/bio/catalogue-raisonnes">{{ $artist->alias }} Catalogue Raisonn&eacute;s  &thinsp;&raquo;</a>
</div>
@endif