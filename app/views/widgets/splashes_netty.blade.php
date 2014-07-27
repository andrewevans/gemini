@if (sizeof($splashes) > 0)
<!-- thumb navigation carousel -->
<div class="col-md-2 " id="slider-thumbs">
    <!-- thumb navigation carousel items -->
    <ul class="list-unstyled">
        @foreach ($splashes as $key => $splash)
        <li>
            <a id="carousel-selector-{{ $key }}" class="selected carousel-thumb carousel-thumb-3"><h4>{{ $splash->title }}</h4></a>
        </li>
        @endforeach
    </ul>
</div>
<!-- main slider carousel -->
<div class="col-md-10" id="slider">
        <div class="col-md-12" id="carousel-bounding-box">
            <div id="myCarousel" class="carousel slide">
                <!-- main slider carousel items -->
                <div class="carousel-inner">
                    @foreach ($splashes as $key => $splash)
                        <div class="<?= ($key == 0 ? 'active ' : '' ) ?>item" data-slide-to="{{ $key }}">
                            <div class="col-md-8 item-img">
                                <a href=""><img src="{{ $splash->asset_url }}" class="img-responsive"></a>
                            </div>
                            <div class="col-md-4">
                                <div class="item-copy">
                                    <h4>{{ $splash->title }}</h4>
                                    <p>We like this one because of something or other and it is a piece of art stuff this is. Yes you read that correctly.</p>
                                    <div class="read-more"><a href="{{ $splash->destination_url }}">Read more &thinsp;&raquo;</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--/main slider carousel-->
@endif