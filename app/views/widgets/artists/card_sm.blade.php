@if (sizeof($artists) > 0)
    @foreach ($artists as $key => $artist)
    <div class="col-md-4 post">
        <div class="post-img">
            {{ HTML::image($artist->img_url()) }}
        </div>
        <h4><a href="{{ $artist->url() }}">{{ $artist->alias }}</a></h4>
    </div>
    @endforeach
@endif
