@if (sizeof($splashes) > 0)
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

        @for ($count = 1; $count < sizeof($splashes); $count++)
            <li data-target="#myCarousel" data-slide-to="{{ $count }}"></li>
        @endfor
    </ol>
    <div class="carousel-inner">
        @foreach ($splashes as $key => $splash)
        <div class="item <?= ($key == 0 ? 'active' : '') ?>">
            <a href="{{ $splash->destination_url }}">
                <img src="{{ $splash->asset_url }}" alt="{{ $splash->title }}" />
            </a>
            <div class="carousel-caption">
            </div>
        </div>
        @endforeach
    </div>

    @if (sizeof($splashes) > 1)
        <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    @endif
</div><!-- /.carousel -->
@endif


