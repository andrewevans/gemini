<div class="row">
    @if (sizeof($catrefs) > 0))
        @foreach ($catrefs as $key => $catref)
            @if ($key % 3 == 0 && $key != 0)
                </div>
                <div class="row">
            @endif
            <div class="col-md-3 card">
                <figure>
                    <a href="{{ $catref->url() }}" class="card-image">
                        {{ HTML::image($catref->img_url()) }}<br />
                    </a>
                    <figcaption>
                        <a href="{{ $catref->url() }}"><i>{{ strip_tags($catref->title) }}</i></a><br />
                        <a href="{{ $catref->url() }}">{{ strip_tags($catref->catalogue->artist->alias) }}</a><br />
                        <a href="{{ $catref->url() }}">{{ strip_tags($catref->catalogue->title) }}</a><br />
                        <a href="{{ $catref->url() }}">Reference: {{ strip_tags($catref->reference_num) }}</a><br />
                        <a href="{{ $catref->url() }}">{{ strip_tags($catref->medium) }}</a><br />
                    </figcaption>
                </figure>
            </div>
        @endforeach
    @else
        <div class="row">
            <p>We don't have catalogue references for this artist, but please feel free to <a href="/contact">contact us</a> about works that you are looking for. We would be happy to look into it for you.</p>
        </div>
    @endif

</div>