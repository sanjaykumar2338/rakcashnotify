<?php

namespace App\Http\Controllers;

use App\Models\BlogReview;
use App\Models\Pages;
use App\Models\Plans;
use App\Models\Faqs;
use App\Models\Contacts;
use App\Models\PrintfulOrder;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Rules\ReCaptchaV3;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $homepage = Pages::where('slug', 'homepage')->first();
        return view('frontend.pages.home')->with('page', $homepage);
    }

    public function contactus() {
        $contact = Pages::where('slug', 'contact-us')->first();
        return view('frontend.pages.contactus')->with('page', $contact);
    }

    public function aboutus() {
        $aboutus = Pages::where('slug', 'about-us')->first();
        return view('frontend.pages.aboutus')->with('page', $aboutus);
    }

    public function track() {
        $track = Pages::where('slug', 'track')->first();
        $stores = DB::table('stores')
            ->orderByRaw("CASE WHEN store_name REGEXP '^[A-Za-z]' THEN 0 ELSE 1 END")
            ->orderBy('store_name', 'asc')
            ->where('store_name', '!=', '')
            ->get();

        $user = Auth::user();
        //echo "<pre>"; print_r($user->tracks()->get()); die;
        $all_tracks = $user->tracks()->get();


        $plans = Plans::get();

        $plansArray = [];
        foreach ($plans as $plan) {
            $plansArray[$plan->identifier] = $plan;
        }

        $currentPlanName = '';

        $user = auth()->user();
        $userSubscribed = $user->subscriptions();

        $user = auth()->check();
        $subscription = '';
        if ($user) $subscription = \auth()->user()->subscriptions()->with('plan')->latest()->first();
        //echo "<pre>"; print_r($subscription); die;
        $currentPlanName = $subscription->plan->name;

        return view('frontend.mainsite.pages.track')->with('page', $track)->with('stores', $stores)->with('all_tracks',$all_tracks)->with('currentPlanName',$currentPlanName);
    }

    public function get_stores() {
        $stores = DB::table('stores')
            ->orderByRaw("CASE WHEN store_name REGEXP '^[A-Za-z]' THEN 0 ELSE 1 END")
            ->orderBy('store_name', 'asc')
            ->where('store_name', '!=', '')
            ->get();

        return response()->json(['stores' => $stores]);
    }

    public function faq() {
        $page = Pages::where('slug', 'faq')->first();
        $faq = Faqs::orderBy('order','asc')->get();
        return view('frontend.pages.faq')->with('faq', $faq)->with('page', $page);
    }

    public function terms() {
        $terms = Pages::where('slug', 'terms-and-conditions')->first();
        return view('frontend.mainsite.pages.content')->with('page', $terms);
    }

    public function privacy_policy() {
        $terms = Pages::where('slug', 'privacy-policy')->first();       
        return view('frontend.mainsite.pages.content')->with('page', $terms);
    }

    public function shop2() {
        return view('frontend.pages.shop');
    }

    public function media() {
        return view('frontend.pages.media');
    }

    public function myprofile(){
        return view('frontend.pages.setting')->with('activeLink', 'myprofile');
    }

    public function profile_update(Request $request){
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^\+?[0-9]+$/',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Normalize phone number (add '+' if missing)
        $phoneNumber = $request->input('phone_number');
        if ($phoneNumber[0] !== '+') {
            $phoneNumber = '+' . $phoneNumber;
        }

        // Get the authenticated user
        $user = Auth::user();

        // Update user profile data
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $phoneNumber,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->input('password')),
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function blog() {
        $blogs = Blogs::all();
        foreach ($blogs as $blog) {
            $blog->feature_image = fileToUrl($blog->feature_image);
            $blog->blog_image = fileToUrl($blog->blog_image);
        }

        return view('frontend.pages.blog')->with('blogs', $blogs);
    }

    public function blog_detail(Request $request) {
        $slug = $request->slug;
        $blog = Blogs::where('slug', $slug)->first();
        $blog->feature_image = fileToUrl($blog->feature_image);
        $blog->blog_image = fileToUrl($blog->blog_image);

        $reviews = BlogReview::where('blog_id', $blog->id)->where('status', 1)->get();
        //echo "<pre>"; print_r($blog); die;
        return view('frontend.layout.blogtemplate')->with('blog', $blog)->with('reviews', $reviews);
    }

    public function justice() {
        return view('frontend.pages.justice');
    }

    public function pricing() {
        return view('frontend.pages.pricing');
    }

    public function plandetails(Request $request, $id = null) {
        
        $plan = \DB::table('plans')->where('id', $id)->first();
        if (!$plan) {
            return redirect()->back()->with('success', 'No plan found!!!');
        }

        $planPrices = [
            'free' => 0,
            'basic' => 3.99,
            'premium' => 9.99,
        ];

        $planPrice = $planPrices[$plan->identifier] ?? 0;

        $planId = $plan->id;

        $userIntent = auth()->user()->createSetupIntent();

        return view('frontend.pages.pricingdetails', compact('planId', 'userIntent', 'planPrice','plan'));
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required',
        ]);

        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
        ]);

        $responseData = $response->json();

        if (!$responseData['success'] || $responseData['score'] < 0.5) {
            return back()->withErrors(['captcha' => 'ReCAPTCHA verification failed. Please try again.']);
        }

        // Create a new contact record
        Contacts::create($request->except('g-recaptcha-response'));

        // Send emails
        Mail::to('sk963070@gmail.com')->send(new ContactMail($request->all()));

        // Redirect back to the contact page with a success message
        return redirect()->back()->with('success', 'We have received your message and will get back to you soon.');
    }

    public function products() {
        return view('frontend.pages.products');
    }

    public function events() {
        return view('frontend.pages.events');
    }

    public function track_order() {
        return view('frontend.pages.track_order');
    }

    public function shipping() {
        return view('frontend.pages.shipping');
    }

    public function wishlist() {
        return view('frontend.pages.wishlist');
    }

    public function my_account() {
        if (auth()->user()->role == 1) {
            return redirect('admin');
        } else {
            $email = auth()->user()->email;
            $orders = PrintfulOrder::join('users', 'users.email', '=', 'printful_orders.customer_email')->join('products', 'products.id', '=', 'printful_orders.product_id')->join('payments', 'payments.id', '=', 'printful_orders.payment_id')->select('products.*', 'printful_order_data', 'payment_intent_id', 'payments.amount as amt')->where('printful_orders.customer_email', $email)->paginate(5);
            //echo "<pre>"; print_r($orders); die;
            //$orders = PrintfulOrder::join('users', 'users.id', '=', 'printful_orders.user_id')->paginate(5);
            //$orders = Payment::join('users', 'users.id', '=', 'payments.user_id')->select('payments.*', 'users.name')->paginate(5);
            return view('frontend.pages.my_account')->with('activeLink', 'orders')->with('orders', $orders);
        }
    }

    public function order_history() {
        return view('frontend.pages.order_history');
    }

    public function return_order() {
        return view('frontend.pages.return_order');
    }

    public function donate_now() {
        return view('frontend.pages.donate_now');
    }

    public function login() {
        return view('frontend.mainsite.pages.login');
    }

    public function register() {
        return view('frontend.mainsite.pages.register');
    }

    public function webhook(Request $request){
        Log::info('Received request', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'parameters' => $request->all(),
        ]);

        return 'done';
    }
}
