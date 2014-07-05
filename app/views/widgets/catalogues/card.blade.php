<div class="row">
        @foreach ($catalogues as $key => $catalogue)
        @if ($key % 3 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
        <div class="col-md-3 card">
                    <a href="{{ $catalogue->url() }}"><i>{{ strip_tags($catalogue->title) }}</i></a><br />
                    <a href="{{ $catalogue->url() }}"><i>{{ strip_tags($catalogue->artist->alias) }}</i></a><br />
        </div>
        @endforeach
</div>