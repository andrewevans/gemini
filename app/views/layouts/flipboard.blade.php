<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Experimental Page Layout Inspired by Flipboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Experimental Page Layout Inspired by Flipboard" />
    <meta name="keywords" content="flip, pages, flipboard, layout, responsive, web, web design, grid, ipad, jquery, css3, 3d, perspective, transitions, transform" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="../favicon.ico">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/vendor/flipboard/css/demo.css" />
    <link rel="stylesheet" type="text/css" href="/vendor/flipboard/css/style.css" />
    <script type="text/javascript" src="/vendor/flipboard/js/modernizr.custom.08464.js"></script>

    @include('partial/flipboard/pageTmpl')

</head>
<body>

<header class="main-title">
    <h1>Masterworks<br /><strong>Fine Art Gallery</strong></h1>
    <p>Browse our inventory of thousands of beautiful works</p>
    <p><strong>Best viewed with a glass of 20 year port</strong></p>
</header>

<div id="flip" class="container">

    <div class="f-page f-cover">
        <div class="cover-elements">
            <div class="logo">
                Oh Art!
                <a class="f-ref" href=""></a>
            </div>
            <h1></h1>
            <div class="f-cover-story"><span>September 17 - 21, 2014</span>New York Art, Antique & Jewelry Show</div>
        </div>
        <div class="f-cover-flip">&lt; Flip</div>
    </div>

    @yield('content')

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">

    var $container 	= $( '#flip' ),
        $pages		= $container.children().hide();

    Modernizr.load({
        test: Modernizr.csstransforms3d && Modernizr.csstransitions,
        yep : ['/vendor/flipboard/js/jquery.tmpl.min.js','/vendor/flipboard/js/jquery.history.js','/vendor/flipboard/js/core.string.js','/vendor/flipboard/js/jquery.touchSwipe-1.2.5.js','/vendor/flipboard/js/jquery.flips.js'],
        nope: '/vendor/flipboard/css/fallback.css',
        callback : function( url, result, key ) {

            if( url === '/vendor/flipboard/css/fallback.css' ) {
                $pages.show();
            }
            else if( url === '/vendor/flipboard/js/jquery.flips.js' ) {
                $container.flips();
            }

        }
    });

</script>
</body>
</html>