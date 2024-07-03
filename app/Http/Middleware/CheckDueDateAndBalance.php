<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Stripe\Stripe; // Import Stripe
use App\Models\Subscription;

class CheckDueDateAndBalance
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        // return $user->subscribed('default');

        if ($user->subscribed('default')) {
            // Parse current period end date
            $dueDate = Carbon::parse($user->currentPeriodEnd);

            // Check if today is the due date
            if ($dueDate->isToday() && $dueDate->isPast()) {
                // Check if user's balance is zero or negative
                if ($user->balance() <= 0) {
                    // Cancel subscription due to zero balance
                    $user->subscription('default')->cancel();

                    // Optionally update user's subscription status in your database
                    $user->is_subscribed = 0;
                    $user->subscription_plan = null;
                    $user->save();

                    return redirect()->route('billing');
                }
            }
        }


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
                    return $next($request);
                }
        } else {
            return redirect()->route('billing');  // Handle case where user is not subscribed
        }

        // Continue with the request
        return $next($request);
    }
}
