<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5 !important;
            font-family: "Roboto";

        }

        .submit {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .submit div {
            display: flex;
            align-items: center;
        }

        .submit-button {
            border-radius: 5px;
            background-color: #448aff;
            padding: 10px;
            margin: 10px;
            color: #fff;
            border: 0;
        }

        .submit-button:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }

        #app {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .12);
            padding: 2px 30px;
            max-width: 600px;
            margin: 40px auto;
        }

        #app .header {
            text-align: center;
        }

        .billing-details div {
            margin-bottom: 5px;
        }

        .payment-details div {
            margin-bottom: 5px;
        }

        .payment-details {
            margin-top: 20px;
        }

        .input {
            min-height: 34px;
            border: 0;
            border-bottom: 1px solid #ddd;
            width: 100%;
            font-size: 16px;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            color: '#32325d',

        }

        input:focus {
            outline: none;
        }

        .alert-error {
            padding: 20px;
            background-color: #f44336b3;
            color: white;
            border-radius: 5px;
        }

        .alert-error ul {
            margin: 0;
        }

        .alert-success {
            padding: 20px;
            background-color: #008000a8;
            color: white;
            border-radius: 5px;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
        .StripeElement {
            box-sizing: border-box;
            font-family: 'Roboto';
            height: 40px;

            padding: 10px 12px;

            border-bottom: 1px solid #ddd;
            /* border-radius: 4px; */
            background-color: white;

            /* box-shadow: 0 1px 3px 0 #e6ebf1; */
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        /*  .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        } */

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="header">
            <h2>Add Your Card</h2>
        </div>
        @if(session()->has('success_message'))
        <div class="alert-success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{session()->get('success_message')}}
        </div>
        @endif
        @if(count($errors) > 0)
        <div class="alert-error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            {{session()->get('success_message')}}
        </div>
        @endif

        <form action="{{route('checkout.store')}}" method="post" id="payment-form">
            @csrf
            <div class="billing-details">
                <h3>Billing details</h3>
                <div>
                    <input type="checkbox" id="pick-address" name="pickAddress" onchange="initAddress(this)">
                    <label for="pick-address"> Is your billing address same to your pickup address ?</label><br>
                </div>
                <div>
                    <input class="input" id="email" name="email" type="email" placeholder="Email" value="{{old('email')}}" required>
                </div>
                <div>
                    <input class="input" id="address" name="address" type="text" placeholder="Address" value="{{old('address')}}" required>
                </div>
                <div>
                    <input class="input" id="city" name="city" type="text" placeholder="City" value="{{old('city')}}" required>
                </div>
                <div>
                    <input class="input" id="state" name="state" type="text" placeholder="State" value="{{old('state')}}" required>
                </div>
                <div>
                    <input class="input" id="postalcode" name="postalcode" type="number" placeholder="Postal Code" value="{{old('postalcode')}}" required>
                </div>
            </div>
            <div class="payment-details">
                <h3>Payment details</h3>
                <div>
                    <input class="input" id="name" name="name" placeholder="Name on Card" required>
                </div>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>

            <div class="submit">
                <div>
                    <script>
                        if (localStorage.getItem('in') == 'true') {
                            document.write(`
                    <div>
                        <input type="checkbox" id="save-card" name="saveCard" value="1">
                        <label for="save-card"> Do you want to save card details for later use ?</label><br>
                    </div>
                `)
                        }
                    </script>
                </div>

                <button class="submit-button" id="submit-button" type="submit">Submit Payment</button>
            </div>
        </form>
    </div>

    <script>
        // Create a Stripe client.
        var stripe = Stripe('pk_test_0G9HHVR4XmO3EFy80yElsydL0011AX8fxz');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            console.log("checkbox value: ", document.getElementById('save-card').value);
            event.preventDefault();

            document.getElementById('submit-button').disabled = true;

            var options = {
                name: document.getElementById('name').value,
                address_line1: document.getElementById('address').value,
                address_city: document.getElementById('city').value,
                address_state: document.getElementById('state').value,
                address_zip: document.getElementById('postalcode').value,
            }
            stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    document.getElementById('submit-button').disabled = false;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            var order = JSON.parse(localStorage.getItem('order'));
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');

            var hiddenInput = document.createElement('input');
            var carrierPrice = document.createElement('input');
            var shipperId = document.createElement('input');

            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);

            carrierPrice.setAttribute('type', 'hidden');
            carrierPrice.setAttribute('name', 'price');
            carrierPrice.setAttribute('value', order.carrier.price);

            shipperId.setAttribute('type', 'hidden');
            shipperId.setAttribute('name', 'shipperId');
            shipperId.setAttribute('value', order.carrier.price);

            form.appendChild(hiddenInput);
            form.appendChild(carrierPrice);

            // Submit the form
            form.submit();
        }
    </script>
    <script>
        function initAddress(obj) {
            if (obj.checked) {
                var storage = JSON.parse(localStorage.getItem("order"))
                document.getElementById('email').value = storage.shipper.pickDetails.email;
                document.getElementById('address').value = storage.shipper.pickDetails.address;
                document.getElementById('city').value = storage.shipper.pickDetails.cityName;
                document.getElementById('postalcode').value = storage.shipper.pickDetails.postalCode;
            } else {
                document.getElementById('email').value = '';
                document.getElementById('address').value = '';
                document.getElementById('city').value = '';
                document.getElementById('postalcode').value = '';
            }
        }
    </script>
</body>

</html>