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
use App\Models\User;
use App\Models\UserSubscription;

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

    public function handleSubscriptionUpdated(Request $request)
    {
        // Log the webhook payload for debugging (optional)
        \Log::info('PayPal Webhook - Subscription Updated: ', $request->all());

        // Validate that the request came from PayPal
        // PayPal provides a way to validate the webhook payloads via signature

        // Process the webhook payload
        $event = $request->input('event_type');
        $subscriptionData = $request->input('resource');

        if ($event === 'BILLING.SUBSCRIPTION.UPDATED') {
            $paypalSubscriptionId = $subscriptionData['id'];
            $status = $subscriptionData['status'];
            $valid_to = $subscriptionData['billing_info']['next_billing_time'];

            // Find the subscription in the database
            $subscription = UserSubscription::where('paypal_subscr_id', $paypalSubscriptionId)->first();

            if ($subscription) {
                // Update subscription status and valid to date
                $subscription->update([
                    'status' => $status,
                    'valid_to' => (new \DateTime($valid_to))->format("Y-m-d H:i:s"),
                    'modified' => now()
                ]);
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
