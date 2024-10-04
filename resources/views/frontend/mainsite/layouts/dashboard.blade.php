<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>{{env('APP_NAME2')}} - Stay on Top of Rakuten Deals | Free Alerts for Cashback Savings!</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="description" content="Get notified of the latest Rakuten cashback offers with our free alert tool. Never miss a deal and maximize your savings. Sign up for 2 free alerts today with RakCashNotify!">
        <meta name="keywords" content="Rakuten deals, cashback alerts, savings tool, online shopping, free alerts, Rakuten savings, best deals">
        <meta name="author" content="RakCashNotify">
        <meta name="robots" content="index, follow">
        <meta name="language" content="English">
        <meta name="revisit-after" content="7 days">
        <meta name="distribution" content="global">

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

        <!-- Favicon -->
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
    <script src="{{asset('asset/theme/js/main.js')}}?v={{time()}}"></script>

     <!-- ========== End footer ========== -->
     <script id="form_fields" type="text/javascript" src="{{ asset('asset/frontend/test/js/script.js') }}?v={{time()}}"></script>
    <script>
        'undefined' === typeof _trfq || (window._trfq = []);
        'undefined' === typeof _trfd && (window._trfd = []), _trfd.push({
            'tccl.baseHost': 'secureserver.net'
        }, {
            'ap': 'cpbh-mt'
        }, {
            'server': 'p3plmcpnl499668'
        }, {
            'dcenter': 'p3'
        }, {
            'cp_id': '7410277'
        }, {
            'cp_cache': ''
        }, {
            'cp_cl': '6'
        }) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.
    </script>
    <script async src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/intlTelInput.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        // Function to show loader
        function showLoader() {
            const select = document.getElementById('store');
            const option = document.createElement('option');
            option.textContent = 'Loading...';
            select.appendChild(option);
        }

        // Function to hide loader and show default text
        function hideLoaderAndShowDefault(defaultText) {
            const select = document.getElementById('store');
            // Remove any existing "Loading..." option
            const loadingOption = select.querySelector('option[value=""]');
            if (loadingOption) {
                select.removeChild(loadingOption);
            }

            // Check if "Type store name" option already exists
            let defaultOption = select.querySelector('option[value=""]');
            if (!defaultOption) {
                // Create and append the "Type store name" option
                defaultOption = document.createElement('option');
                defaultOption.value = '';
                select.insertBefore(defaultOption, select.firstChild);
            }
            // Update the text content of the default option
            defaultOption.textContent = defaultText;
            defaultOption.disabled = true;
            defaultOption.selected = true;

            if ($('#current_store_id').length) {
                $('#store').val($('#current_store_id').val()).trigger('change');
            }
        }

        function initializeSelect2() {
            $('#store').select2();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 when the page is loaded
            initializeSelect2();

            // Function to load stores via AJAX
            function loadStores() {
                //showLoader();
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/get_stores', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);

                            const select = document.getElementById('store');                
                            // Remove existing options before appending new ones
                            while (select.firstChild) {
                                select.removeChild(select.firstChild);
                            }

                            if (response.stores.length > 0) {
                                const select = document.getElementById('store');
                                const fragment = document.createDocumentFragment();

                                response.stores.forEach(function(store) {
                                    const option = document.createElement('option');
                                    option.value = store.store_id;
                                    option.textContent = store.store_name;
                                    fragment.appendChild(option);
                                });

                                select.appendChild(fragment);
                            }                          

                            // Reinitialize Select2 after data is loaded
                            $('#store').select2();
                            hideLoaderAndShowDefault('Type store name');
                        }
                    }
                };
                xhr.send();
            }

            // Load stores when the page is loaded
            loadStores();
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.overflowX = 'hidden';
        });
    </script>
    @stack('scripts')
    </body>

</html>