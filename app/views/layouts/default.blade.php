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

    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

    <!-- Custom styles for this template -->
    {{ HTML::style('css/gemini-default.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}

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
                <li><a href=""><i>Sell Your Fine Art</i></a></li>
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
                        @foreach ($artists as $artist)
                        <li><a href="/artists/{{ $artist->url_slug }}">{{ $artist->alias }}</a></li>
                        @endforeach
                    </ul>

                </li>
                <li><a href="">Art Education</a></li>
                <li><a href="#">Why Choose Us</a></li>
                <li><a href="">About</a></li>
                <li><a href="#">Contact Us</a></li>
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

<!--<div class="container">-->

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @yield('content')

    <footer>
        <p>&copy; Gemini 2014</p>
    </footer>

<!--</div>--><!-- /.container -->

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

<script>
    CKEDITOR.replaceAll();
</script>

<script>
</script>
</body>
</html>