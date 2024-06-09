
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Payment;
use DateTime;
use Illuminate\Support\Facades\View;

require_once(app_path('Libraries/stripe-php/init.php'));

use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller {

    public function fAdd(Request $request, Payment $objPayment) {


        $validator = Validator::make($request->all(), [
                    'client_id' => 'nullable|integer',
                    'amount' => 'required|double',
                    'description' => 'nullable|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }
        $vStripeKey = "sk_test_51OsK302MUCtdSqvy1r4sOCwJ2vZP4a2QfatSUIsMd3r5sxK9EaMZRVBheCjFTeRFTm4qx3oa4iIJanJsQ8QzuOyO00LX3KyJUW";
        Stripe::setApiKey($vStripeKey);
        $vDOMAIN = 'https://travequoter.devmindsstudio.com/api/stripe'; // Replace with your actual domain
        $checkoutSession = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd', // Currency
                        'product_data' => [
                            'name' => $request->input('description'),
                        ],
                        'unit_amount' => $request->input('amount') * 100,
                    ],
                    'quantity' => 1,
                        ]],
                    'mode' => 'payment',
                    'success_url' => $vDOMAIN . '/success?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => $vDOMAIN . '/cancel',
        ]);
        $vURl = $checkoutSession->url;

        $res = $objPayment->fAddPayment($checkoutSession->id, $request->input('client_id'));
        return response([
            'stripe_url' => $vURl
                ], 200);
    }

    public function fSuccess(Request $request, Payment $objPayment) {
        $checkoutSessionId = $request->input('session_id');

        // Retrieve Payment Intent ID from Checkout Session
        try {
            $vStripeKey = "sk_test_51OsK302MUCtdSqvy1r4sOCwJ2vZP4a2QfatSUIsMd3r5sxK9EaMZRVBheCjFTeRFTm4qx3oa4iIJanJsQ8QzuOyO00LX3KyJUW";
            Stripe::setApiKey($vStripeKey);
            $checkoutSession = Session::retrieve($checkoutSessionId);
            $lineItems = Session::allLineItems($checkoutSessionId);
            // Extract item details, price, session ID, and status
            //dd($lineItems["data"], $checkoutSession);
            $sessionId = $checkoutSession->id;
            $status = $checkoutSession->payment_status;

            // Create an array containing all the extracted information
            $data = [
                'details' => $lineItems["data"][0]->description,
                'totalAmount' => $lineItems["data"][0]->amount_total / 100,
                'currency' => $lineItems["data"][0]->currency,
                'sessionId' => $sessionId,
                'status' => $status
            ];
// Convert the array to JSON format
            $jsonData = json_encode($data);
            $objPayment->fUpdatePayment($checkoutSessionId, $jsonData);
            return View::make('pay_success');
        } catch (\Exception $e) {
            // Handle error
            //dd($e->getMessage());
            return View::make('pay_fail');
        }
    }

    public function fCancel() {
        return View::make('pay_fail');
    }
}
