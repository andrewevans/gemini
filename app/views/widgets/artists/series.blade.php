<div class="btn-group">
    @if (sizeof($artist->series()) > 0)
        <div>Series:</div>
        @foreach ($artist->series() as $filterBy)
        <button type="button" class="btn btn-default <?= ($filter_slug == $filterBy ? 'active' : '') ?>"><a href=" {{ $artist->url() . '/' . $filterBy }}">{{ $filterBy }}</a></button>
        @endforeach
    @endif
</div>

