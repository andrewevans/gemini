<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>Gemini</title>
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
    <div class="container">
        <div class="logo">
            <!--<a href="http://www.masterworksfineart.com"><img src="http://www.masterworksfineart.com/foxy/public/skins/blues/images/masterworks-fine-art.gif" alt="Masterworks Fine Art Gallery"></a>-->
        </div>
        <div class="contact-info">
            510-777-9970 / <span id="phone_number_800">800-805-7060</span><br>
            <span class="address">13470 Campus Drive, Oakland Hills, CA 94619</span>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}">Gemini</a>
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
                <li><a href="{{ URL::to('artworks') }}">Artworks</a></li>
                <li><a href="#">Art Education</a></li>
                <li><a href="{{ URL::to('blog') }}">Blog</a></li>
                <li><a href="#">Buying From Us</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Sell Your Fine Art</a></li>
                <li>
                    <div id="multiple-datasets">
                        {{ Form::open(array('method' => 'get', 'url' => 'search')) }}
                            <div class="form-group">
                                {{ Form::label('q', 'Search') }}
                                {{ Form::text('q', null, array('class' => 'typeahead form-control', 'placeholder' => 'Search artists or artworks')) }}
                            </div>
                            {{ Form::submit('Search', array('class' => 'btn btn-primary')) }}
                        {{ Form::close() }}
                    </div>

                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
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
{{ HTML::script('js/gemini-default.js') }}
<!--<link href="/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.css" rel="stylesheet">-->
<!--<script src="/vendor/jquery-ui/js/jquery-ui-1.10.4.js"></script>-->
<script src="/vendor/typeahead.js-master/dist/bloodhound.js"></script>
<script src="/vendor/typeahead.js-master/dist/typeahead.bundle.js"></script>
<script src="/vendor/handlebars-v1.3.0.js"></script>

<script>
    CKEDITOR.replaceAll();
</script>

<script>
    var charMap = {'àáâããäå': 'a', 'èéêë': 'e', 'ç': 'c', 'ß': 'ss'};

    var normalize = function(str) {
        $.each(charMap, function(chars, normalized) {
            var regex = new RegExp('[' + chars + ']', 'gi');
            str = str.replace(regex, normalized);
        });

        return str;
    }

    var queryTokenizer = function(q) {
        var normalized = normalize(q);
        return Bloodhound.tokenizers.whitespace(normalized);
    };

    var artists_list = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
            ttl: 0,
            url: '/api/v1/url/artists',
        }
    });

    var artworks_list = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: queryTokenizer,
        prefetch: {
            ttl: 0,
            url: '/api/v1/url/artworks'
        }
    });

    artists_list.initialize();
    artworks_list.initialize();

    $('#multiple-datasets .typeahead').typeahead({
            highlight: true
        },
        {
            name: 'artists-list',
            displayKey: 'value',
            source: artists_list.ttAdapter(),
            templates: {
                header: '<h3 class="table-name">Artists</h3>',
                empty: [
                    '<div class="empty-message">',
                    '<p>No artists found.</p>',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<p><strong>\{\{value\}\}</strong>  (\{\{year_begin\}\} - \{\{year_end\}\})</p>')
            }

        },
        {
            name: 'artworks-list',
            displayKey: 'value',
            source: artworks_list.ttAdapter(),
            templates: {
                header: '<h3 class="table-name">Artworks</h3>',
                empty: [
                    '<div class="empty-message">',
                    '<p>No artwork found.</p>',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<p><strong>\{\{value\}\}</strong>  (\{\{medium_short\}\})</p>')
            }
        });
</script>
</body>
</html>