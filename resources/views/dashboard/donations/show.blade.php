@extends('dashboard.layouts.app')

@section('title', 'Donation Details')
@section('page-title', 'Donation Details')

@section('content')
    <div class="row">
        <!-- Main Donation Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Donation #{{ $donation->id }}</h5>
                        @if($donation->status === 'completed')
                            <span class="badge bg-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>Completed
                            </span>
                        @elseif($donation->status === 'pending')
                            <span class="badge bg-warning px-3 py-2">
                                <i class="bi bi-clock me-1"></i>Pending
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2">
                                <i class="bi bi-x-circle me-1"></i>Failed
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Donor Information -->
                        <div class="col-12">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-person-circle me-2"></i>Donor Information
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Donor Name</label>
                            <p class="mb-0"><strong>{{ $donation->donor_name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Email Address</label>
                            <p class="mb-0">
                                <a href="mailto:{{ $donation->donor_email }}">{{ $donation->donor_email }}</a>
                            </p>
                        </div>

                        <div class="col-12"><hr></div>

                        <!-- Payment Information -->
                        <div class="col-12">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-credit-card me-2"></i>Payment Information
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted">Amount</label>
                            <p class="mb-0">
                                <strong class="text-success fs-4">${{ number_format($donation->amount, 2) }}</strong>
                                <span class="text-muted ms-2">{{ $donation->currency }}</span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted">Payment Method</label>
                            <p class="mb-0">
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="bi bi-paypal me-1"></i>PayPal
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted">Transaction ID</label>
                            <p class="mb-0">
                                @if($donation->transaction_id)
                                    <code class="small">{{ $donation->transaction_id }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="small text-muted">PayPal Payment ID</label>
                            <p class="mb-0">
                                @if($donation->paypal_payment_id)
                                    <code class="small">{{ $donation->paypal_payment_id }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Payer ID</label>
                            <p class="mb-0">
                                @if($donation->payer_id)
                                    <code class="small">{{ $donation->payer_id }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-12"><hr></div>

                        <!-- Additional Information -->
                        <div class="col-12">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-info-circle me-2"></i>Additional Information
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Story Reference</label>
                            <p class="mb-0">
                                @if($donation->story_reference)
                                    <strong>{{ $donation->story_reference }}</strong>
                                @else
                                    <span class="text-muted">General Donation</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Paid At</label>
                            <p class="mb-0">
                                @if($donation->paid_at)
                                    {{ $donation->paid_at->format('M d, Y h:i A') }}
                                @else
                                    <span class="text-muted">Not paid yet</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Created At</label>
                            <p class="mb-0">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Last Updated</label>
                            <p class="mb-0">{{ $donation->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Details JSON -->
            @if($donation->payment_details)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">
                            <i class="bi bi-code-square me-2"></i>Raw Payment Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded small mb-0" style="max-height: 400px; overflow-y: auto;"><code>{{ json_encode(json_decode($donation->payment_details), JSON_PRETTY_PRINT) }}</code></pre>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions & Summary -->
        <div class="col-lg-4">
            <!-- Actions Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('dashboard.donations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Donations
                        </a>
                        @if($donation->donor_email)
                            <a href="mailto:{{ $donation->donor_email }}" class="btn btn-outline-primary">
                                <i class="bi bi-envelope me-2"></i>Email Donor
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Summary Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Quick Summary</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Donation ID</span>
                            <strong>#{{ $donation->id }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Status</span>
                            <strong class="text-{{ $donation->status === 'completed' ? 'success' : ($donation->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($donation->status) }}
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Amount</span>
                            <strong class="text-success">${{ number_format($donation->amount, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Payment Via</span>
                            <strong>{{ ucfirst($donation->payment_method) }}</strong>
                        </div>
                    </div>

                    @if($donation->status === 'completed')
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle me-2"></i>
                            <small>This donation has been successfully processed.</small>
                        </div>
                    @elseif($donation->status === 'pending')
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-clock me-2"></i>
                            <small>This donation is awaiting payment confirmation.</small>
                        </div>
                    @else
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-x-circle me-2"></i>
                            <small>This donation failed or was cancelled.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
