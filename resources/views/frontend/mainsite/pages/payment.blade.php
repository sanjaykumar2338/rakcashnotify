<!-- Contact Start -->
@extends('frontend.mainsite.layouts.other')
@section('content')
    <div class="container-fluid price" id="plans">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                <h4 class="text-primary">{{$plan->name}} Notification Plan</h4>
                <p>Stay ahead of the game with our {{$plan->name}} Notification Plan. Subscribe to receive instant
                    alerts and notifications about exclusive deals, discounts, and offers tailored just for you. With
                    this plan, you'll never miss out on any opportunity to save more and stay informed.</p>
            </div>
        </div>
    </div>

    <div class="container-fluid contact py-1">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.1s">

                    <img style="display:none;" src="/loader.gif" class="processing" alt="Processing..."/></div>
            </div>
            <div id="paymentResponse" class="hidden"></div>
            <div id="paypal-button-container" style="padding-left: 250px;"></div>
        </div>
    </div>

    <script
        src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&vault=true&intent=subscription"></script>
    <script>
        let subscr_plan_id = "{{$plan_id}}";
        let custom_id = "{{auth()->id()}}";
        paypal.Buttons({
            // onInit is called when the button first renders
            onInit(data, actions) {
                if (!custom_id) {
                    alert('Please Login First');
                    actions.disable();
                    return false;
                }
            },
            onClick() {
                if (!custom_id) {
                    alert('Please Login First');
                    return false;
                }
            },
            async createSubscription(data, actions) {
                setProcessing(true);

                // Get the selected plan ID
                console.log('createSubscription called');
                // Check if subscr_plan_id is valid
                if (!subscr_plan_id) {
                    console.error('Plan ID is missing');
                    return;
                }

                // Send request to the backend server to create subscription plan via PayPal API
                // const PLAN_ID = await fetch("paypal/createplan", {
                //     method: "get",
                //     headers: {'Accept': 'application/json'}
                // })
                //     .then((res) => {
                //         console.log(res)
                //         return res.json();
                //     })
                //     .then((result) => {
                //         setProcessing(false);
                //         if (result.status == 1) {
                //             return result.data.id;
                //         } else {
                //             resultMessage(result.msg);
                //             return false;
                //         }
                //     });

                // return;
                // Creates the subscription
                return actions.subscription.create({
                    'plan_id': subscr_plan_id,
                    'custom_id': custom_id
                }).then(function (subscription) {
                    console.log('Subscription created', subscription);
                    return subscription;
                }).catch(function (err) {
                    console.error('Subscription creation failed', err);
                    alert('An error occurred while creating the subscription. Please try again.');
                });
            },
            onApprove: (data, actions) => {
                setProcessing(true);

                // Send request to the backend server to validate subscription via PayPal API
                const postData = {
                    request_type: 'capture_subscr',
                    order_id: data.orderID,
                    subscription_id: data.subscriptionID,
                    plan_id: subscr_plan_id,
                    return_url: "/subscriptionstatus/success",  // Success URL
                    cancel_url: "/subscriptionstatus/fail"      // Failure URL
                };

                const csrfToken = "{{ csrf_token() }}";

                fetch('/paypal/savesubscription', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',  // Assuming you're sending JSON data
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(postData)
                })
                    .then((response) => response.json())
                    .then((result) => {
                        if (result.status == 1) {
                            // Redirect the user to the success page
                            window.location.href = postData.return_url;
                        } else {
                            // Redirect to cancel page
                            window.location.href = postData.cancel_url;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        // On error, redirect to failure URL
                        window.location.href = postData.cancel_url;
                    })
                    .finally(() => {
                        // Ensure setProcessing(false) runs after all promises resolve or reject
                        setProcessing(false);
                    });
            }
        }).render('#paypal-button-container');

        // Helper function to encode payload parameters
        const encodeFormData = (data) => {
            var form_data = new FormData();

            for (var key in data) {
                form_data.append(key, data[key]);
            }
            return form_data;
        }

        // Show a loader on payment form processing
        const setProcessing = (isProcessing) => {
            const processingElement = document.querySelector(".processing");

            if (isProcessing) {
                processingElement.style.display = "block";  // Show the element
            } else {
                processingElement.style.display = "none";   // Hide the element
            }
        }

        // Display status message
        const resultMessage = (msg_txt) => {
            const messageContainer = document.querySelector("#paymentResponse");

            messageContainer.classList.remove("hidden");
            messageContainer.textContent = msg_txt;

            setTimeout(function () {
                messageContainer.classList.add("hidden");
                messageContainer.textContent = "";
            }, 5000);
        }
    </script>
@endsection
