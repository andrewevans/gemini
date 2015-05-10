<p>
    @if ($artwork->onhold)
        <span class="artwork-onhold">On Hold</span>
    @elseif ($artwork->price_on_request)
        <span class="artwork-por">Price on Request</span>
    @elseif ($artwork->price > 0)
        <span>USD ${{ number_format($artwork->price) }}</span>
    @endif

    <span class="actions">
        <a href="/offer?artwork_id={{ $artwork->id }}" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-pencil"></span> Submit Best Offer</a>
        <a href="/purchase?artwork_id={{ $artwork->id }}" class="btn btn-default" role="button"><span class="glyphicon glyphicon-star"></span> Purchase Now</a>
        <a href="/contact?artwork_id={{ $artwork->id }}" class="btn btn-default" role="button"> Questions?</a>
    </span>

</p>