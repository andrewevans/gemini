<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />

    <title>{{ $page_title }}</title>
    <!--    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"> -->

    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"> -->

    <!-- Optional theme -->
    <!-- Bootstrap theme -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> -->

    {{ HTML::style('vendor/font-awesome-4.1.0/css/font-awesome.min.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}

    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

    <!-- Custom styles for this template -->

    {{ Minify::stylesheet(array(
    '/vendor/bootstrap/css/bootstrap.css',
    '/vendor/bootstrap/css/bootstrap-theme.css',
    '/css/gemini-global.css',
    '/css/gemini-nav.css',
    '/css/gemini-individuals.css',
    '/css/gemini-search.css',
    '/css/gemini-widgets.css',
    '/css/gemini-responsive.css',
    '/css/gemini-default.css',
    '/themes/netty/netty-default.css',
    '/vendor/google-fonts/roboto.css',
    '/vendor/google-fonts/ovo.css',

    ), array('media' => 'screen', 'rel' => 'stylesheet')) }}

    @if (Session::get('list') == 'row')
        {{ Minify::stylesheet('/css/list-row.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}
    @endif

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body role="document">

<div class="navbar navbar-default" role="navigation">
    <div class="container size-xs">
        <div class="contact-us-info">
            <span class="phone-number">510-777-9970</span> / <span id="phone_number_800">800-805-7060</span>
            <span class="address size-s"> / 13470 Campus Drive, Oakland Hills, CA 94619 USA</span>
        </div>

        <div class="collapse navbar-collapse" style="float: right;">
            <ul class="nav navbar-nav navbar-secondary" style="border-top: 2px solid #6383a1; margin-left: 0">
                <li><a href="http://wp.appelfineart.com">Blog</a></li>
                <li><a href="/sell"><i>Sell Your Fine Art</i></a></li>
                <!--<li><a href="/login"><span class="size-l">Sign in</span> <span class="glyphicon glyphicon-log-in"></span></a></li>-->
                <li><a href="#"><span class="size-l">Shopping Bag</span> <span class="glyphicon glyphicon-shopping-cart"></span> <span class="badge">2</span></a></li>
            </ul>

        </div>
    </div>
    <div class="container">

        <div class="logo size-xs">
            <a href="{{ Request::root() }}"><img src="/img/masterworks-fine-art.gif" alt="Masterworks Fine Art Gallery"></a>
        </div>
        <div class="logo-xs"><a href="{{ Request::root() }}"><img src="/img/masterworks-fine-art-logo-small.gif" alt="Masterworks Fine Art Gallery" /></a></div>

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- <a class="navbar-brand" href="{{ URL::to('/') }}">Gemini</a>-->
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="/artists" class="dropdown-toggle" data-toggle="dropdown">Artists <b class="caret"></b></a>
                    <div class="dropdown-menu container">
                        <div class="col-md-3"><ul class="nav-multi-list featured">
                                <li class="divider"></li>
                                <li class="dropdown-header">Featured Artists</li>
                                <li class="divider"></li>
                                <li><a href="/artists/georges-braque">Georges Braque</a></li>
                                <li><a href="/artists/marc-chagall">Marc Chagall</a></li>
                                <li><a href="/artists/albrecht-durer">Albrecht D&uuml;rer</a></li>
                                <li><a href="/artists/rene-magritte">Ren&eacute; Magritte</a></li>
                                <li><a href="/artists/henri-matisse">Henri Matisse</a></li>
                                <li><a href="/artists/joan-miro">Joan Mir&oacute;</a></li>
                                <li><a href="/artists/claude-monet">Claude Monet</a></li>
                                <li><a href="/artists/pablo-picasso">Pablo Picasso</a></li>
                                <li><a href="/artists/pablo-picasso/ceramics">Picasso Ceramics</a></li>
                                <li><a href="/artists/rembrandt">Rembrandt</a></li>
                                <li><a href="/artists/pierre-auguste-renoir">Renoir</a></li>
                                <li><a href="/artists/andy-warhol">Andy Warhol</a></li>
                                <li><a href="/artists/victor-vasarely">Victor Vasarely</a></li>
                                <li><a href="/artists/yvaral">Yvaral</a></li>
                                <li><a href="/artists?filter=featured" style="text-transform: uppercase">View All Artists &thinsp;»</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul class="nav-multi-list">
                                <li class="divider"></li>
                                <li class="dropdown-header">Modern Masters</li>
                                <li class="divider"></li>

                                @foreach ($artists as $artist_each)
                                    @if ($artist_each->genre == "modern")
                                        <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul class="nav-multi-list">
                                <li class="divider"></li>
                                <li class="dropdown-header">Contemporary Masters</li>
                                <li class="divider"></li>

                                @foreach ($artists as $artist_each)
                                @if ($artist_each->genre == "contemporary")
                                <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul class="nav-multi-list">
                                <li class="divider"></li>
                                <li class="dropdown-header">Impressionists</li>
                                <li class="divider"></li>

                                @foreach ($artists as $artist_each)
                                @if ($artist_each->genre == "impressionist")
                                <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                                @endif
                                @endforeach
                            </ul>
                            <ul class="nav-multi-list">
                                <li class="divider"></li>
                                <li class="dropdown-header">Old Masters</li>
                                <li class="divider"></li>

                                @foreach ($artists as $artist_each)
                                @if ($artist_each->genre == "old")
                                <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </li>
                @if (! Config::get('app.gemini_lite'))
                <li class="dropdown">
                    <a href="/education" class="dropdown-toggle active disabled" data-toggle="dropdown">Art Education <b class="caret"></b></a>
                    @include('widgets.nav', ['parent' => 'education'])
                </li>
                @endif
                <li><a href="/buying">Why Choose Us</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact Us</a></li>
            </ul>
        </div><!--/.nav-collapse -->
        <div id="multiple-datasets" class="">
            {{ Form::open(array('method' => 'get', 'url' => 'search', 'class' => '', 'role' => 'search')) }}
            <div class="input-group">
                    {{ Form::label('q', 'Search') }}

                    @if (! Config::get('app.legacy_search'))
                    {{ Form::text('q', null, array('class' => 'typeahead form-control', 'placeholder' => 'Search artists or artworks', 'autocomplete' => 'off')) }}
                    {{ Form::hidden('q_id', null, array('class' => 'q_id', 'id' => 'q_id')) }}
                    @else
                    {{ Form::text('q', null, array('class' => 'form-control', 'placeholder' => 'Search artists or artworks', 'autocomplete' => 'off')) }}
                    @endif

                <div class="input-group-btn">
                    <button class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>

            </div>

            {{ Form::close() }}
        </div>

    </div>

</div>

@if('home.index' != Route::current()->getName() )
    <div class="container size-xs">
        @include('widgets.breadcrumb')
    </div>
@endif

<section>
    <!--<div class="container">-->

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @yield('content')

    <!--</div>--><!-- /.container -->

</section>

<div class="jumbotron spacy">
<div class="container">
    <footer>
        <div class="row">
            <div class="col-md-4">
                <h3>Explore the Gallery</h3>
                <ul class="nav">
                    <li><a href="{{ Request::root() }}">Home</a></li>
                    <li><a href="/artists">Artists</a></li>
                    <li><a href="/education">Art Education</a></li>
                    <li><a href="/buying">Why Choose Us</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                    <li><a href="http://wp.appelfineart.com">Blog</a></li>
                    <li><a href="/sell">Sell your art</a></li>
                    <li><a href="">Shopping bag</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Our Customer Service</h3>
                <ul class="nav">
                    <li><a href="#">Always there for you</a></li>
                    <li><a href="#">The Certificate of Authenticity</a></li>
                    <li><a href="#">Historical Documentation</a></li>
                    <li><a href="#">100% Moneyback Guarantee</a></li>
                    <li><a href="#">Museum-Archival Framing</a></li>
                    <li><a href="#">Our Competitive Pricing</a></li>
                    <li><a href="#">Easy Payments</a></li>
                    <li><a href="#">Packaging and Insurance</a></li>
                    <li><a href="#">Free Annual Appraisal!</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Let's Get Social</h3>
                <ul class="nav navbar-nav">
                    <li><a href="https://www.facebook.com/masterworksfineartgallery" target="_blank"><img src="/img/theme/gemini/fb-icon.png" /></a></li>
                    <li><a href="#"><img src="/img/theme/gemini/twitter-icon.png" /></a></li>
                    <li><a href="#"><img src="/img/theme/gemini/gplus-32.png" /></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Contact Us</h3>
                <ul class="nav">
                    <li><a href="#">What do you think of our website?</a></li>
                    <li>Email: <a href="#">info@masterworksfineart.com</a></li>
                    <li>Call: <a href="#">510-777-9970 / 800-805-7060</a></li>
                    <li>Mail: <br /> 13470 Campus Drive<br />
                            Oakland Hills, California USA 94702</li>
                </ul>
            </div>
        </div>
    </footer>
</div>
</div>

<div class="container">
        &copy; Masterworks Fine Art Gallery. All rights reserved. <a href="#">Privacy Policy</a>. Our gallery is located in the beautiful Oakland Hills of the <b>San Francisco</b> Bay Area, California, USA.
</div>
{{ HTML::script('js/jquery-2.1.1.min.js') }}
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
{{ HTML::script('js/ckeditor/ckeditor.js?2') }}
{{ HTML::script('js/jquery-2.1.1.min.js') }}
{{ HTML::script('vendor/bootstrap/docs.min.js') }}
{{ HTML::script('vendor/bootstrap/js/bootstrap.min.js') }}
<!--<link href="/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.css" rel="stylesheet">-->
<!--<script src="/vendor/jquery-ui/js/jquery-ui-1.10.4.js"></script>-->
<script src="/vendor/typeahead.js-master/dist/bloodhound.js"></script>
<script src="/vendor/typeahead.js-master/dist/typeahead.bundle.js"></script>
<script src="/vendor/handlebars-v1.3.0.js"></script>
{{ HTML::script('js/gemini-default.js') }}

@if (Config::get('app.artworks_zoom'))
<script src="/vendor/zoom-master/jquery.zoom.min.js"></script>
<script>
    $('.zoom').zoom();
</script>
@endif

<script>
</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=139224282816158&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Please call pinit.js only once per page -->
<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>

<!-- Place this tag after the last share tag. -->
<script type="text/javascript">
    (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    })();
</script>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
    var sc_project=9912918;
    var sc_invisible=1;
    var sc_security="c128aeee";
    var sc_https=1;
    var scJsHost = (("https:" == document.location.protocol) ?
        "https://secure." : "http://www.");
    document.write("<sc"+"ript type='text/javascript' src='" +
        scJsHost+
        "statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="hit counter"
                                      href="http://statcounter.com/free-hit-counter/"
                                      target="_blank"><img class="statcounter"
                                                           src="http://c.statcounter.com/9912918/0/c128aeee/1/"
                                                           alt="hit counter"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-3116235-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>

<!-- Start of StatCounter Code -->
<script type="text/javascript">
    sc_project=3759295;
    sc_invisible=1;
    sc_partition=40;
    sc_security="ab715bd5";
</script>

<script type="text/javascript" src="http://www.statcounter.com/counter/counter_xhtml.js"></script><noscript><div class="statcounter"><a href="http://www.statcounter.com/free_hit_counter.html" target="_blank"><img class="statcounter" src="http://c41.statcounter.com/3759295/0/ab715bd5/1/" alt="site hit counter" ></a></div></noscript>
<!-- End of StatCounter Code -->


<!-- Google Code for Remarketing Tag -->
<script type="text/javascript">
    var google_tag_params = {
    };
</script>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1072257179;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1072257179/?value=0&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>

</body>
</html>