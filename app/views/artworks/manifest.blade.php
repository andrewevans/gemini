CACHE MANIFEST

# Build 2014-09-02

CACHE:
@foreach ($return_array as $artwork_img)
{{ $artwork_img['mfa_img_url'] }}

@endforeach

NETWORK:
http://*
https://*
