<ol class="breadcrumb">
    <li><a href="/" title="Fine art original prints"><span class="glyphicon glyphicon-home"></span></a></a></li>

    @if('artists.index' == Route::current()->getName() )
    <li class="active">BUY ORIGINALS</li>
    @endif

    @if('people.index' == Route::current()->getName() )
    <li class="active">PEOPLE</li>
    @endif

    @if('artists.show' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li class="active">{{ $artist->alias }}</li>
    @endif

    @if('people.show' == Route::current()->getName() )
    <li><a href="/people">PEOPLE</a></li>
    <li class="active">{{ $person->alias }}</li>
    @endif

    @if('artists.show.filter' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $artist->url() }}">{{ $artist->alias }}</a></li>
    <li class="active">{{ $filter }}</li>
    @endif

    @if('artists.show.bio' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $artist->url() }}">{{ $artist->alias }}</a></li>
    <li class="active">{{ $artist->alias }} Biography</li>
    @endif

    @if('artists.show.bio.page' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $artist->url() }}">{{ $artist->alias }}</a></li>
    <li class="active">{{ $post->post_title }}</li>
    @endif

    @if('artists.catalogues.index' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $catalogue->artist->url() }}">{{ $catalogue->artist->alias }}</a></li>
    <li class="active">{{ $catalogue->artist->alias }} Catalogue Raisonn&eacute;s</li>
    @endif

    @if('artists.catalogues.show' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $catalogue->artist->url() }}">{{ $catalogue->artist->alias }}</a></li>
    <li><a href="{{ $catalogue->artist->url() }}/bio/catalogue-raisonnes">Catalogue Raisonn&eacute;s</a></li>
    <li class="active">{{ $catalogue->title }}</li>
    @endif

    @if('artists.catrefs.show' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $catref->catalogue->artist->url() }}">{{ $catref->catalogue->artist->alias }}</a></li>
    <li><a href="{{ $catref->catalogue->artist->url() }}/bio/catalogue-raisonnes">Catalogue Raisonn&eacute;s</a></li>
    <li><a href="{{ $catref->catalogue->url() }}">{{ $catref->catalogue->title }}</a></li>
    <li class="active">{{ $catref->title }}</li>
    @endif

    @if('artworks.showOne' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $artwork->artist->url() }}">{{ $artwork->artist->alias }}</a></li>
    <li class="active">{{ $artwork->medium_short() }}</li>
    @endif

    @if('search.index' == Route::current()->getName() )
    <li class="active">Fine art search results for <b>{{ $q }}</b></li>
    @endif

</ol>
