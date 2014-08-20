<div class="row">

    <div class="col-md-6">
        <div class="paper">
            @include('widgets.artists.bio', array('artist' => $artist, 'var' => 'mydata'))
        </div>
    </div>
    <div class="col-md-6">
        <div class="paper">
            @include('widgets.artists.pages', array('artist' => $artist, 'var' => 'mydata'))
        </div>
    </div>
    <div class="col-md-6">
        <div class="paper">
            @include('widgets.artists.posts', array('artist' => $artist, 'var' => 'mydata'))
        </div>
    </div>
    <div class="col-md-6">
        <div class="paper">
            @include('widgets.artists.catalogues', array('artist' => $artist, 'var' => 'mydata'))
        </div>
    </div>

</div>
