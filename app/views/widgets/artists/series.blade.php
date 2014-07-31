<div class="btn-group">
    @if (sizeof($artist->series()) > 0)
        <span>Series:</span>
        @foreach ($artist->series() as $filterBy)
        <a href=" {{ $artist->url() . '/' . $filterBy }}"><button type="button" class="btn btn-default <?= ($filter_slug == $filterBy ? 'active' : '') ?>">{{ $filterBy }}</button></a>
        @endforeach
    @endif
</div>

