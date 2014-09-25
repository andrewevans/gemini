<div class="f-page">
    <div class="f-title">
        <a href="/offline/flipboard">Back to cover</a>
        <h2>Masterworks Fine Art Gallery</h2>
        <a href="">Contact us!</a>
    </div>
    <div class="box w-100 h-100">
        <ul class="artist-list">
            @foreach ($artists as $key => $artist_each)
            <?php
            if (($key) < ($page_num * 21)) continue;
            if ($key > (($page_num + 1) * 21) - 1) break;
            ?>
            <li><a href="/offline/flipboard/{{ $artist_each->url_slug }}">{{ $artist_each->alias }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
