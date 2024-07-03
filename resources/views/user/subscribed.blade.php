<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Subscription Status</title>
</head>
<body>
    <h1>Subscription Details</h1>
    @if(Auth::user()->subscriptions->isEmpty())
        <p>You have no subscriptions.</p>
        <a class="btn btn-primary" href="{{route('billing')}}">Go to Billing Plan</a>
    @else
        @php
            $activeSubscription = Auth::user()->subscriptions->firstWhere('stripe_status', 'active');
        @endphp

        @if($activeSubscription)
            <p>You are subscribed to the {{ Auth::user()->subscription_plan }} Plan!</p>
        @else
            <p>You have no active subscriptions. Here are your subscription details for debugging:</p>

            <ul>
                @foreach(Auth::user()->subscriptions as $subscription)
                    <li>Plan: {{ $subscription->stripe_price }}</li>
                    <li>Status: {{ $subscription->stripe_status }}</li>
                    <li>Ends At: {{ $subscription->ends_at }}</li>
                    <li>Created At: {{ $subscription->created_at }}</li>
                @endforeach
            </ul>
        @endif
    @endif

    @if(Auth::user()->is_subscribed)
        <form action="{{ route('subscription-cancel') }}" method="POST">
            @csrf
            <button class="btn btn-danger" type="submit">Cancel Subscription</button>
        </form>
    @endif
</body>
</html>
