@if (sizeof($artists) > 0)
    @foreach ($artists as $key => $artist)
    <div class="col-md-4 col-sm-4 artist">
        <div class="artist-img">
            <a href="{{ $artist->url() }}">
                {{ HTML::image($artist->img_url()) }}
            </a>
        </div>
        <h4><a href="{{ $artist->url() }}">{{ $artist->alias }}</a></h4>
    </div>
    @endforeach
@endif
