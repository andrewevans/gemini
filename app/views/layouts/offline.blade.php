<!DOCTYPE html>
<html lang="en" manifest="/api/v1/url/manifest?secret=dog&artist_id={{ $manifest_artist_id }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<head>

    <title>{{ $page_title }}</title>

    <script>
        (function(document,navigator,standalone) {
            // prevents links from apps from oppening in mobile safari
            // this javascript must be the first script in your <head>
            if ((standalone in navigator) && navigator[standalone]) {
                var curnode, location=document.location, stop=/^(a|html)$/i;
                document.addEventListener('click', function(e) {
                    curnode=e.target;
                    while (!(stop).test(curnode.nodeName)) {
                        curnode=curnode.parentNode;
                    }
                    // Condidions to do this only on links to your own app
                    // if you want all links, use if('href' in curnode) instead.
                    if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) ) {
                        e.preventDefault();
                        location.href = curnode.href;
                    }
                },false);
            }
        })(document,window.navigator,'standalone');

        function logEvent(event) {
            console.log(event.type);
            if (event.type == 'cached' || event.type == 'noupdate')
            alert(event.type);
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
<a href="/offline/artists">Back to list</a><br />
    @yield('content')

</body>
</html>