<?php

namespace App\Http\Controllers\Paypal;
use App\Http\Controllers\Controller;

use PayPalHttp\HttpException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalSubscriptionController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }

    public function createSubscription($planId)
    {
        $this->provider->getAccessToken();

        try {
            $subscription = $this->provider->createSubscription([
                'plan_id' => $planId,
                'application_context' => [
                    'return_url' => route('subscription.success'), // Redirect on success
                    'cancel_url' => route('subscription.cancel'),  // Redirect on cancel
                ],
            ]);

            // Debug the subscription to verify the response from PayPal
            echo "<pre>"; print_r($subscription); die;

            // Redirect to the PayPal approval URL
            return redirect($subscription['links'][0]['href']);
        } catch (HttpException $ex) {
            return redirect()->back()->with('error', 'Failed to create subscription.');
        }
    }

    public function success(Request $request)
    {
        // Handle successful subscription logic
        return view('subscription.success');
    }

    public function cancel()
    {
        // Handle subscription cancellation logic
        return view('subscription.cancel');
    }
}
