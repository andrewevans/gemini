<div class="btn-group">
    @if (sizeof($artist->filters()) > 0)
        <span>Filter By:</span>
        @foreach ($artist->filters() as $filterBy)
        <button type="button" class="btn btn-default <?= (isset($filter_slug) && $filter_slug == $filterBy ? 'active' : '') ?>"><a href=" {{ $artist->url() . '/' . $filterBy }}">{{ $filterBy }}</a></button>
        @endforeach
    @endif
</div>