<?php

namespace App\Http\Controllers;

use App\Events\DonationCompleted;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * Process PayPal payment
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:10000',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'story_reference' => 'nullable|string|max:255',
        ]);

        // Ensure amount is properly formatted
        $validated['amount'] = round((float) $validated['amount'], 2);

        Log::info('Processing PayPal payment', [
            'amount' => $validated['amount'],
            'donor_email' => $validated['donor_email']
        ]);

        try {
            // Create donation record
            $donation = Donation::create([
                'donor_name' => $validated['donor_name'],
                'donor_email' => $validated['donor_email'],
                'amount' => $validated['amount'],
                'currency' => 'USD',
                'story_reference' => $validated['story_reference'] ?? null,
                'payment_method' => 'paypal',
                'status' => 'pending',
            ]);

            // Initialize PayPal client
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            // Create order data
            $orderData = [
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                    'brand_name' => 'Voices of Gaza',
                    'locale' => 'en-US',
                    'user_action' => 'PAY_NOW',
                    'shipping_preference' => 'NO_SHIPPING'
                ],
                'purchase_units' => [
                    [
                        'reference_id' => 'DONATION_' . $donation->id,
                        'description' => 'Donation to Voices of Gaza',
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => number_format($validated['amount'], 2, '.', '')
                        ]
                    ]
                ]
            ];

            Log::info('Creating PayPal order', ['order_data' => $orderData]);

            $response = $provider->createOrder($orderData);

            Log::info('PayPal order response', ['response' => $response]);

            if (isset($response['error'])) {
                Log::error('PayPal Order Creation Error', ['error' => $response]);
                throw new \Exception($response['error']['message'] ?? 'Failed to create PayPal order');
            }

            if (!isset($response['id'])) {
                Log::error('PayPal Order Missing ID', ['response' => $response]);
                throw new \Exception('PayPal order ID not found in response');
            }

            // Store PayPal order ID
            $donation->update([
                'paypal_payment_id' => $response['id'],
            ]);

            // Get approval URL
            $approvalUrl = null;
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    $approvalUrl = $link['href'];
                    break;
                }
            }

            if (!$approvalUrl) {
                Log::error('PayPal Approval URL not found', ['response' => $response]);
                throw new \Exception('No approval URL found in PayPal response');
            }

            Log::info('Redirecting to PayPal', ['approval_url' => $approvalUrl]);

            // Redirect to PayPal
            return redirect($approvalUrl);

        } catch (\Exception $e) {
            Log::error('PayPal Payment Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            if (isset($donation)) {
                $donation->update(['status' => 'failed']);
            }

            return redirect()->route('donation.failed', [
                'status' => 'error',
                'reason' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $token = $request->get('token');

        if (!$token) {
            return redirect()->route('donation.failed', [
                'status' => 'error',
                'reason' => 'Payment verification failed - no token provided'
            ]);
        }

        try {
            // Find donation by PayPal order ID
            $donation = Donation::where('paypal_payment_id', $token)->first();

            if (!$donation) {
                return redirect()->route('donation.failed', [
                    'status' => 'error',
                    'reason' => 'Donation record not found'
                ]);
            }

            // Initialize PayPal client
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            // Capture the payment
            $response = $provider->capturePaymentOrder($token);

            Log::info('PayPal capture response', ['response' => $response]);

            if (isset($response['error'])) {
                Log::error('PayPal Capture Error', ['error' => $response]);

                $donation->update(['status' => 'failed']);

                return redirect()->route('donation.failed', [
                    'status' => 'error',
                    'reason' => $response['error']['message'] ?? 'Failed to capture PayPal payment'
                ]);
            }

            if ($response['status'] === 'COMPLETED') {
                $capture = $response['purchase_units'][0]['payments']['captures'][0] ?? null;

                $donation->update([
                    'status' => 'completed',
                    'payer_id' => $response['payer']['payer_id'] ?? null,
                    'transaction_id' => $capture['id'] ?? null,
                    'payment_details' => json_encode($response),
                    'paid_at' => now(),
                ]);

                // Dispatch event to trigger email notifications
                event(new DonationCompleted($donation));

                return redirect()->route('donation.success', $donation->id);
            }

            // Update donation status to failed
            $donation->update(['status' => 'failed']);

            return redirect()->route('donation.failed', [
                'status' => 'error',
                'reason' => 'Payment status: ' . ($response['status'] ?? 'unknown')
            ]);

        } catch (\Exception $e) {
            Log::error('PayPal Success Error: ' . $e->getMessage());

            if (isset($donation)) {
                $donation->update(['status' => 'failed']);
            }

            return redirect()->route('donation.failed', [
                'status' => 'error',
                'reason' => 'An unexpected error occurred during payment processing'
            ]);
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel(Request $request)
    {
        $token = $request->get('token');

        if ($token) {
            $donation = Donation::where('paypal_payment_id', $token)->first();
            if ($donation) {
                $donation->update(['status' => 'failed']);
            }
        }

        return redirect()->route('donation.failed', [
            'status' => 'cancelled',
            'reason' => 'You cancelled the payment process'
        ]);
    }
}
