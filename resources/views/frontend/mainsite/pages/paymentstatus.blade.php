<!-- Contact Start -->
@extends('frontend.mainsite.layouts.other')
@section('content')

<div class="container-fluid price" id="plans">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
            @if($status == 'success')
                <h2>{{ $statusMsg }}</h2>
                <p>Plan: {{ $subscription->plan_name }}</p>
                <p>Price: ${{ $subscription->plan_price }}</p>
                <p>Interval: {{ $subscription->interval_count }} {{ $subscription->interval }}</p>
            @else
                <h2>{{ $statusMsg }}</h2>
            @endif
        </div>
    </div>
</div>
@endsection