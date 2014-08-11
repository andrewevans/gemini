<div class="ribbon affix-top" data-spy="affix" data-offset-top="200">
    <div class="ribbon-profile">
        <img src="/{{ $artist->img_url() }}" />
    </div>
    <div class="ribbon-content">
        <h3>{{ $artist->alias }}</h3>

        <p>{{ $artist->meta_title }}</p>

        <ul>
            <li><b><a href="{{ $artist->url() }}">All {{ $artist->alias }} Works &thinsp;&raquo;</a></b></li>
            @foreach ($artist->filters() as $filterBy)
            <li><a href=" {{ $artist->url() . '/' . $filterBy }}">{{ $filterBy }} &thinsp;&raquo;</a></li>
            @endforeach
            @foreach ($artist->series() as $filterBy)
            <li><a href=" {{ $artist->url() . '/' . $filterBy }}">{{ $filterBy }} &thinsp;&raquo;</a></li>
            @endforeach
        </ul>
    </div>
</div>

