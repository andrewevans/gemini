<p>
    <span>USD ${{ number_format($artwork->price) }}</span>

    <span class="actions">
        <a href="/offer?artwork_id={{ $artwork->id }}" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-pencil"></span> Submit Best Offer</a>
        <a href="/purchase?artwork_id={{ $artwork->id }}" class="btn btn-default" role="button"><span class="glyphicon glyphicon-star"></span> Purchase Now</a>
        <a href="#" class="btn btn-default" role="button"> Questions?</a>
    </span>

</p>