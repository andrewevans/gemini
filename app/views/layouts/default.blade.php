<!DOCTYPE html>
<html>
<head>
    <title>Gemini</title>
    <!--    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"> -->
    {{ HTML::style('css/bootstrap.min.css', array('media' => 'screen')) }}
    {{ HTML::style('css/nerds-default.css', array('media' => 'screen')) }}
    {{ HTML::script('js/ckeditor/ckeditor.js?2') }}
</head>
<body>
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('gemini') }}">Gemini</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('/') }}">Home</a></li>
            <li><a href="{{ URL::to('artists') }}">View All Artists</a></li>
        </ul>
    </nav>

    <h1>All the Artists</h1>

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @yield('content')


</div>

<script>
    CKEDITOR.replaceAll();
</script>

</body>
</html>