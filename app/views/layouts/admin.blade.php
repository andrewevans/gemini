<!DOCTYPE html>
<html lang='en'>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>@yield('title') | Gemini Admin</title>

    <!--    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"> -->
    {{ HTML::style('vendor/bootstrap/css/bootstrap.min.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}


    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"> -->
    {{ HTML::script('js/ckeditor/ckeditor.js?2') }}
    {{ HTML::script('js/jquery-2.1.1.min.js') }}
    {{ HTML::script('vendor/bootstrap/docs.min.js') }}
    {{ HTML::script('vendor/bootstrap/js/bootstrap.min.js') }}

    <!-- Optional theme -->
    <!-- Bootstrap theme -->
    {{ HTML::style('vendor/bootstrap/css/bootstrap-theme.min.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> -->

    {{ HTML::style('vendor/font-awesome-4.1.0/css/font-awesome.min.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}

    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

    <!-- Custom styles for this template -->
    {{ HTML::style('css/gemini-default.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}
    {{ HTML::style('css/min-design-default.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}
    {{ HTML::style('css/gemini-admin.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.css" rel="stylesheet">
    <script src="/vendor/jquery-ui/js/jquery-ui-1.10.4.js"></script>

    <script>
        $(function() {
// Format the table headers and table rows using classes
// from the CSS framework.
            $( "td" ).addClass( "ui-widget-content" );
            $( "th" ).addClass( "ui-widget-header" );

// Create the first sortable, connecting it to the second
// sortable.
            $( "table:first tbody" ).sortable({
                connectWith: "table:last tbody"
            });

// Create the second sortable, connecting it to the first
// sortable.
            $( "table:last tbody" ).sortable({
                connectWith: "table:first tbody"
            });        });
    </script>
</head>
<body>
<div class='container-fluid'>
    <div class='row'>
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <div class="container">
            <h3><a href="/gemini">&laquo; Back</a></h3>
        </div>

        <div class="container">
            @yield('content')
        </div>

    </div>
</div>

<script>
    config1 = CKEDITOR.tools;
    config1.height = 800;
    config1.enterMode = CKEDITOR.ENTER_P;
    config1.allowedContent = 'p i b blockquote u del em a ul ol li sup sub br caption cite figure figcaption embed img noscript object strong';

    //CKEDITOR.replace('artwork_description', config1);
    CKEDITOR.replaceAll();

</script>
</body>
</html>