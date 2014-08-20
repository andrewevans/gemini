<?php $offset = 0; ?>
<div class="row">
    @if (sizeof($artworks) > 0)
        @foreach ($artworks as $key => $artwork)
            <div class="col-md-3 col-sm-4 artworks <?= ($artwork->magnitude > 0 ? 'mag' : '') ?>">
                <div class="card plain card-sm">
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
                        <a href="{{ $artwork->url() }}">{{ substr(strip_tags($artwork->artist->alias), 0, 65) }}</a><br />
                        <a href="{{ $artwork->url() }}">{{ substr(strip_tags($artwork->medium_short), 0, 65) }}</a><br />
                        ${{ number_format($artwork->price) }}
                    </figcaption>
                </figure>
                </div>
        </div>
        @endforeach
    @endif
</div>