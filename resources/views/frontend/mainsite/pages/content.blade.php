<!-- Contact Start -->
@extends('frontend.mainsite.layouts.other')
@section('content')
<div class="container-fluid contact py-1">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">
                <div>{!! $page->description !!}</div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', { action: 'submitContact' }).then(function (token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
</script>
@endsection