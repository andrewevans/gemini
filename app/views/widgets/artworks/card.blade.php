<div class="row">
    @if (sizeof($artworks) > 0)
        @foreach ($artworks as $key => $artwork)
        @if ($key % 3 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
        <div class="col-md-3 card">
            <figure>
                <a href="{{ $artwork->url() }}" class="card-image">
                    {{ HTML::image($artwork->img_url()) }}
                </a>
                <figcaption>
                    <a href="{{ $artwork->url() }}"><i>{{ strip_tags($artwork->title_short()) }}</i></a><br />
                    <a href="{{ $artwork->url() }}">{{ strip_tags($artwork->artist->alias) }}</a><br />
                    <a href="{{ $artwork->url() }}">{{ strip_tags($artwork->medium_short) }}</a><br />
                    ${{ number_format($artwork->price) }}
                </figcaption>
            </figure>
        </div>
        @endforeach
    @else
        <div class="row">
            <p>We don't have works to show by <b>{{ $artist->alias }}</b>, but please feel free to <a href="/contact">contact us</a> about works that you are looking for. We would be happy to look into it for you.</p>
        </div>
    @endif
</div>