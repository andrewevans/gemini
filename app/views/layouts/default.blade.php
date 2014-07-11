<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>{{ $page_title }}</title>
    <!--    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"> -->
    {{ HTML::style('vendor/bootstrap/css/bootstrap.min.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}


    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"> -->

    <!-- Optional theme -->
    <!-- Bootstrap theme -->
    {{ HTML::style('vendor/bootstrap/css/bootstrap-theme.min.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> -->

    {{ HTML::style('vendor/font-awesome-4.1.0/css/font-awesome.min.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}

    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

    <!-- Custom styles for this template -->
    {{ HTML::style('css/gemini-default.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}

    @if (isset ($_GET['list']) && $_GET['list'] == "row")
        {{ HTML::style('css/list-row.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}
    @endif

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body role="document">

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container size-xs">
        <div class="contact-us-info">
            <span class="phone-number">510-777-9970</span> / <span id="phone_number_800">800-805-7060</span>
            <span class="address size-s"> / 13470 Campus Drive, Oakland Hills, CA 94619 USA</span>
        </div>

        <div class="collapse navbar-collapse" style="float: right;">
            <ul class="nav navbar-nav navbar-secondary" style="border-top: 2px solid #6383a1; margin-left: 0">
                <li><a href="http://wp.andrew.com">Blog</a></li>
                <li><a href="/sell"><i>Sell Your Fine Art</i></a></li>
                <!--<li><a href="/login"><span class="size-l">Sign in</span> <span class="glyphicon glyphicon-log-in"></span></a></li>-->
                <li><a href=""><span class="size-l">Shopping Bag</span> <span class="glyphicon glyphicon-shopping-cart"></span> <span class="badge">2</span></a></li>
            </ul>

        </div>
    </div>
    <div class="container">

        <div class="logo size-xs">
            <a href="http://gemini.andrew.com"><img src="/img/masterworks-fine-art.gif" alt="Masterworks Fine Art Gallery"></a>
        </div>
        <div class="logo-xs"><img src="http://placehold.it/200x50/cccc99/111&text=Masterworks+Fine+Art+Gallery" /></div>

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
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown">Artists <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('artists') }}">Artists</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Featured Artists</li>
                            <li><a href="/artists/pablo-picasso">Pablo Picasso</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">All Artists</li>
                        @foreach ($artists as $artist_each)
                        <li><a href="{{ $artist_each->url() }}">{{ $artist_each->alias }}</a></li>
                        @endforeach
                    </ul>

                </li>
                <li class="dropdown">
                    <a href="/education" class="dropdown-toggle active" data-toggle="dropdown">Art Education <b class="caret"></b></a>
                    @include('widgets.nav', ['parent' => 'education'])
                </li>
                <li><a href="/buying">Why Choose Us</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact Us</a></li>
            </ul>
        </div><!--/.nav-collapse -->
        <div id="multiple-datasets" class="">
            {{ Form::open(array('method' => 'get', 'url' => 'search', 'class' => '', 'role' => 'search')) }}
            <div class="input-group">
                    {{ Form::label('q', 'Search') }}
                    {{ Form::text('q', null, array('class' => 'typeahead form-control size-s', 'placeholder' => 'Search artists or artworks', 'autocomplete' => 'off')) }}
                    {{ Form::hidden('q_id', null, array('class' => 'q_id', 'id' => 'q_id')) }}

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

<div class="container size-xs">
    @include('widgets.breadcrumb')
</div>

<section>
    <!--<div class="container">-->

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @yield('content')

    <!--</div>--><!-- /.container -->

</section>

<div class="jumbotron">
<div class="container">
    <footer>
        <div class="row">
            <div class="col-md-4">
                <h3>Explore the Gallery</h3>
                <ul class="nav">
                    <li><a href="">Home</a></li>
                    <li><a href="">Artists</a></li>
                    <li><a href="">Art Education</a></li>
                    <li><a href="">Why Choose Us</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Contact Us</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">Sell your art</a></li>
                    <li><a href="">Shopping bag</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Our Customer Service</h3>
                <ul class="nav">
                    <li><a href="">Always there for you</a></li>
                    <li><a href="">The Certificate of Authenticity</a></li>
                    <li><a href="">Historical Documentation</a></li>
                    <li><a href="">100% Moneyback Guarantee</a></li>
                    <li><a href="">Museum-Archival Framing</a></li>
                    <li><a href="">Our Competitive Pricing</a></li>
                    <li><a href="">Easy Payments</a></li>
                    <li><a href="">Packaging and Insurance</a></li>
                    <li><a href="">Free Annual Appraisal!</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Let's Get Social</h3>
                <ul class="nav navbar-nav">
                    <li><a href="https://www.facebook.com/masterworksfineartgallery" target="_blank"><img src="http://gemini.andrew.com/img/theme/gemini/fb-icon.png" /></a></li>
                    <li><a href=""><img src="http://gemini.andrew.com/img/theme/gemini/twitter-icon.png" /></a></li>
                    <li><a href=""><img src="http://gemini.andrew.com/img/theme/gemini/gplus-32.png" /></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Contact Us</h3>
                <ul class="nav">
                    <li><a href="">What do you think of our website?</a></li>
                    <li>Email: <a href="">info@masterworksfineart.com</a></li>
                    <li>Call: <a href="">510-777-9970 / 800-805-7060</a></li>
                    <li>Mail: <br /> 13470 Campus Drive<br />
                            Oakland Hills, California USA 94702</li>
                </ul>
            </div>
        </div>
    </footer>
</div>
</div>

<div class="container">
        &copy; Masterworks Fine Art Gallery. All rights reserved. <a href="">Privacy Policy</a>. Our gallery is located in the beautiful Oakland Hills of the <b>San Francisco</b> Bay Area, California, USA.
</div>
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

<script src="/vendor/zoom-master/jquery.zoom.min.js"></script>
<script>
    CKEDITOR.replaceAll();
    $('.zoom').zoom();
</script>

<script>
</script>
</body>
</html>