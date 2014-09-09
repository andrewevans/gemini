CACHE MANIFEST

# Build 2014-09-08 003 {{ time() }}

CACHE:
@foreach ($return_array as $artwork_img)
{{ $artwork_img['img_url'] }}

{{ $artwork_img['artwork_url'] }}

@endforeach

NETWORK:
*
