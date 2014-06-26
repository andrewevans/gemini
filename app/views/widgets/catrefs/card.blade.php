<div class="row">
    @foreach ($catrefs as $key => $catref)
        @if ($key % 3 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
        <div class="col-md-3 card">
            <figure>
                <a href="{{ $catref->url() }}" class="card-image">
                    @if ($catref->catalogue->slug == "sorlier")
                    {{ HTML::image('http://www.masterworksfineart.com/catalogue/' . $catref->catalogue->artist->slug . '/' . $catref->catalogue->slug . '/original/' . $catref->catalogue->slug . $catref->reference_num . '.jpg') }}<br />
                    @elseif (file_exists($catref->img_url()))
                    {{ HTML::image($catref->img_url()) }}<br />
                    @else
                    {{ HTML::image('img/no-image.jpg', 'Profile of ' . $catref->catalogue->artist->alias) }}<br />
                    @endif
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
</div>