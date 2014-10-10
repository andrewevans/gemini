<div class="f-page">
    <div class="f-title">
        <a href="/offline/flipboard{{ $get_vars }}">
            <div class="f-cover-back">&lt; Back to Artists</div>
        </a>
        <h2>Masterworks Fine Art Gallery</h2>
        <a href="">Contact us!</a>
    </div>
    <div class="box w-100 h-100">
        <ul class="artist-list">
            @foreach ($artists as $key => $artist_each)
            <?php
            if (($key) < ($page_num * PAGINATION_NUM_ARTISTS)) continue;
            if ($key > (($page_num + 1) * PAGINATION_NUM_ARTISTS) - 1) break;
            ?>
            <li><a href="/offline/flipboard/{{ $artist_each->url_slug }}?page=1" style="background-image: url({{ $artist_each->cover_img_url() }}); background-size: cover; background-position-y: 0%; background-position: center center; box-shadow: inset 0 0 0 1000px rgba(0,0,0,.3);"><div>{{ $artist_each->alias }}</div></a></li>
            @endforeach
        </ul>
    </div>
    <div class="f-cover-flip">&lt; Flip</div>
</div>
