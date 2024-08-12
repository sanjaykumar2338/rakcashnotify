@extends('frontend.layout.homepagenew')

@section('content')

    <style>
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

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }
        
        .text-danger {
            color: #dc3545; /* Red color for indicating danger */
            font-size: 14px; /* Adjust font size as needed */
            margin: 0 0 5px 0; /* Add spacing between the input field and error message */
            display: block; /* Ensure error message appears on a new line */
        }

        .iti.iti--allow-dropdown {
            width: 100%
        }

        .login-title {
            font-size: 4rem;
        }

        form {
            width: 100%
        }

        input[type=text], input[type=password], input[type=email] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 7px;
        }

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

        button:disabled {
            background-color: #cccccc; /* Change background color */
            color: #666666; /* Change text color */
            cursor: not-allowed; /* Change cursor style */
        }

        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
        }

        .invalid-feedback{
            color:red;
        }
    </style>

<section class="main-section full-container">
        <div class="container flex l-gap flex-mobile lr-m">
            @includeIf('frontend.layout.sidebar')
            <div class="page-content pg-l">
                <h1 class="page-title">Reset Password</h1>
                <style>
                    .error{
                        color: red;
                    }
                </style>

                <div class="page-content">
                <div>

                    @if(session('success'))
                        <div id="success-message" style="background-color: #d4edda; color: #155724; border-color: #c3e6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                    @csrf


                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul class="">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                    <br>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
