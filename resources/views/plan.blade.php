<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subscribe to a Plan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-3">Subscribe to a {{$plan_name}}</h2>
        <!-- Display any success or error messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Subscription Form -->
        <form action="{{ route('subscription-checkout', $plan) }}" method="POST" id="subscription-form">
            @csrf
            <!-- Payment Method Element -->
            <div id="card-element" class="form-control pt-2">
                <!-- A Stripe Element will be inserted here. -->
            </div>

            <!-- Error Element -->
            <div id="card-errors" role="alert" class="text-danger mt-2"></div>

            <!-- Form submission -->
            <button id="submit-button" class="btn btn-primary mt-4">Subscribe</button>
        </form>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", async function () {
            var stripe = Stripe('pk_test_51PQkOmRsway4zlmUTHqIPaSxocLvfTjdPkeefrctIkM0yVbjIRxfDGpaG2esHfMYjWa17vJtECcPypGr4hixuHJo00gWz13M0u');
            var elements = stripe.elements();
            var cardElement = elements.create('card');
            cardElement.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            cardElement.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('subscription-form');
            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                // Create a SetupIntent
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    "{{ $user->createSetupIntent()->client_secret }}",
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: '{{ $user->name }}' }
                        }
                    }
                );

                if (error) {
                    // Display error.message in your UI.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    // The setup has succeeded. Send the payment method ID to your server.
                    stripePaymentMethodHandler(setupIntent.payment_method);
                }
            });

            function stripePaymentMethodHandler(paymentMethodId) {
                // Insert the payment method ID into the form so it gets submitted to the server
                var form = document.getElementById('subscription-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentMethodId');
                hiddenInput.setAttribute('value', paymentMethodId);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    </script>
</body>
</html>
