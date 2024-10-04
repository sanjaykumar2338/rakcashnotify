<!-- Contact Start -->
@extends('frontend.mainsite.layouts.other')
@section('content')
<div class="container-fluid contact py-1">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">
            <h1>Subscription Successful</h1>
            <p>Thank you for subscribing! Your subscription was processed successfully.</p>
            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>

            </div>
        </div>
    </div>
</div>
@endsection
