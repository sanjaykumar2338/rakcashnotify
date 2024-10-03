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

class CashbackController extends Controller
{
    public function index() {
        $faq = Faqs::orderBy('order','asc')->get();
        $user = auth()->check();
        $subscription = '';
        if ($user) $subscription = \auth()->user()->subscriptions()->with('plan')->latest()->first();
        return view('frontend.mainsite.layouts.main', compact('faq', 'subscription'));
    }

    public function contact() {
        $contact = Pages::where('slug', 'contact-us')->first();
        $faq = Faqs::orderBy('order','asc')->get();
        return view('frontend.mainsite.pages.contact')->with('faq', $faq)->with('page', $contact);
    }

    public function privacy_policy() {
        $faq = Faqs::orderBy('order','asc')->get();
        return view('frontend.mainsite.pages.contact')->with('faq', $faq);
    }
}
