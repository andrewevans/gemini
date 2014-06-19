<h2>Catalogues of {{ $artist->alias }}</h2>

@foreach ($artist->catalogues as $catalogue)
<div>
    <h2><a href="{{ $catalogue->url() }}">{{ $catalogue->title }}</a></h2>
</div>
@endforeach