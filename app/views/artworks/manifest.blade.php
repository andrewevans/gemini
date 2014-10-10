CACHE MANIFEST

# Build 2014-09-08 003 002

CACHE:
/favicon.ico
/vendor/flipboard/js/jquery.tmpl.min.js
/vendor/flipboard/js/jquery.history.js
/vendor/flipboard/js/core.string.js
/vendor/flipboard/js/jquery.touchSwipe-1.2.5.js
/vendor/flipboard/js/jquery.flips.js
http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js
/vendor/flipboard/css/demo.css
/vendor/flipboard/css/style.css
/vendor/flipboard/css/fallback.css
/vendor/flipboard/js/modernizr.custom.08464.js
/css/fonts.css
/css/Open_Sans_Condensed/OpenSans-CondLight.ttf
/css/Open_Sans_Condensed/OpenSans-CondBold.ttf
/offline/flipboard{{ $get_vars }}

/offline/flipboard/marc-chagall
/offline/flipboard/marc-chagall/14?page=1
/vendor/flipboard/images/young5038.jpg
/vendor/flipboard/images/background.png
/vendor/flipboard/images/fabric_plaid.png
@if($artist_url_slug == "0" || true)
@foreach ($artists as $artist)
{{ $artist->artist_offline_url }}

{{ $artist->artist_offline_url }}?page=1
@for ($pagination_count = 1; $pagination_count * (PAGINATION_NUM - 1) < $artist->sizeof_artworks; $pagination_count++)
{{ $artist->artist_offline_url }}/{{ $pagination_count * (PAGINATION_NUM - 1) }}?page=1
@endfor
@endforeach
@endif
@foreach ($return_array as $artwork_img)
{{ $artwork_img['img_url'] }}

@endforeach

NETWORK:
*
