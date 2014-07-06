@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<div class="container">
        {{ HTML::ul($errors->all()) }}
</div>

<div class="container">
    <h1>How to Sell Fine Art You Own</h1>
    <p>We offer cash up front if we are interested in your work of fine art. Evaluation of the piece usually takes less than a week, in which time you will receive payment thereafter. As private art dealers, we are committed to educating you and offer our services free of charge.</p>

    <ul>
        <li>we carry the artist in our <a href="/artists">fine art inventory</a></li>
        <li>you personally own the work of art</li>
        <li>and you would like to sell the art or learn more about it</li>
    </ul>

    <p>In order to partake in this service, you must meet submission processing requirements and provide all necessary information. Submissions that do not meet the stated requirements will not be reviewed.</p>
</div>

<div class="container">
    <h3>Form Submission</h3>

            {{ Form::open(array('url' => 'sell')) }}

            <div class="form-group">
                {{ Form::label('cust_name', 'Your name') }}
                {{ Form::text('cust_name', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('cust_email', 'Your email') }}
                {{ Form::text('cust_email', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('cust_inquiry', 'Your inquiry') }}
                {{ Form::textarea('cust_inquiry', null, array('class' => 'form-control')) }}
            </div>

            {{ Form::submit('Send message', array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}


</div>

<div class="container">
    <h3>Via Email:</h3>
    1) Please attach up to 4 digital images, or high quality picture scans, of the work(s) in question, including general images of the entire work and close-up views of pertinent information, such as signatures, numbering, inscriptions, watermarks or other notable features.<br />
    2) Please include a brief description of the work that includes how you acquired the piece, any information you have collected, and the questions you have.<br />
    3) Please allow 7-10 days for us to review the information and reply.<br />
    4) Our email address:&nbsp;<br />
    <a href="mailto:info@masterworksfineart.com">info@masterworksfineart.com</a>

    <h3>Standard Mail</h3>
    1) Please enclose photographs of the work(s) in question, including general images of the entire work and close-up views of pertinent information, such as signatures, numbering, inscriptions, watermarks or other notable features.<br />
    2) If you would like your photos returned please include a self-addressed stamped envelope, with sufficient postage, in your correspondence.<br />
    3) Please include a brief description of the work that includes how you acquired the piece, any information you have collected, and the questions you have.<br />
    4) Please include an email address where you can be contacted for reply.<br />
    5) Please allow 7-10 days for us to receive the packet and an additional 7-10 days to review the information and reply. NOTE: Standard Mail submissions will only receive email responses.<br />
    6) We are located in the beautiful San Francisco Bay Area of California, USA. Our mailing address:&nbsp;<br />
    ATTN: Robert Ubillus Adelman, Masterworks Fine Art<br />
    13470 Campus Drive<br />
    Oakland Hills, California 94619</p>
</div>
@stop