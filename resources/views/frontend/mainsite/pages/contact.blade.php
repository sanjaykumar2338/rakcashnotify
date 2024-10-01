<!-- Contact Start -->
@extends('frontend.mainsite.layouts.common')
@section('content')
<div class="container-fluid py-1">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                <span class="error">{{ session('error') }}</span>
                            </div>
                            <br>
                        @endif

                        @if(session('success'))
                            <div id="success-message" style="background-color: #d4edda; color: #155724; border-color: #c3e6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h2 class="display-5 mb-2">Our Contact Form</h2>
                        <form method="post" action="{{route('contact.save')}}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-floating">
                                        <input type="phone" class="form-control" name="phone" placeholder="Phone">
                                        <label for="phone">Your Phone</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" name="message" style="height: 160px"></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3">Send Message</button>
                                </div>

                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                            </div>
                        </form>
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