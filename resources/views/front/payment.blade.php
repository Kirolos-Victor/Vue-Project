@extends('layouts.app')
    <style>
        /**
     * The CSS shown here will not be introduced in the Quickstart guide, but
     * shows how you can use CSS to style your Element's container.
     */
        input,
        .StripeElement {
            height: 40px !important;
            padding: 10px 12px !important;

            color: #32325d !important;
            background-color: white !important;
            border: 1px solid transparent !important;
            border-radius: 4px !important;

            box-shadow: 0 1px 3px 0 #e6ebf1 !important;
            -webkit-transition: box-shadow 150ms ease !important;
            transition: box-shadow 150ms ease !important;
        }

        input:focus,
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df !important;
        }

        .StripeElement--invalid {
            border-color: #fa755a !important;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@section('content')
        <div class="container">
            <form action="{{url('/charge')}}" method="post" id="payment-form">
                @csrf
            <div >
                <label for="card-element">
                    Credit or debit card
                </label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>
                <br>
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-6" style="margin-top: 50px">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Total:</th>
                                    <td>$ {{$cart->totalPrice}}</td>
                                   <td> <button class="btn btn-primary"><i class="fas fa-credit-card"></i> Submit Payment</button></td>

                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </form>
        </div>
    @endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.onload=function () {
            // Create a Stripe client.
            var stripe = Stripe('pk_test_ththNaMo3RC9LtpZqIQWK7Ah00bZ7wreyE');

// Create an instance of Elements.
            var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
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
            var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

// Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
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
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

// Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        };
    </script>
    @endsection
