<div class="btn-group text-right">
    <span>Sort:</span>

        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                <a role="menuitem" tabindex="-1" href="#">{{ Session::get('sortBy.name') }}</a>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ Session::get('sortList.featured.current_url') }}">{{ Session::get('sortList.featured.name') }}</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ Session::get('sortList.high.current_url') }}">{{ Session::get('sortList.high.name') }}</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ Session::get('sortList.low.current_url') }}">{{ Session::get('sortList.low.name') }}</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ Session::get('sortList.new.current_url') }}">{{ Session::get('sortList.new.name') }}</a></li>
            </ul>
        </div>

    <div>

    </div>
</div>

