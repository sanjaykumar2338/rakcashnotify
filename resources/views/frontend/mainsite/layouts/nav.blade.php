<nav class="navbar navbar-expand-lg fixed-top navbar-light px-4 px-lg-5 py-3 py-lg-0">
    <a href="{{url('/')}}" class="navbar-brand p-0">
        <img src="{{asset('asset/theme/img/logo.png')}}" alt="{{env('APP_NAME')}}">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="{{url('/')}}" class="nav-item nav-link active">Home</a>
            <a href="about.html" class="nav-item nav-link">Plans</a>
            <a href="service.html" class="nav-item nav-link">Faqs</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0">
                    <a href="{{route('privacy_policy')}}" class="dropdown-item">Terms and Conditions</a>
                    <a href="{{route('terms')}}" class="dropdown-item">Privacy Policy</a>
                </div>
            </div>
            <a href="{{url('contact')}}" class="nav-item nav-link">Contact Us</a>
        </div>
        <a href="#" class="btn btn-light border border-primary rounded-pill text-primary py-2 px-4 me-4">Log In</a>
        <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4">Sign Up</a>
    </div>
</nav>