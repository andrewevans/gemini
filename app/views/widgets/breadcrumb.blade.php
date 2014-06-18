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
    <li class="active">{{ $artwork->artist->alias }}</li>
    @endif

    @if('people.show' == Route::current()->getName() )
    <li><a href="/artists">PEOPLE</a></li>
    <li class="active">{{ $person->alias }}</li>
    @endif

    @if('artists.show.filter' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $artwork->artist->url() }}">{{ $artwork->artist->alias }}</a></li>
    <li class="active">{{ $filter }}</li>
    @endif

    @if('artworks.showOne' == Route::current()->getName() )
    <li><a href="/artists">BUY ORIGINALS</a></li>
    <li><a href="{{ $artwork->artist->url() }}">{{ $artwork->artist->alias }}</a></li>
    <li class="active">{{ $artwork->mediums() }}</li>
    @endif

    @if('search.index' == Route::current()->getName() )
    <li class="active">Fine art search results for <b>{{ $q }}</b></li>
    @endif

</ol>
