@extends('frontend.mainsite.layouts.common')
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

        .Login-form-submit-section {
            margin-top: 13px;
            font-weight: bolder;
            display: flex;
            align-content: center;
            gap: 5px;
        }

        .create-account-hover:hover {
            cursor: pointer;
        }

        .login-title {
            font-size: 4rem;
        }

        form {
            width: 100%
        }

        input[type=text], input[type=password] {
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

        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
        }

    </style>

<div class="container-fluid py-1">
    <div class="container py-5">
        <h2 class="display-5 mb-2">Login</h2>
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">
                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('message'))
                        <div class="alert alert-info">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="row g-1">
                    <div class="row g-3">
                        <!-- Email Field -->
                        <div class="col-lg-12">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                <label for="email">Your Email</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Password Field -->
                        <div class="col-lg-12">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Submit Button -->
                        <div class="col-lg-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Login</button>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Forgot Password and Register Section -->
                        <div class="col-lg-12 text-center">
                            <span>Don't have an account yet? <a href="{{ route('register.form') }}">Create Account</a></span>
                            <br>
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot your password?</a>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>

@endsection
