@extends('frontend.mainsite.layouts.common')
@section('content')

    <style>

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

    </style>

<div class="container-fluid py-1">
    <div class="container py-5">
        <h2 class="display-5 mb-2">Register</h2>
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">
                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                                @if (session('fullPhoneNumberError'))
                                    <li>{{ session('fullPhoneNumberError') }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-lg-6">
                            <label for="first_name"><b>First Name</b></label>
                            <input value="{{ old('first_name') }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" type="text" id="first_name" class="form-control" placeholder="Enter First Name" name="first_name" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-lg-6">
                            <label for="last_name"><b>Last Name</b></label>
                            <input value="{{ old('last_name') }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" type="text" id="last_name" class="form-control" placeholder="Enter Last Name" name="last_name" required>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <!-- Phone Number -->
                        <div class="col-lg-6">
                            <label for="phone_number" class="mb-2"><b>Phone Number</b></label>
                            <input value="{{ old('phone_number') }}" oninput="this.value = this.value.replace(/[^\d]/g, '');" id="phone_number" class="form-control" type="text" name="phone_number" placeholder="Enter Phone Number" required>
                        </div>

                        <!-- Email -->
                        <div class="col-lg-6">
                            <label for="uname"><b>Email</b></label>
                            <input value="{{ old('email') }}" type="text" class="form-control" placeholder="Enter Email" name="email" required>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <!-- Password -->
                        <div class="col-lg-6">
                            <label for="psw"><b>Password</b></label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-lg-6">
                            <label for="psw"><b>Confirm Password</b></label>
                            <input type="password" class="form-control" placeholder="Enter Confirm Password" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <!-- Terms and Conditions Checkbox -->
                        <div class="col-lg-12">
                            <input type="checkbox" name="agree_terms_and_condition" required> By clicking on the Sign Up button below, you agree to our
                            <span style="cursor:pointer;text-decoration: underline;" onclick="window.location.href = '{{ route('terms') }}';">Terms & Conditions</span>
                            and have read our
                            <span style="cursor:pointer;text-decoration: underline;" onclick="window.location.href = '{{ route('privacy_policy') }}';">Privacy Policy</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Submit Button -->
                        <div class="col-lg-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Sign Up</button>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <!-- Forgot Password Link -->
                        <div class="col-lg-12 text-center">
                            Forgot your password? <a href="{{ route('password.request') }}">Reset Password</a>
                        </div>
                    </div>
                </form>

            </div>
            </div>
        </div>
    </div>

@endsection
