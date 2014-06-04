<div class="jumbotron text-center">
    @include('widgets.artists.bio', array('artist' => $artist, 'var' => 'mydata'))
</div>

<div class="container">
    @include('widgets.artists.pages', array('artist' => $artist, 'var' => 'mydata'))
</div>

<div class="container">
    @include('widgets.artists.posts', array('artist' => $artist, 'var' => 'mydata'))
</div>
