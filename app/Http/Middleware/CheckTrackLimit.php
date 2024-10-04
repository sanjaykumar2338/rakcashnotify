<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTrackLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        $user = Auth::user();

        // Get the latest active subscription for the user, ensuring it's within the valid date range
        $subscription = $user->subscriptions()
            ->with('plan')
            ->where('status', 'ACTIVE') // Fetch only active subscriptions
            ->whereDate('valid_from', '<=', now()) // Ensure the subscription is valid from the start date
            ->whereDate('valid_to', '>=', now()) // Ensure the subscription is still valid
            ->latest()
            ->first();

        // Check if the user has a valid active subscription
        if ($subscription && $subscription->plan) {
            $currentPlan = $subscription->plan->name;

            // Define track limits based on the user's active plan
            $trackLimitByPlan = [
                'Basic' => 1,
                'Standard' => 20,
                'Premium' => 5000,
            ];

            // Check if the user's plan has a defined track limit
            if (isset($trackLimitByPlan[$currentPlan])) {
                $trackLimit = $trackLimitByPlan[$currentPlan];

                // If the user's track count exceeds the limit, redirect with a message
                if ($user->tracks()->count() >= $trackLimit) {
                    return redirect()
                        ->route('track')
                        ->with('plan_error', 'You have reached your maximum number of alerts. Please visit your My Account page to edit or remove current alerts, or upgrade your plan.')
                        ->with('current_plan', $currentPlan);
                }
            }
        } else {
            // Redirect if the user has no valid or active subscription
            return redirect()
                ->route('track')
                ->with('no_plan_error', 'To access all features, please subscribe to a valid plan.');
        }

        // Allow request to continue if within the track limit and subscription is valid
        return $next($request);
    }
}
