@extends('dashboard.layouts.app')

@section('title', 'Dashboard Overview')
@section('page-title', 'Dashboard Overview')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Stories -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-primary">
                                <i class="bi bi-book-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="stat-label mb-1">Total Stories</p>
                            <h3 class="stat-value mb-0">{{ $stats['total_stories'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Stories -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-warning">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="stat-label mb-1">Pending Review</p>
                            <h3 class="stat-value mb-0">{{ $stats['pending_stories'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Stories -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-success">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="stat-label mb-1">Approved</p>
                            <h3 class="stat-value mb-0">{{ $stats['approved_stories'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-info">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="stat-label mb-1">Total Users</p>
                            <h3 class="stat-value mb-0">{{ $stats['total_users'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Stories -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Stories</h5>
                        <a href="{{ route('dashboard.stories.index') }}" class="btn btn-sm btn-primary">
                            View All <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Submitted By</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_stories as $story)
                                    <tr>
                                        <td><span class="badge bg-light text-dark">#{{ $story->id }}</span></td>
                                        <td>
                                            <strong>{{ Str::limit($story->title, 40) }}</strong>
                                            @if($story->name)
                                                <br><small class="text-muted">{{ $story->name }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($story->user)
                                                {{ $story->user->first_name }} {{ $story->user->last_name }}
                                            @else
                                                <span class="text-muted">Anonymous</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($story->story_type)
                                                <span class="badge bg-secondary">{{ $story->story_type }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $story->status_badge_color }}">
                                                {{ ucfirst($story->status) }}
                                            </span>
                                        </td>
                                        <td><small>{{ $story->created_at->diffForHumans() }}</small></td>
                                        <td>
                                            <a href="{{ route('dashboard.stories.show', $story->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                            No stories yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .bg-primary {
        background: linear-gradient(135deg, #b70003 0%, #8b0002 100%) !important;
    }

    .stat-label {
        color: #7f8c8d;
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        color: #2c3e50;
        font-weight: 700;
        font-size: 2rem;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush
