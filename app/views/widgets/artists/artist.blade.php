<div class="row">
    <div class="col-md-5 col-md-offset-1">
        @include('widgets.artists.bio', array('artist' => $artist, 'var' => 'mydata'))
    </div>
    <div class="col-md-5">
        @include('widgets.artists.pages', array('artist' => $artist, 'var' => 'mydata'))
    </div>
    <div class="col-md-5">
        @include('widgets.artists.posts', array('artist' => $artist, 'var' => 'mydata'))
    </div>
    <div class="col-md-5">
        @include('widgets.artists.catalogues', array('artist' => $artist, 'var' => 'mydata'))
    </div>
</div>
