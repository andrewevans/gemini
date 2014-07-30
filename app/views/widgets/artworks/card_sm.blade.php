<?php $offset = 0; ?>
<div class="row">
    @if (sizeof($artworks) > 0)
        @foreach ($artworks as $key => $artwork)
        @if ($key % 4 == 0 && $key != 0)
            </div>
            <div class="row">
        @endif
            <div class="col-md-3 artworks <?= ($artwork->magnitude > 0 ? 'mag' : '') ?>">
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
                        <a href="{{ $artwork->url() }}"><i>{{ strip_tags($artwork->title_short()) }}</i></a><br />
                        <a href="{{ $artwork->url() }}">{{ strip_tags($artwork->artist->alias) }}</a><br />
                        <a href="{{ $artwork->url() }}">{{ strip_tags($artwork->medium_short) }}</a><br />
                        ${{ number_format($artwork->price) }}
                    </figcaption>
                </figure>
                </div>
        </div>
        @endforeach
    @endif
</div>