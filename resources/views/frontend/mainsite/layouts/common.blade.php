<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>{{env('APP_NAME2')}}</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{asset('asset/theme/lib/animate/animate.min.css')}}" rel="stylesheet">
        <link href="{{asset('asset/theme/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
        <link href="{{asset('asset/theme/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{asset('asset/theme/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{asset('asset/theme/css/style.css')}}" rel="stylesheet">

        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('asset/theme/img/fav.webp')}}">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-fluid p-0">
            @include('frontend.mainsite.layouts.nav')
        </div>
        <!-- Navbar & Hero End -->

        <!-- Header Start -->
        <div class="container-fluid">
           
            <div class="container text-center py-5" style="max-width: 900px;">
                <h3 class="display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">&nbsp;</h3>
            </div>
        </div>
        <!-- Header End -->


        @yield('content')
       
        
        <!-- Copyright Start -->
        @include('frontend.mainsite.layouts.footer')
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('asset/theme/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('asset/theme/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('asset/theme/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('asset/theme/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('asset/theme/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('asset/theme/lib/lightbox/js/lightbox.min.js')}}"></script>
    

    <!-- Template Javascript -->
    <script src="{{asset('asset/theme/js/main.js')}}"></script>
    </body>

</html>