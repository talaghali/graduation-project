@extends('website.layouts.app')

@section('title', 'Thank You - Donation Successful')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Card -->
                <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);">
                    <div class="card-body p-5 text-center">
                        <!-- Success Icon -->
                        <div class="success-icon mb-4">
                            <i class="bi bi-check-circle-fill" style="font-size: 5rem; color: #28a745;"></i>
                        </div>

                        <!-- Thank You Message -->
                        <h1 class="text-white mb-3">Thank You for Your Donation!</h1>
                        <p class="text-white-50 mb-4" style="font-size: 1.1rem;">
                            Your generous contribution helps us amplify the voices and stories from Gaza.
                        </p>

                        <!-- Donation Details -->
                        <div class="donation-details p-4 rounded" style="background: rgba(183, 0, 3, 0.1); border: 1px solid rgba(183, 0, 3, 0.3);">
                            <div class="row text-start">
                                <div class="col-md-6 mb-3">
                                    <label class="text-white-50 small d-block mb-1">Donation Amount</label>
                                    <strong class="text-white h4">${{ number_format($donation->amount, 2) }}</strong>
                                    <span class="text-white-50"> {{ $donation->currency }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-white-50 small d-block mb-1">Payment Method</label>
                                    <strong class="text-white">{{ ucfirst($donation->payment_method) }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-white-50 small d-block mb-1">Transaction ID</label>
                                    <code class="text-white small">{{ $donation->transaction_id }}</code>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-white-50 small d-block mb-1">Date & Time</label>
                                    <span class="text-white">{{ $donation->paid_at->format('M d, Y h:i A') }}</span>
                                </div>
                                @if($donation->story_reference)
                                <div class="col-12">
                                    <label class="text-white-50 small d-block mb-1">Supporting Story</label>
                                    <span class="text-white">{{ $donation->story_reference }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Email Confirmation Notice -->
                        <div class="alert alert-info mt-4" style="background: rgba(23, 162, 184, 0.1); border: 1px solid rgba(23, 162, 184, 0.3); color: #17a2b8;">
                            <i class="bi bi-envelope-check me-2"></i>
                            A confirmation email has been sent to <strong>{{ $donation->donor_email }}</strong>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('index') }}" class="btn btn-lg btn-outline-light">
                                <i class="bi bi-house-fill me-2"></i>Back to Home
                            </a>
                            <a href="{{ route('stories.index') }}" class="btn btn-lg btn-outline-light">
                                <i class="bi bi-book-fill me-2"></i>Read More Stories
                            </a>
                            <a href="{{ route('donate') }}" class="btn btn-lg" style="background: #b70003; color: white; border: none;">
                                <i class="bi bi-heart-fill me-2"></i>Donate Again
                            </a>
                        </div>

                        <!-- Share Section -->
                        <div class="mt-5 pt-4 border-top" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                            <p class="text-white-50 mb-3">Help us spread the word</p>
                            <div class="d-flex gap-3 justify-content-center">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('donate')) }}" target="_blank" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-facebook"></i> Share
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=I%20just%20donated%20to%20Voices%20of%20Gaza&url={{ urlencode(route('donate')) }}" target="_blank" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-twitter"></i> Tweet
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('donate')) }}" target="_blank" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-linkedin"></i> Share
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Impact Message -->
                <div class="mt-4 text-center">
                    <p class="text-white-50" style="font-size: 0.95rem;">
                        Your donation makes a real difference. Thank you for standing with the people of Gaza
                        and helping to preserve and share their stories with the world.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .success-icon {
        animation: scaleIn 0.5s ease-out;
    }
    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    .donation-details {
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
