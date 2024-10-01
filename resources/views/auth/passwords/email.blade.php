@extends('frontend.mainsite.layouts.common')
@section('content')

<style>
    button {
        width: 100%;
        margin-top: 10px;
        padding: 12px;
        border-radius: 7px;
        background-color: #d1ddb0;
        color: black;
        font-weight: bold;
        border: none;
    }

    input[type=email]{
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        border-radius: 7px;
    }

    .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>

<div class="container-fluid py-1" style="padding-bottom: 11.25rem !important;">
    <div class="container py-5">
        <h2 class="display-5 mb-2">Reset Password</h2>
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">

                @if (session('status'))
                    <div class="alert alert-success" role="alert" style="color:red;">
                        @if('We have emailed your password reset link.'==session('status'))
                        Please check your email for a link to reset your password. Go here to <a style="color: red;" href="{{route('login')}}">login</a>.
                        @else
                            {{ session('status') }}
                        @endif
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row g-1">
                        <div class="row g-3">
                            <!-- Email Field -->
                            <div class="col-lg-12">
                                <div class="form-floating">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Your Email" required>
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Submit Button -->
                            <div class="col-lg-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">{{ __('Send Password Reset Link') }}</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
