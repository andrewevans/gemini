<div class="btn-group pull-right">
    <div>List:</div>
    <a href="{{ $current_url['row'] }}"><button type="button" class="btn btn-default <?= (isset ($_GET['list']) && $_GET['list'] == "row" ? 'active' : '') ?>"><span class="glyphicon glyphicon-th-list"></span></button></a>
    <a href="{{ $current_url['card'] }}"><button type="button" class="btn btn-default <?= (!isset ($_GET['list']) || (isset ($_GET['list']) && $_GET['list'] != "row") ? 'active' : '') ?>"><span class="glyphicon glyphicon-th-large"></span></button></a>
</div>
