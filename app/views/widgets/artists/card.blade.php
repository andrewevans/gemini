<div class="row">
        @foreach ($artists as $key => $artist)
        @if ($key % 6 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
            @if ($key < 6)
                <div class="col-md-2 artists col-lg-4 featured">
            @else
                <div class="col-md-2 artists">
            @endif
            <div class="card">
            <figure>
                <a href="{{ $artist->url() }}" class="card-image">
                    {{ HTML::image($artist->img_url()) }}
                </a>
                <figcaption>
                    <a href="{{ $artist->url() }}">{{ $artist->inverted_alias() }}</a><br />
                </figcaption>
            </figure>
            </div>
        </div>
        @endforeach
</div>