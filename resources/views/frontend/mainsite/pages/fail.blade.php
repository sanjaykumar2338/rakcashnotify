<!-- Contact Start -->
@extends('frontend.mainsite.layouts.other')
@section('content')
<div class="container-fluid contact py-1">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">
                <h1>Subscription Failed</h1>
                <p>Unfortunately, there was a problem processing your subscription. Please try again later or contact support.</p>
                <a href="{{ url('/') }}#plans" class="btn btn-danger">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
