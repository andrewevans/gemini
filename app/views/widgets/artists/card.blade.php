<div class="row">
        @foreach ($artists as $key => $artist)
        @if ($key % 3 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
        <div class="col-md-3">
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