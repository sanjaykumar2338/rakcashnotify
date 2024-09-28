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
        <div class="container-fluid header position-relative overflow-hidden p-0">
            
            @include('frontend.mainsite.layouts.nav')

            <!-- Hero Header Start -->
            <div class="hero-header overflow-hidden px-5">
                <div class="rotate-img">
                    <img src="{{asset('asset/theme/img/sty-1.png')}}" class="img-fluid w-100" alt="">
                    <div class="rotate-sty-2"></div>
                </div>
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                        <h1 class="display-4 text-dark mb-4 wow fadeInUp" data-wow-delay="0.3s">Stay on top of Rakuten deals with our alert tool.</h1>
                        <p class="fs-4 mb-4 wow fadeInUp" data-wow-delay="0.5s">Your two alerts is FREE! Never miss out on savings again!</p>
                        <a href="#" class="btn btn-primary rounded-pill py-3 px-5 wow fadeInUp" data-wow-delay="0.7s">Get Started</a>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                        <img src="{{asset('asset/theme/img/hero-img-1.png')}}" class="img-fluid w-100 h-100" alt="">
                    </div>
                </div>
            </div>
            <!-- Hero Header End -->
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        <div class="container-fluid overflow-hidden py-5"  style="margin-top: 6rem;">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="RotateMoveLeft">
                            <img src="{{asset('asset/theme/img/about-1.png')}}" class="img-fluid w-100" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <h4 class="mb-1 text-primary">About Us</h4>
                        <p class="fs-4 mb-4 wow fadeInUp">{{env('APP_NAME')}} simplifies tracking Rakuten cash back, ensuring you know the best time to shop. It's effortless and keeps you informed!</p>
                        </p>
                        <a href="#" class="btn btn-primary rounded-pill py-3 px-5">About More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Feature Start -->
        <div class="container-fluid feature overflow-hidden py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h4 class="text-primary">Our Feature</h4>
                    <p class="fs-4 mb-4 wow fadeInUp">RakCashNotify is your ultimate tool for staying on top of the best Rakuten cashback deals. By simply signing up, you can customize your preferences to receive timely notifications via email or SMS when your favorite stores offer significant cashback. Our platform ensures you never miss out on savings, providing a seamless and straightforward way to shop smarter. With RakCashNotify, you're always in the know, making it easier to maximize your earnings and shop with confidence. Join today and take control of your savings with personalized alerts tailored to your shopping habits.
                    </p>
                </div>
            </div>
        </div>
        <!-- Feature End -->


        <!-- FAQ Start -->
        <div class="container-fluid FAQ bg-light overflow-hidden py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                <h4 class="text-primary">Faqs</h4>
            </div>

            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                       <div class="accordion" id="accordionExample">
                            
                            @foreach($faq as $key=>$q)
                                <div class="accordion-item border-0 mb-4">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseTOne">
                                            {!! $q->title !!}
                                        </button>
                                    </h2>
                                    <div id="collapseOne{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body my-2">
                                            {!! $q->description !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                       </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                        <div class="FAQ-img RotateMoveRight rounded">
                            <img src="{{asset('asset/theme/img/about-1.png')}}" class="img-fluid w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FAQ End -->


        <!-- Pricing Start -->
        <div class="container-fluid price py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h4 class="text-primary">Pricing Plan</h4>
                    <h1 class="display-5 mb-4">Not Sure Which Plan Is For You?</h1>
                    <p class="mb-0">Dolor sit amet consectetur, adipisicing elit. Ipsam, beatae maxime. Vel animi eveniet doloremque reiciendis soluta iste provident non rerum illum perferendis earum est architecto dolores vitae quia vero quod incidunt culpa corporis, porro doloribus. Voluptates nemo doloremque cum.
                    </p>
                </div>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="price-item bg-light rounded text-center">
                            <div class="text-center text-dark border-bottom d-flex flex-column justify-content-center p-4" style="width: 100%; height: 160px;">
                                <p class="fs-2 fw-bold text-uppercase mb-0">BASIC</p>
                                <div class="d-flex justify-content-center">
                                    <strong class="align-self-start">$</strong>
                                    <p class="mb-0"><span class="display-5">00</span>/mo</p>
                                </div>                        
                            </div>
                            <div class="text-start p-5">
                                <p><i class="fas fa-check text-success me-1"></i> Limited Acess Library</p>
                                <p><i class="fas fa-check text-success me-1"></i> Customer Support</p>
                                <p><i class="fas fa-check text-success me-1"></i> Pre-built Email Templates</p>
                                <p><i class="fas fa-check text-success me-1"></i> Reporting & Analytics</p>
                                <p><i class="fas fa-check text-success me-1"></i> Forms & Landing Pages</p>
                                <p><i class="fas fa-check text-success me-1"></i> A/B Testing</p>
                                <p><i class="fas fa-check text-success me-1"></i> Email Scheduling</p>
                                <p><i class="fas fa-check text-success me-1"></i> Automated Customer Journeys</p>
                                <p><i class="fas fa-times text-danger me-1"></i> Creative Assistant</p>
                                <p class="mb-4"><i class="fas fa-times text-danger me-1"></i> Role-based Access</p>
                                <button class="btn btn-light rounded-pill py-2 px-5" type="button">Get Started</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="price-item bg-light rounded text-center">
                            <div class="pice-item-offer">Popular</div>
                            <div class="text-center text-primary border-bottom d-flex flex-column justify-content-center p-4" style="width: 100%; height: 160px;">
                                <p class="fs-2 fw-bold text-uppercase mb-0">Standard</p>
                                <div class="d-flex justify-content-center">
                                    <strong class="align-self-start">$</strong>
                                    <p class="mb-0"><span class="display-5">1.99</span>/mo</p>
                                </div>                        
                            </div>
                            <div class="text-start p-5">
                                <p><i class="fas fa-check text-success me-1"></i> Limited Acess Library</p>
                                <p><i class="fas fa-check text-success me-1"></i> Customer Support</p>
                                <p><i class="fas fa-check text-success me-1"></i> Pre-built Email Templates</p>
                                <p><i class="fas fa-check text-success me-1"></i> Reporting & Analytics</p>
                                <p><i class="fas fa-check text-success me-1"></i> Forms & Landing Pages</p>
                                <p><i class="fas fa-check text-success me-1"></i> A/B Testing</p>
                                <p><i class="fas fa-check text-success me-1"></i> Email Scheduling</p>
                                <p><i class="fas fa-check text-success me-1"></i> Automated Customer Journeys</p>
                                <p><i class="fas fa-times text-danger me-1"></i> Creative Assistant</p>
                                <p class="mb-4"><i class="fas fa-times text-danger me-1"></i> Role-based Access</p>
                                <button class="btn btn-light rounded-pill py-2 px-5" type="button">Get Started</button>
                                
                                <a href="{{ route('subscription.create', 'P-4CJ65461T4509580WM3ZP5DY') }}">Subscribe Now</a>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="price-item bg-light rounded text-center">
                            <div class="text-center text-secondary border-bottom d-flex flex-column justify-content-center p-4" style="width: 100%; height: 160px;">
                                <p class="fs-2 fw-bold text-uppercase mb-0">Premium</p>
                                <div class="d-flex justify-content-center">
                                    <strong class="align-self-start">$</strong>
                                    <p class="mb-0"><span class="display-5">4.99</span>/mo</p>
                                </div>                        
                            </div>
                            <div class="text-start p-5">
                                <p><i class="fas fa-check text-success me-1"></i> Limited Acess Library</p>
                                <p><i class="fas fa-check text-success me-1"></i> Customer Support</p>
                                <p><i class="fas fa-check text-success me-1"></i> Pre-built Email Templates</p>
                                <p><i class="fas fa-check text-success me-1"></i> Reporting & Analytics</p>
                                <p><i class="fas fa-check text-success me-1"></i> Forms & Landing Pages</p>
                                <p><i class="fas fa-check text-success me-1"></i> A/B Testing</p>
                                <p><i class="fas fa-check text-success me-1"></i> Email Scheduling</p>
                                <p><i class="fas fa-check text-success me-1"></i> Automated Customer Journeys</p>
                                <p><i class="fas fa-times text-danger me-1"></i> Creative Assistant</p>
                                <p class="mb-4"><i class="fas fa-times text-danger me-1"></i> Role-based Access</p>
                                <button class="btn btn-light rounded-pill py-2 px-5" type="button">Get Started</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pricing End -->
        
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

    <div id="paypal-button-container-P-4120624135486332GM3ZP53Y"></div>

<script src="https://www.paypal.com/sdk/js?client-id=ATTC6HT1v7miPRyQwTF2UCCGaOaKYi4azDFOY6qzS5CHTV6tTtQZPm-A3Q4-s8-S_5uXhHgNshk7SWsS&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>

<script>
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'paypal'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-4120624135486332GM3ZP53Y',
          application_context: {
              return_url: '{{ route("subscription.success") }}',  // The URL for a successful payment
              cancel_url: '{{ route("subscription.cancel") }}'    // The URL for a canceled subscription
          }
        });
      },
      onApprove: function(data, actions) {
        alert('Subscription successful! Subscription ID: ' + data.subscriptionID); // Optional success message
      }
  }).render('#paypal-button-container-P-4120624135486332GM3ZP53Y'); // Renders the PayPal button
</script>


</html>