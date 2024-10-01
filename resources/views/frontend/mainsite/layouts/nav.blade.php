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
            <a href="{{url('/')}}#plans" class="nav-item nav-link">Plans</a>
            <a href="{{url('/')}}#faqs" class="nav-item nav-link">Faqs</a>
            <a href="{{url('contact')}}" class="nav-item nav-link">Contact Us</a>
        </div>
        @if(!auth()->check())
            <a href="{{route('login')}}" class="btn btn-light border border-primary rounded-pill text-primary py-2 px-4 me-4">Log In</a>
            <a href="{{route('register')}}" class="btn btn-primary rounded-pill text-white py-2 px-4">Sign Up</a>
        @else
            <a href="{{url('dashboard')}}" class="btn btn-primary rounded-pill text-white py-2 px-4">My Account</a>&nbsp;&nbsp;
            <a href="{{route('logout')}}" class="btn btn-primary rounded-pill text-white py-2 px-4">Logout</a>
        @endif
    </div>
</nav>