<?php $offset = 0; ?>
<div class="row">
    @if (sizeof($artworks) > 0)
        @foreach ($artworks as $key => $artwork)
        @if ($key % 3 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
        @if ($key == 0)
            <div class="col-md-4 col-lg-8 featured">
        @else
            <div class="col-md-4">
        @endif
            @if ($key % 11 == 0 && $key != 0 && $key != 11 && isset($posts) && isset($interrupt) && $interrupt)
                <div class="card blank">
                    @include('widgets.post', array('posts' => $posts, 'offset' => $offset++))
                </div>
            @else
                <div class="card">
                <figure>
                    <a href="{{ $artwork->url() }}" class="card-image">
                        @if ($key == 0)
                            {{ HTML::image($artwork->img_url()) }}
                        @else
                            <div class="zoom">
                                {{ HTML::image($artwork->img_url()) }}
                            </div>
                        @endif
                    </a>
                    <figcaption>
                        <a href="{{ $artwork->url() }}"><i>{{ strip_tags($artwork->title_short()) }}</i></a><br />
                        <a href="{{ $artwork->url() }}">{{ strip_tags($artwork->artist->alias) }}</a><br />
                        <a href="{{ $artwork->url() }}">{{ strip_tags($artwork->medium_short) }}</a><br />
                        ${{ number_format($artwork->price) }}
                    </figcaption>
                </figure>
                </div>
            @endif
        </div>
        @endforeach
    @else
        <div class="row">
            @if (isset($artist))
                <p>We don't have works to show by <b>{{ $artist->alias }}</b>, but please feel free to <a href="/contact">contact us</a> about works that you are looking for. We would be happy to look into it for you.</p>
            @else
                <p>We don't have works to show that match your search, but please feel free to <a href="/contact">contact us</a> about works that you are looking for. We would be happy to look into it for you.</p>
            @endif
        </div>
    @endif
</div>