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
http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic
/offline/artists
/offline/flipboard
/offline/flipboard/marc-chagall
/offline/flipboard/marc-chagall/14?page=1
/offline/artists/yaacov-agam
/offline/flipboard/yaacov-agam
/offline/artists/yaacov-agam/hand-signed-color-agamograph/meridia-from-mexico-suite-1985/id/3983
@if($artist_url_slug == "0" || true)
@foreach ($artists as $artist)
{{ $artist->artist_offline_url }}

@endforeach
@endif
@foreach ($return_array as $artwork_img)
{{ $artwork_img['img_url'] }}

@endforeach

NETWORK:
*
