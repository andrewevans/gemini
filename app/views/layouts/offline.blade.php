<!DOCTYPE html>
<html lang="en" manifest="/api/v1/url/manifest?artist_id={{ $manifest_artist_id }}">
<head>

    <title>{{ $page_title }}</title>

    <script>
        function logEvent(event) {
            console.log(event.type);
        }
        window.applicationCache.addEventListener('checking', logEvent, false);
        window.applicationCache.addEventListener('noupdate', logEvent, false);
        window.applicationCache.addEventListener('downloading', logEvent, false);
        window.applicationCache.addEventListener('cached', logEvent, false);
        window.applicationCache.addEventListener('updateready', logEvent, false);
        window.applicationCache.addEventListener('obsolete', logEvent, false);
        window.applicationCache.addEventListener('error', logEvent, false);
    </script>
</head>

<body role="document">

    @yield('content')

</body>
</html>