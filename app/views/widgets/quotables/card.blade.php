@if (sizeof($quotes) > 0)
@foreach ($quotes as $key => $quote)
<div class="col-md-4 col-sm-4">
    <quote>{{$quote->description}}</quote>
</div>
@endforeach
@endif
