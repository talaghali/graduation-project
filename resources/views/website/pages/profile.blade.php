@extends('website.layouts.app')

@section('title', 'My Profile - Voices Of Gaza')

@section('content')
    <section class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Profile Header Card -->
                    <div class="card profile-header-card shadow-lg mb-4">
                        <div class="card-body p-5">
                            <div class="row align-items-center">
                                <div class="col-auto text-center">
                                    <div class="profile-avatar-large">
                                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="col">
                                    <h2 class="text-white mb-2 fw-bold">
                                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                    </h2>
                                    <div class="d-flex flex-wrap gap-3 mb-2">
                                        <p class="text-white-50 mb-0">
                                            <i class="bi bi-envelope-fill me-2"></i>{{ Auth::user()->email }}
                                        </p>
                                        @if(Auth::user()->phone)
                                            <p class="text-white-50 mb-0">
                                                <i class="bi bi-telephone-fill me-2"></i>{{ Auth::user()->phone }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if(Auth::user()->email_verified_at)
                                            <span class="verified-badge badge-success">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Verified
                                            </span>
                                        @endif
                                        <span class="verified-badge badge-active">
                                            <i class="bi bi-shield-check"></i>
                                            Active Account
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('settings') }}" class="btn profile-edit-btn">
                                        <i class="bi bi-gear-fill me-2"></i>Edit Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Information Grid -->
                    <div class="row g-4">
                        <!-- Personal Information Card -->
                        <div class="col-md-6">
                            <div class="card profile-info-card h-100 shadow-lg">
                                <div class="card-body p-4">
                                    <h5 class="card-title">
                                        <i class="bi bi-person-badge-fill"></i>
                                        Personal Information
                                    </h5>

                                    <div class="mb-3">
                                        <div class="profile-info-label">First Name</div>
                                        <div class="profile-info-value">{{ Auth::user()->first_name }}</div>
                                    </div>

                                    <hr class="profile-divider">

                                    <div class="mb-3">
                                        <div class="profile-info-label">Last Name</div>
                                        <div class="profile-info-value">{{ Auth::user()->last_name }}</div>
                                    </div>

                                    @if(Auth::user()->date_of_birth)
                                        <hr class="profile-divider">
                                        <div class="mb-0">
                                            <div class="profile-info-label">Date of Birth</div>
                                            <div class="profile-info-value">
                                                <i class="bi bi-calendar-event me-2"></i>
                                                {{ Auth::user()->date_of_birth->format('F d, Y') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Card -->
                        <div class="col-md-6">
                            <div class="card profile-info-card h-100 shadow-lg">
                                <div class="card-body p-4">
                                    <h5 class="card-title">
                                        <i class="bi bi-envelope-at-fill"></i>
                                        Contact Information
                                    </h5>

                                    <div class="mb-3">
                                        <div class="profile-info-label">Email Address</div>
                                        <div class="profile-info-value d-flex align-items-center justify-content-between">
                                            <span>{{ Auth::user()->email }}</span>
                                            @if(Auth::user()->email_verified_at)
                                                <span class="verified-badge badge-success">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Verified
                                                </span>
                                            @else
                                                <span class="verified-badge badge-warning">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Not Verified
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @if(Auth::user()->phone)
                                        <hr class="profile-divider">
                                        <div class="mb-0">
                                            <div class="profile-info-label">Phone Number</div>
                                            <div class="profile-info-value">
                                                <i class="bi bi-telephone-fill me-2"></i>
                                                {{ Auth::user()->phone }}
                                            </div>
                                        </div>
                                    @else
                                        <hr class="profile-divider">
                                        <div class="mb-0">
                                            <div class="profile-info-label">Phone Number</div>
                                            <div class="profile-info-value text-white-50">
                                                <i class="bi bi-dash-circle me-2"></i>
                                                Not provided
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Account Information Card -->
                        <div class="col-12">
                            <div class="card profile-info-card shadow-lg">
                                <div class="card-body p-4">
                                    <h5 class="card-title">
                                        <i class="bi bi-info-circle-fill"></i>
                                        Account Information
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <div class="profile-info-label">Member Since</div>
                                            <div class="profile-info-value">
                                                <i class="bi bi-calendar-check me-2"></i>
                                                {{ Auth::user()->created_at->format('F d, Y') }}
                                            </div>
                                            <small class="text-white-50">
                                                {{ Auth::user()->created_at->diffForHumans() }}
                                            </small>
                                        </div>

                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <div class="profile-info-label">Last Updated</div>
                                            <div class="profile-info-value">
                                                <i class="bi bi-clock-history me-2"></i>
                                                {{ Auth::user()->updated_at->format('F d, Y') }}
                                            </div>
                                            <small class="text-white-50">
                                                {{ Auth::user()->updated_at->diffForHumans() }}
                                            </small>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="profile-info-label">Account Status</div>
                                            <div class="profile-info-value">
                                                <span class="verified-badge badge-active">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Active
                                                </span>
                                            </div>
                                            <small class="text-white-50">
                                                Your account is in good standing
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- My Stories Section -->
                        <div class="col-12">
                            <div class="card profile-info-card shadow-lg">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-book-fill"></i>
                                            My Stories ({{ $stories->total() }})
                                        </h5>
                                        <a href="{{ route('share') }}" class="btn btn-outline-light">
                                            <i class="bi bi-plus-circle me-2"></i>Share New Story
                                        </a>
                                    </div>

                                    @if($stories->count() > 0)
                                        <div class="row g-4">
                                            @foreach($stories as $story)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="story-card h-100">
                                                        <div class="story-card-header">
                                                            <h6 class="mb-2">{{ Str::limit($story->title, 50) }}</h6>
                                                            <div class="d-flex gap-2 mb-2 flex-wrap">
                                                                @if($story->status === 'approved')
                                                                    <span class="badge bg-success">Approved</span>
                                                                @elseif($story->status === 'pending')
                                                                    <span class="badge bg-warning text-dark">Pending Review</span>
                                                                @else
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @endif
                                                                @if($story->deleteRequest)
                                                                    <span class="badge bg-info">
                                                                        <i class="bi bi-hourglass-split me-1"></i>Delete Pending
                                                                    </span>
                                                                @endif
                                                                @if($story->story_type)
                                                                    <span class="badge bg-secondary">{{ $story->story_type }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="story-card-body">
                                                            <p class="text-white-50 small mb-2">
                                                                {{ Str::limit(strip_tags($story->content), 100) }}
                                                            </p>

                                                            @if($story->latestDeleteRequest && $story->latestDeleteRequest->status === 'rejected')
                                                                <div class="alert alert-danger p-2 mb-2" style="font-size: 0.75rem;">
                                                                    <strong><i class="bi bi-x-circle me-1"></i>Delete Request Rejected:</strong>
                                                                    <div class="mt-1">{{ $story->latestDeleteRequest->admin_notes }}</div>
                                                                </div>
                                                            @endif

                                                            <div class="text-white-50 small">
                                                                <i class="bi bi-calendar3 me-1"></i>
                                                                {{ $story->created_at->format('M d, Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="story-card-footer">
                                                            @if($story->status === 'approved')
                                                                <a href="{{ route('stories.show', $story->id) }}" class="btn btn-sm btn-outline-light" target="_blank">
                                                                    <i class="bi bi-eye me-1"></i>View
                                                                </a>
                                                            @endif
                                                            @if($story->deleteRequest)
                                                                <button class="btn btn-sm btn-secondary" disabled title="Delete request pending">
                                                                    <i class="bi bi-hourglass-split me-1"></i>Request Pending
                                                                </button>
                                                            @else
                                                                <button onclick="deleteStory({{ $story->id }})" class="btn btn-sm btn-outline-danger">
                                                                    <i class="bi bi-trash me-1"></i>Request Delete
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($stories->hasPages())
                                            <div class="mt-4 d-flex justify-content-center">
                                                {{ $stories->links() }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-inbox display-4 d-block mb-3 text-white-50"></i>
                                            <p class="text-white-50 mb-3">You haven't shared any stories yet</p>
                                            <a href="{{ route('share') }}" class="btn btn-outline-light">
                                                <i class="bi bi-file-earmark-text-fill me-2"></i>Share Your First Story
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Card -->
                        <div class="col-12">
                            <div class="card profile-info-card shadow-lg">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-4">
                                        <i class="bi bi-lightning-fill"></i>
                                        Quick Actions
                                    </h5>

                                    <div class="row g-3">
                                        <div class="col-md-3 col-sm-6">
                                            <a href="{{ route('settings') }}" class="btn btn-outline-light w-100 py-3">
                                                <i class="bi bi-gear-fill d-block mb-2" style="font-size: 1.5rem;"></i>
                                                Settings
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <a href="{{ route('share') }}" class="btn btn-outline-light w-100 py-3">
                                                <i class="bi bi-file-earmark-text-fill d-block mb-2" style="font-size: 1.5rem;"></i>
                                                Share Story
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <a href="{{ route('index') }}" class="btn btn-outline-light w-100 py-3">
                                                <i class="bi bi-house-fill d-block mb-2" style="font-size: 1.5rem;"></i>
                                                Home
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <button type="button" class="btn btn-outline-danger w-100 py-3" id="quickLogoutBtn">
                                                <i class="bi bi-box-arrow-right d-block mb-2" style="font-size: 1.5rem;"></i>
                                                Logout
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
.story-card{background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:12px;overflow:hidden;transition:all 0.3s ease;display:flex;flex-direction:column}
.story-card:hover{transform:translateY(-5px);box-shadow:0 8px 25px rgba(183,0,3,0.3);border-color:rgba(183,0,3,0.5)}
.story-card-header{padding:1.25rem;border-bottom:1px solid rgba(255,255,255,0.1)}
.story-card-header h6{color:#fff;font-weight:600;margin:0}
.story-card-body{padding:1.25rem;flex-grow:1}
.story-card-footer{padding:1rem 1.25rem;border-top:1px solid rgba(255,255,255,0.1);display:flex;gap:0.5rem;justify-content:flex-end}
.pagination{margin:0}
.pagination .page-link{background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);color:#fff}
.pagination .page-link:hover{background:rgba(183,0,3,0.8);border-color:#b70003}
.pagination .page-item.active .page-link{background:#b70003;border-color:#b70003}
</style>
@endpush

@push('scripts')
<script>
    // Request to delete story function
    async function deleteStory(storyId) {
        const { value: reason } = await Swal.fire({
            title: 'Request Story Deletion',
            html: `
                <p class="text-start mb-3">Please provide a reason for deleting this story. An admin will review your request.</p>
                <textarea id="deletion-reason" class="form-control" rows="4" placeholder="Explain why you want to delete this story..."></textarea>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Submit Request',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const reason = document.getElementById('deletion-reason').value;
                if (!reason || reason.trim() === '') {
                    Swal.showValidationMessage('Please provide a reason');
                    return false;
                }
                return reason;
            }
        });

        if (reason) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const response = await axios.delete(`/api/stories/${storyId}`, {
                    data: { reason: reason },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Request Submitted!',
                        text: response.data.message,
                        confirmButtonColor: '#b70003'
                    });
                    location.reload();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'Failed to submit delete request.',
                    confirmButtonColor: '#b70003'
                });
            }
        }
    }

    // Quick logout button
    document.getElementById('quickLogoutBtn')?.addEventListener('click', async function() {
        const result = await Swal.fire({
            title: 'Logout',
            text: 'Are you sure you want to logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#b70003',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                const response = await axios.post('{{ route("api.logout") }}', {}, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Logged Out',
                        text: response.data.message,
                        confirmButtonColor: '#b70003',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route("index") }}';
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to logout. Please try again.',
                    confirmButtonColor: '#b70003'
                });
            }
        }
    });
</script>
@endpush
