<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;

use App\Models\Plans;
use App\Models\User;
use App\Models\UserSubscription;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Http;
use PayPalHttp\HttpException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Stripe\Plan;
use Auth;

class PaypalSubscriptionController extends Controller
{
    protected $provider;
    protected $paypalAuthAPI;
    protected $paypalProductAPI;
    protected $paypalBillingAPI;
    protected $paypalSecret;
    protected $sandbox;

    public function __construct() {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->sandbox = env('PAYPAL_SANDBOX');

        $this->paypalAuthAPI = $this->sandbox ? 'https://api-m.sandbox.paypal.com/v1/oauth2/token' : 'https://api-m.paypal.com/v1/oauth2/token';
        $this->paypalProductAPI = $this->sandbox ? 'https://api-m.sandbox.paypal.com/v1/catalogs/products' : 'https://api-m.paypal.com/v1/catalogs/products';
        $this->paypalBillingAPI = $this->sandbox ? 'https://api-m.sandbox.paypal.com/v1/billing' : 'https://api-m.paypal.com/v1/billing';
        $this->paypalClientID = env('PAYPAL_CLIENT_ID');
        $this->paypalSecret = env('PAYPAL_CLIENT_SECRET');
    }

    public function createSubscription($planId) {
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
            echo "<pre>";
            print_r($subscription);
            die;

            // Redirect to the PayPal approval URL
            return redirect($subscription['links'][0]['href']);
        } catch (HttpException $ex) {
            return redirect()->back()->with('error', 'Failed to create subscription.');
        }
    }

    public function success(Request $request) {
        // Handle successful subscription logic
        return view('subscription.success');
    }

    public function cancel() {
        // Handle subscription cancellation logic
        return view('subscription.cancel');
    }

    public function generateAccessToken() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paypalAuthAPI);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypalClientID.":".$this->paypalSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $auth_response = json_decode(curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code != 200 && !empty($auth_response->error)) {
            throw new \Exception('Failed to generate Access Token: '.$auth_response->error.' >>> '.$auth_response->error_description);
        }

        if (!empty($auth_response)) {
            return $auth_response->access_token;
        } else {
            return false;
        }
    }

    public function createPlan() {
        $planInfo1 = \DB::table('plans')->where('id', 3)->first();
        $planInfo = (array)$planInfo1; // Cast the object to an array

        $accessToken = $this->generateAccessToken();
        if (empty($accessToken)) {
            return false;
        } else {
            $postParams = array(
                "name" => $planInfo['name'],
                "type" => "DIGITAL",
                "category" => "SOFTWARE"
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->paypalProductAPI);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.$accessToken));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParams));
            $api_resp = curl_exec($ch);
            $pro_api_data = json_decode($api_resp);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code != 200 && $http_code != 201) {
                return 'Failed to create Product ('.$http_code.'): '.$api_resp;
            }

            if (!empty($pro_api_data->id)) {
                $formattedPrice = number_format($planInfo['price'], 2);

                $postParams = array(
                    "product_id" => $pro_api_data->id,
                    "name" => $planInfo['name'],
                    "billing_cycles" => array(
                        array(
                            "frequency" => array(
                                "interval_unit" => $planInfo['interval'],
                                "interval_count" => $planInfo['interval_count']
                            ),
                            "tenure_type" => "REGULAR",
                            "sequence" => 1,
                            "total_cycles" => 999,
                            "pricing_scheme" => array(
                                "fixed_price" => array(
                                    "value" => $formattedPrice,
                                    "currency_code" => env('PAYPAL_CURRENCY')
                                )
                            ),
                        )
                    ),
                    "payment_preferences" => array(
                        "auto_bill_outstanding" => true
                    )
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->paypalBillingAPI.'/plans');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.$accessToken));
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParams));
                $api_resp = curl_exec($ch);
                $plan_api_data = json_decode($api_resp, true);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($http_code != 200 && $http_code != 201) {
                    return 'Failed to create Product ('.$http_code.'): '.$api_resp;
                }

                return !empty($plan_api_data) ? $plan_api_data : false;
            } else {
                return false;
            }
        }
    }

    public function getSubscription($subscription_id) {
        $accessToken = $this->generateAccessToken();
        if (empty($accessToken)) {
            return false;
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->paypalBillingAPI.'/subscriptions/'.$subscription_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.$accessToken));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $api_data = json_decode(curl_exec($ch), true);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code != 200 && !empty($api_data['error'])) {
                throw new Exception('Error '.$api_data['error'].': '.$api_data['error_description']);
            }

            return !empty($api_data) && $http_code == 200 ? $api_data : false;
        }
    }

    public function cancelSubscription($subscription_id)
    {
        $subscription = UserSubscription::findOrFail($subscription_id);

        // Handle free plan cancellation locally
        if ($subscription->plan->price == 0) {
            $subscription->update(['status' => 'INACTIVE']);
            return redirect(url('/#plans'))->with('success', 'Free plan canceled successfully.');
        }

        // For paid plans, cancel the subscription via PayPal
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');
        $paypalApiUrl = env('PAYPAL_API_URL');

        try {
            $response = Http::withBasicAuth($clientId, $clientSecret)
                ->asForm()
                ->post("{$paypalApiUrl}/v1/oauth2/token", [
                    'grant_type' => 'client_credentials',
                ]);

            $accessToken = $response->json()['access_token'];

            // Cancel the subscription in PayPal
            $cancelResponse = Http::withToken($accessToken)
                ->post("{$paypalApiUrl}/v1/billing/subscriptions/{$subscription->paypal_subscr_id}/cancel", [
                    'reason' => 'User requested cancellation.',
                ]);

            if ($cancelResponse->successful()) {
                $subscription->update(['status' => 'INACTIVE']);
                return redirect(url('/#plans'))->with('success', 'Subscription canceled successfully.');
            } else {
                return redirect(url('/#plans'))->with('error', 'Failed to cancel subscription in PayPal.');
            }

        } catch (\Exception $e) {
            return redirect(url('/#plans'))->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }

    public function savesubscription(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return response()->json(['status' => 0, 'msg' => 'User is not logged in.', 'cancel_url' => $request->input('cancel_url')]);
        }

        // Validate incoming data
        $request->validate([
            'order_id' => 'required|string',
            'subscription_id' => 'required|string',
            'plan_id' => 'required'
        ]);

        $order_id = $request->input('order_id');
        $subscription_id = $request->input('subscription_id');
        $db_plan_id = $request->input('plan_id');
        $return_url = $request->input('return_url');
        $cancel_url = $request->input('cancel_url');

        // PayPal API credentials
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');
        $paypalApiUrl = env('PAYPAL_API_URL');

        // Get PayPal OAuth token
        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post("{$paypalApiUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        try {
            // Retrieve the subscription details from PayPal
            $subscr_data = Http::withToken($response->json()['access_token'])
                ->acceptJson()
                ->get("{$paypalApiUrl}/v1/billing/subscriptions/{$subscription_id}");
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => $e->getMessage(), 'cancel_url' => $cancel_url]);
        }

        if (!empty($subscr_data)) {
            $status = $subscr_data['status'];
            $subscr_id = $subscr_data['id'];
            $plan_id = $subscr_data['plan_id'];
            $created = (new DateTime($subscr_data['create_time']))->format("Y-m-d H:i:s");
            $valid_from = (new DateTime($subscr_data['start_time']))->format("Y-m-d H:i:s");

            // Get subscriber info
            $subscriber_email = $subscr_data['subscriber']['email_address'] ?? null;
            $subscriber_id = $subscr_data['subscriber']['payer_id'] ?? null;
            $subscriber_name = trim($subscr_data['subscriber']['name']['given_name'] ?? '') . ' ' . trim($subscr_data['subscriber']['name']['surname'] ?? '');

            // Use the authenticated user
            $user = Auth::user();

            $outstanding_balance_value = $subscr_data['billing_info']['outstanding_balance']['value'] ?? null;
            $last_payment_amount = $subscr_data['billing_info']['last_payment']['amount']['value'] ?? null;
            $last_payment_currency = $subscr_data['billing_info']['last_payment']['amount']['currency_code'] ?? null;
            $valid_to = (new DateTime($subscr_data['billing_info']['next_billing_time']))->format("Y-m-d H:i:s");

            // Check for existing subscription for the logged-in user
            $existing_subscription = UserSubscription::where('user_id', $user->id)
                ->where('paypal_subscr_id', $subscr_id)
                ->first();

            // Handle PayPal plan to local DB plan mapping
            $db_plan_id = env('PAYPAL_MODE') == 'sandbox'
                ? Plans::where('dev_plan_id', $db_plan_id)->first()->id
                : Plans::where('live_plan_id', $db_plan_id)->first()->id;

            if (!$existing_subscription) {
                // Create a new subscription if it doesn't exist
                $new_subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $db_plan_id,
                    'paypal_order_id' => $order_id,
                    'paypal_plan_id' => $plan_id,
                    'paypal_subscr_id' => $subscr_id,
                    'valid_from' => $valid_from,
                    'valid_to' => $valid_to,
                    'paid_amount' => $last_payment_amount,
                    'currency_code' => $last_payment_currency,
                    'subscriber_id' => $subscriber_id,
                    'subscriber_name' => $subscriber_name,
                    'subscriber_email' => $subscriber_email,
                    'status' => $status,
                    'created' => $created,
                    'modified' => now()
                ]);

                // Update user's subscription reference
                $user->subscription_id = $new_subscription->id;
                $user->save();
            } else {
                // If the subscription exists, update the relevant information
                $existing_subscription->update([
                    'valid_to' => $valid_to,
                    'status' => $status,
                    'paid_amount' => $last_payment_amount,
                    'modified' => now()
                ]);
            }

            // Redirect to success page
            return response()->json(['status' => 1, 'msg' => 'Subscription created!', 'return_url' => $return_url]);

        } else {
            // If subscription data is empty, redirect to the cancel URL
            return response()->json(['status' => 0, 'msg' => 'Subscription data not found.', 'cancel_url' => $cancel_url]);
        }
    }


    // Success subscription handler
    public function subscriptionSuccess()
    {
        $page = (object)['title' => 'Payment Success', 'description' => ''];
        return view('frontend.mainsite.pages.success', compact('page'));
    }

    // Failed subscription handler
    public function subscriptionFail()
    {
        $page = (object)['title' => 'Payment Failed', 'description' => ''];
        return view('frontend.mainsite.pages.fail', compact('page'));
    }

    public function subscribeFree()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if user already has an active subscription
        $existingSubscription = UserSubscription::where('user_id', $user->id)
            ->where('status', 'ACTIVE')
            ->first();

        // Prevent duplicate active subscriptions
        if ($existingSubscription) {
            return redirect(url('/#plans'))->with('error', 'You already have an active subscription.');
        }

        // Get the 'Free' plan from the plans table
        $freePlan = Plans::where('name', 'Basic')->first();

        // Validate if free plan exists
        if (!$freePlan) {
            return redirect(url('/#plans'))->with('error', 'Basic plan not found.');
        }

        // Create a new subscription for the user
        $subscription = UserSubscription::create([
            'user_id' => $user->id,
            'plan_id' => $freePlan->id, // Free plan ID
            'paypal_order_id' => null, // No PayPal order for free plan
            'paypal_plan_id' => null,
            'paypal_subscr_id' => null,
            'valid_from' => now(),
            'valid_to' => now()->addYears(100), // Set a distant future expiration for "forever free" plan
            'paid_amount' => 0.00,
            'currency_code' => 'USD',
            'subscriber_id' => $user->id,
            'subscriber_name' => $user->first_name . ' ' . $user->last_name,
            'subscriber_email' => $user->email,
            'status' => 'ACTIVE',
            'created' => now(),
            'modified' => now(),
        ]);

        // Return success message
        return redirect()->route('dashboard.index')->with('success', 'You have successfully subscribed to the free plan.');
    }

    public function payment_page(Request $request, $id) {
        $plan = \DB::table('plans')->where('id', $id)->first();
        $page = (object)['title' => 'Payment', 'description' => ''];
        $plan_id = env('PAYPAL_MODE') == 'sandbox' ? $plan->dev_plan_id : $plan->live_plan_id;
        return view('frontend.mainsite.pages.payment', compact('page', 'plan', 'plan_id'));
    }

    public function payment_status(Request $request) {
        $statusMsg = '';
        $status = 'error';

        // Check if the `checkout_ref_id` is present in the request
        if ($request->has('checkout_ref_id')) {
            // Decode the PayPal order ID
            $paypal_order_id = base64_decode($request->input('checkout_ref_id'));

            // Fetch subscription data from the database using Eloquent ORM
            $subscription = DB::table('user_subscriptions as S')
                ->leftJoin('plans as P', 'P.id', '=', 'S.plan_id')
                ->select('S.*', 'P.name as plan_name', 'P.price as plan_price', 'P.interval', 'P.interval_count')
                ->where('S.paypal_order_id', $paypal_order_id)
                ->first();

            // Check if subscription data is found
            if ($subscription) {
                $status = 'success';
                $statusMsg = 'Your Subscription Payment has been Successful!';
            } else {
                $statusMsg = 'Subscription has failed!';
            }
        } else {
            // Redirect to homepage if no reference ID is provided
            return redirect('/');
        }


        // Pass the status and message to the view
        return view('frontend.mainsite.pages.paymentstatus', [
            'status' => $status,
            'statusMsg' => $statusMsg,
            'subscription' => $subscription ?? null
        ]);
    }
}
