<?php $offset = 0; ?>
<div class="row">
    @if (sizeof($artworks) > 0)
        @foreach ($artworks as $key => $artwork)
        @if ($key == 0 && sizeof($artworks) >= 6)
            <div class="col-md-4 col-lg-8 artworks featured <?= ($artwork->magnitude > 0 ? 'mag' : '') ?>">
        @else
            <div class="col-md-4 col-sm-6 artworks <?= ($artwork->magnitude > 0 ? 'mag' : '') ?>">
        @endif
            @if ($key % 11 == 0 && $key != 0 && $key != 11 && isset($posts) && isset($interrupt) && $interrupt)
                <div class="card blank">
                    @include('widgets.post', array('posts' => $posts, 'offset' => $offset++))
                </div>
            @else
                <div class="card">
                <figure>
                    <a href="{{ $artwork->url() }}" class="card-image">
                        @if ($key == 0 && sizeof($artworks) >= 6)
                            {{ HTML::image($artwork->img_url()) }}
                        @else
                            <div class="zoom">
                                {{ HTML::image($artwork->img_url()) }}
                            </div>
                        @endif
                    </a>
                    <figcaption>
                        <a href="{{ $artwork->url() }}"><i>{{ substr(strip_tags($artwork->title_short()), 0, 65) }}</i></a><br />
                        <a href="{{ $artwork->url() }}">{{ substr(strip_tags($artwork->medium_short), 0, 65) }}</a><br />
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
            @endif
        </div>
    @endif
</div>