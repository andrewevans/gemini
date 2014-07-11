<div class="btn-group pull-right">
    <div>List:</div>
    <button type="button" class="btn btn-default <?= (isset ($_GET['list']) && $_GET['list'] == "row" ? 'active' : '') ?>"><a href="?list=row"><span class="glyphicon glyphicon-th-list"></span></a></button>
    <button type="button" class="btn btn-default <?= (!isset ($_GET['list']) || (isset ($_GET['list']) && $_GET['list'] != "row") ? 'active' : '') ?>"><a href="?list=card"><span class="glyphicon glyphicon-th-large"></span></a></button>
</div>