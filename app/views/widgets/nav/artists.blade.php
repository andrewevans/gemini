<li class="dropdown">
    <a href="/artists" class="dropdown-toggle" data-toggle="dropdown">Artists <b class="caret"></b></a>
    <div class="dropdown-menu container">
        <div class="col-md-3"><ul class="nav-multi-list featured">
                <li class="divider"></li>
                <li class="dropdown-header">Featured Artists</li>
                <li class="divider"></li>
                <li><a href="/artists/georges-braque">Georges Braque</a></li>
                <li><a href="/artists/marc-chagall">Marc Chagall</a></li>
                <li><a href="/artists/albrecht-durer">Albrecht D&uuml;rer</a></li>
                <li><a href="/artists/rene-magritte">Ren&eacute; Magritte</a></li>
                <li><a href="/artists/henri-matisse">Henri Matisse</a></li>
                <li><a href="/artists/joan-miro">Joan Mir&oacute;</a></li>
                <li><a href="/artists/claude-monet">Claude Monet</a></li>
                <li><a href="/artists/pablo-picasso">Pablo Picasso</a></li>
                <li><a href="/artists/pablo-picasso/ceramics">Picasso Ceramics</a></li>
                <li><a href="/artists/rembrandt">Rembrandt</a></li>
                <li><a href="/artists/pierre-auguste-renoir">Renoir</a></li>
                <li><a href="/artists/andy-warhol">Andy Warhol</a></li>
                <li><a href="/artists/victor-vasarely">Victor Vasarely</a></li>
                <li><a href="/artists/yvaral">Yvaral</a></li>
                <li><a href="/artists?filter=featured" style="text-transform: uppercase">View All Artists &thinsp;»</a></li>
            </ul>
        </div>
        <div class="col-md-3">
            <ul class="nav-multi-list">
                <li class="divider"></li>
                <li class="dropdown-header">Modern Masters</li>
                <li class="divider"></li>

                @foreach ($artists as $artist_each)
                @if ($artist_each->genre == "modern")
                <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
        <div class="col-md-3">
            <ul class="nav-multi-list">
                <li class="divider"></li>
                <li class="dropdown-header">Contemporary Masters</li>
                <li class="divider"></li>

                @foreach ($artists as $artist_each)
                @if ($artist_each->genre == "contemporary")
                <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
        <div class="col-md-3">
            <ul class="nav-multi-list">
                <li class="divider"></li>
                <li class="dropdown-header">Impressionists</li>
                <li class="divider"></li>

                @foreach ($artists as $artist_each)
                @if ($artist_each->genre == "impressionist")
                <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                @endif
                @endforeach
            </ul>
            <ul class="nav-multi-list">
                <li class="divider"></li>
                <li class="dropdown-header">Old Masters</li>
                <li class="divider"></li>

                @foreach ($artists as $artist_each)
                @if ($artist_each->genre == "old")
                <li><a href="{{ $artist_each->url() }}">{{ $artist_each->inverted_alias() }}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</li>
