@extends('layouts.default')
<!-- app/views/artworks/show.blade.php -->

@section('content')

<div class="container">
        {{ HTML::ul($errors->all()) }}
</div>

<div class="container">
    <h1>We'd Love to Hear From You!</h1>
    <p>Whether you have a question about a work of art, looking for an appraisal, or you're in town and want to check out the gallery, we want to know what's on your mind. Our community is very important to us!</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Phone</h2>
            <table class="table">
                <tr><td>Office:</td><td>(510) 777-9970</td></tr>
                <tr><td>Toll-free:</td><td>1-800-805-7060</td></tr>
                <tr><td>Fax:</td><td>(510) 777-9972</td></tr>
            </table>

            <h2>Email</h2>
            <p><a href="mailto:info@masterworksfineart.com">info@masterworksfineart.com</a><br />
            &hellip;and here's our <a href="">extended e-mail list</a>.</p>
        </div>

        <div class="col-md-6">
            {{ Form::open(array('url' => 'contact')) }}

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

            <div class="form-group">
                {{ Form::checkbox('cust_newsletter', '1', null, array('class' => 'form-control')) }}
                {{ Form::label('cust_newsletter', 'Get our fabulous, and sometimes controversial, newsletter!') }}
            </div>

            {{ Form::submit('Send message', array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}

        </div>

        <div class="col-md-12">
            <h2>Stop By the Gallery</h2>
            <p>We'd be happy to see you. Just <a href="/contact">contact us</a> beforehand to make an appointment, and let us know if there are specific artists you are interested in.</p>

            <p>Masterworks Fine Art Gallery<br />
            13470 Campus Drive<br />
            Oakland Hills, CA 94619 USA</p>
        </div>

        <div class="col-md-12">
            <h2>Want to Sell a Work of Art?</h2>
            <p>We'd be happy to see you. Just <a href="/contact">contact us</a> beforehand to make an appointment, and let us know if there are specific artists you are interested in.</p>

            <p>Masterworks Fine Art Gallery<br />
                13470 Campus Drive<br />
                Oakland Hills, CA 94619 USA</p>
        </div>

        <div class="col-md-12">
            <h2>Get Social</h2>

            <table class="table">
                <tr><td></td><td>See what we're showcasing on our blog</td></tr>
                <tr><td><a href="https://www.facebook.com/masterworksfineartgallery" target="_blank"><img src="{{ asset('img/theme/gemini/fb-icon.png') }}" /></a></td><td>Be friends with Masterworks Fine Art on FACEBOOK</td></tr>
                <tr><td><img src="{{ asset('img/theme/gemini/twitter-icon.png') }}" /></td><td>Water cooler chat with Masterworks Fine Art on TWITTER</td></tr>
                <tr><td><img src="{{ asset('img/theme/gemini/gplus-32.png') }}" /></td><td>Keep up with trending topics with us on G+</td></tr>
                <tr><td></td><td>Share the things you love with us on PINTEREST</td></tr>
            </table>
        </div>

        <div class="col-md-12">
            <h2>We Respect Your Privacy</h2>

            <p>We respect the personal privacy of all our clientele. We will never use any personally identifiable information without your explicit consent. For more information, please review our <a href="http://www.masterworksfineart.com/about/privacy-policy.php">Privacy Policy</a>.</p>
        </div>

    </div>

</div>

@stop