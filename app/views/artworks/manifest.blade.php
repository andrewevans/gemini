CACHE MANIFEST

# Build 2014-09-02

CACHE:
@foreach ($return_array as $artwork_img)
{{ $artwork_img['mfa_img_url'] }}

{{ $artwork_img['artwork_url'] }}

{{ $artwork_img['artist_url'] }}

@endforeach

NETWORK:
*
