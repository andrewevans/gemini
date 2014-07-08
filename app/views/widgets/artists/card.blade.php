<div class="row">
        @foreach ($artists as $key => $artist)
        @if ($key % 3 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
            @if ($key == 0)
                <div class="col-md-4 col-lg-8 featured">
            @else
                <div class="col-md-4">
            @endif
            <div class="card">
            <figure>
                <a href="{{ $artist->url() }}" class="card-image">
                    {{ HTML::image($artist->img_url()) }}
                </a>
                <figcaption>
                    <a href="{{ $artist->url() }}"><i>{{ strip_tags($artist->alias) }}</i></a><br />
                </figcaption>
            </figure>
            </div>
        </div>
        @endforeach
</div>