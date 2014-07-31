<div class="btn-group">
    @if (sizeof($artist->filters()) > 0)
        <span>Filter By:</span>
        @foreach ($artist->filters() as $filterBy)
        <a href=" {{ $artist->url() . '/' . $filterBy }}"><button type="button" class="btn btn-default <?= (isset($filter_slug) && $filter_slug == $filterBy ? 'active' : '') ?>">{{ $filterBy }}</button></a>
        @endforeach
    @endif
</div>