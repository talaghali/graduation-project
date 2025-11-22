@extends('website.layouts.app')

@section('title', 'Payment Failed - Voices Of Gaza')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Failed Card -->
                <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);">
                    <div class="card-body p-5 text-center">
                        <!-- Failed Icon -->
                        <div class="failed-icon mb-4">
                            @if(request('status') === 'cancelled')
                                <i class="bi bi-x-circle-fill" style="font-size: 5rem; color: #ffc107;"></i>
                            @else
                                <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: #dc3545;"></i>
                            @endif
                        </div>

                        <!-- Message -->
                        <h1 class="text-white mb-3">
                            @if(request('status') === 'cancelled')
                                Payment Cancelled
                            @else
                                Payment Failed
                            @endif
                        </h1>

                        <p class="text-white-50 mb-4" style="font-size: 1.1rem;">
                            @if(request('status') === 'cancelled')
                                You have cancelled the payment process. No charges have been made to your account.
                            @else
                                We're sorry, but your payment could not be processed at this time.
                            @endif
                        </p>

                        <!-- Reason/Details -->
                        @if(request('reason'))
                            <div class="alert alert-warning mx-auto" style="max-width: 500px; background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); color: #ffc107;">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Reason:</strong> {{ request('reason') }}
                            </div>
                        @endif

                        <!-- What to do next -->
                        <div class="what-next mt-5 p-4 rounded" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                            <h5 class="text-white mb-3">What can you do next?</h5>
                            <div class="text-start text-white-50">
                                <ul style="line-height: 2;">
                                    @if(request('status') === 'cancelled')
                                        <li>Try again if you changed your mind</li>
                                        <li>Choose a different payment method</li>
                                        <li>Contact us if you need assistance</li>
                                    @else
                                        <li>Check your card details and try again</li>
                                        <li>Try using a different payment method (PayPal or Card)</li>
                                        <li>Ensure you have sufficient funds</li>
                                        <li>Contact your bank if the problem persists</li>
                                        <li>Reach out to our support team for help</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-5 d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('donate') }}" class="btn btn-lg" style="background: #b70003; color: white; border: none;">
                                <i class="bi bi-arrow-clockwise me-2"></i>Try Again
                            </a>
                            <a href="{{ route('index') }}" class="btn btn-lg btn-outline-light">
                                <i class="bi bi-house-fill me-2"></i>Back to Home
                            </a>
                            <a href="{{ route('stories.index') }}" class="btn btn-lg btn-outline-light">
                                <i class="bi bi-book-fill me-2"></i>Read Stories
                            </a>
                        </div>

                        <!-- Support Section -->
                        <div class="mt-5 pt-4 border-top" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                            <p class="text-white-50 mb-3">Need help?</p>
                            <div class="d-flex gap-3 justify-content-center">
                                <a href="mailto:support@voicesofgaza.org" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-envelope-fill me-2"></i>Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information Message -->
                <div class="mt-4 text-center">
                    <p class="text-white-50" style="font-size: 0.95rem;">
                        @if(request('status') === 'cancelled')
                            Your support means the world to us. We hope you'll try again when you're ready.
                        @else
                            We understand payment issues can be frustrating. Our support team is here to help you complete your donation.
                        @endif
                    </p>
                </div>

                <!-- Common Issues -->
                @if(request('status') !== 'cancelled')
                    <div class="card shadow-lg border-0 mt-4" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);">
                        <div class="card-body p-4">
                            <h6 class="text-white mb-3">
                                <i class="bi bi-lightbulb-fill me-2" style="color: #ffc107;"></i>
                                Common Payment Issues
                            </h6>
                            <div class="row text-white-50 small">
                                <div class="col-md-6 mb-3">
                                    <strong class="text-white">Incorrect Card Details</strong>
                                    <p class="mb-0">Double-check your card number, expiry date, and CVV code.</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong class="text-white">Insufficient Funds</strong>
                                    <p class="mb-0">Ensure you have enough balance in your account.</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong class="text-white">Bank Restrictions</strong>
                                    <p class="mb-0">Some banks block international or online transactions.</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong class="text-white">Payment Limit Exceeded</strong>
                                    <p class="mb-0">You may have reached your daily transaction limit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .failed-icon {
        animation: shake 0.6s ease-out;
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
        20%, 40%, 60%, 80% { transform: translateX(10px); }
    }
    .what-next {
        animation: fadeInUp 0.6s ease-out 0.3s both;
    }
    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endpush
