<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Services\StripeService;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class SubscriptionCheckoutController extends Controller
{
    public function checksub(Request $request)
    {
        $user = $request->user();
        // return $user->subscribed('default');

        Stripe::setApiKey(config('services.stripe.secret'));

        if ($user->subscribed('default')) {
                $stripeSubscription = \Stripe\Subscription::retrieve($user->subscription('default')->stripe_id);

                // Update local database if subscription status has changed in Stripe
                if ($stripeSubscription->status !== $user->subscription('default')->stripe_status) {
                    // Update user's subscription status in local database
                    $user->subscription('default')->update(['stripe_status' => $stripeSubscription->status]);
                    if($stripeSubscription->status == "canceled") {
                        $user->is_subscribed = 0;
                        $user->subscription_plan = null;
                        $user->subscription('default')->update(['ends_at' => now()]);
                        $user->save();
                        return redirect()->route('subscribed');
                    }
                }
                else{
                    return redirect()->route('subscribed');
                }
        } else {
            return redirect()->route('billing');  // Handle case where user is not subscribed
        }
    }

    public function index(Request $request){

        return view('user.billing');
    }
    public function getPaymentMethodId(Request $request ,$plan){

        $user = $request->user();

        // Define mapping of plans to their names
        $planMapping = [
            "price_1PWhn8Rsway4zlmUEa4UWwnJ" => "Premium and TV Plan",
            "price_1PWhmTRsway4zlmUNg00KkOU" => "Premium Plan",
            "price_1PWhkhRsway4zlmUJUYPsdck" => "Regular Plan",
        ];

        // Validate and map the plan parameter
        if (array_key_exists($plan, $planMapping)) {
            $subscription_plan = $planMapping[$plan];
        } else {
            // Handle invalid plan case
            return redirect()->route('billing');
        }

        return view('plan', [
            'user' => $user,
            'plan' => $plan,
            'plan_name' => $subscription_plan,
        ]);
    }
    public function checkout(Request $request, $plan)
    {
        $user = $request->user();

        // Ensure the user is authenticated
        if (!$user) {
            return redirect()->route('login'); // Redirect to login if the user is not authenticated
        }

        // Create a setup intent for the user
        $user->createSetupIntent();

        // Retrieve paymentMethodId from request input
        $paymentMethodId = $request->input('paymentMethodId');

        // Handle case where paymentMethodId is missing
        if (!$paymentMethodId) {
            return 'Payment method ID is missing.';
        }

        // Define mapping of plans to Stripe price IDs
        $planMapping = [
            "price_1PWhn8Rsway4zlmUEa4UWwnJ" => "Premium and TV Plan",
            "price_1PWhmTRsway4zlmUNg00KkOU" => "Premium Plan",
            "price_1PWhkhRsway4zlmUJUYPsdck" => "Regular Plan",
        ];

        // Validate and map the plan parameter
        if (array_key_exists($plan, $planMapping)) {
            $subscription_plan = $planMapping[$plan];
        }

        // Update user's subscription status in your database
        $user->is_subscribed = 1;
        $user->subscription_plan = $subscription_plan;


        // Create the subscription using Cashier
        $user->newSubscription('default', $plan)->create($paymentMethodId);

        $user = $request->user();

        // Retrieve the subscription
        $subscription = $user->subscription('default');

        if ($subscription && $subscription->stripe_id) {
            // Retrieve the current subscription period details
            $stripeSubscription = Cashier::stripe()->subscriptions->retrieve(
                $subscription->stripe_id,
                ['expand' => ['latest_invoice.payment_intent']]
            );

            $currentPeriodStart = $stripeSubscription->current_period_start;
            $currentPeriodEnd = $stripeSubscription->current_period_end;
            // Access the current period details
            $currentPeriodStart = Carbon::createFromTimestamp($currentPeriodStart)->toDateTimeString();
            $currentPeriodEnd = Carbon::createFromTimestamp($currentPeriodEnd)->toDateTimeString();

            $user->currentPeriodStart = $currentPeriodStart;
            $user->currentPeriodEnd = $currentPeriodEnd;
            $user->save();

            // Use the details as needed
        } else {
                return redirect()->route('fail')->with('error', 'Failed to create subscription.');

        }

        return redirect()->route('subscribed');
    }



    public function cancelSubscription(Request $request)
    {
        $user = $request->user();
        $dueDate = Carbon::parse($user->currentPeriodEnd);

        if ($user->subscribed('default')) {
            $user->subscription('default')->cancelNow();

            // Optionally update the user's subscription status in the database
            $user->is_subscribed = 0;
            $user->subscription_plan = null;
            $user->save();

            // Subscription::where('user_id', $user->id)
            // ->update(['ends_at' => $dueDate,
            //         'stripe_status' => 'canceled']);
        }

        return redirect()->route('subscribed');

    }



    public function success()
    {
        return view('success');
    }

    public function fail()
    {
        return view('fail');
    }
    public function updateSubscriptionDate($stripeId){
        $user = Cashier::findBillable($stripeId);
    }
    public function dashboard(Request $request)
    {
        if ($request->user()?->subscribed('default')) {
            return view('user.subscribed');
        } else {
            return redirect()->route('billing');
        }
    }

}
