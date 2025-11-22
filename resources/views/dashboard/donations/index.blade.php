@extends('dashboard.layouts.app')

@section('title', 'Donations Management')
@section('page-title', 'Donations Management')

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Donations</p>
                            <h3 class="mb-0">{{ $stats['total_donations'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-cash-stack text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Amount</p>
                            <h3 class="mb-0">${{ number_format($stats['total_amount'], 2) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-currency-dollar text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Completed</p>
                            <h3 class="mb-0">{{ $stats['completed_count'] }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Pending/Failed</p>
                            <h3 class="mb-0">{{ $stats['pending_count'] + $stats['failed_count'] }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-exclamation-circle text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods Statistics -->
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">PayPal Donations</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0 small">Count: {{ $stats['paypal_count'] }}</p>
                            <h4 class="mb-0 text-primary">${{ number_format($stats['paypal_amount'], 2) }}</h4>
                        </div>
                        <i class="bi bi-paypal text-primary fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.donations.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Name, email, or transaction ID" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="">All</option>
                            <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('dashboard.donations.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
                </a>
                <a href="{{ route('dashboard.donations.export', request()->query()) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Donations Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($donations->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No donations found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Donor</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Story Reference</th>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $donation)
                                <tr>
                                    <td><span class="badge bg-secondary">#{{ $donation->id }}</span></td>
                                    <td>
                                        <div>
                                            <strong>{{ $donation->donor_name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $donation->donor_email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($donation->amount, 2) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $donation->currency }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-paypal me-1"></i>PayPal
                                        </span>
                                    </td>
                                    <td>
                                        @if($donation->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($donation->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->story_reference)
                                            <small>{{ Str::limit($donation->story_reference, 20) }}</small>
                                        @else
                                            <small class="text-muted">General</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->transaction_id)
                                            <code class="small">{{ Str::limit($donation->transaction_id, 15) }}</code>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $donation->created_at->format('M d, Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $donation->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.donations.show', $donation) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
