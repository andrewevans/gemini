<!DOCTYPE html>
<html lang='en'>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>@yield('title') | Gemini Admin</title>

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
    {{ HTML::style('css/min-design-default.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}
    {{ HTML::style('css/gemini-admin.css', array('media' => 'screen', 'rel' => 'stylesheet')) }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class='container-fluid'>
    <div class='row'>
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>