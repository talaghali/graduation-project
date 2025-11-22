@extends('dashboard.layouts.app')

@section('title', 'Story Details')
@section('page-title', 'Story Details')

@section('content')
    <!-- Story Header Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="mb-2">{{ $story->title }}</h4>
                    <div class="d-flex align-items-center gap-3">
                        <div class="status-dropdown-wrapper">
                            <label class="form-label mb-1 small text-muted">Status:</label>
                            <select class="form-select form-select-sm status-select-show"
                                    id="status-select-{{ $story->id }}"
                                    data-story-id="{{ $story->id }}"
                                    data-current-status="{{ $story->status }}"
                                    onchange="updateStatusShow({{ $story->id }}, this.value, '{{ $story->status }}')">
                                <option value="pending" {{ $story->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $story->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $story->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        @if($story->story_type)
                            <div>
                                <label class="form-label mb-1 small text-muted">Type:</label>
                                <div><span class="badge bg-secondary fs-6">{{ $story->story_type }}</span></div>
                            </div>
                        @endif
                        <div>
                            <label class="form-label mb-1 small text-muted">Created:</label>
                            <div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $story->created_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group">
                    <a href="{{ route('dashboard.stories.edit', $story->id) }}" class="btn btn-info text-white">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </a>
                    <button onclick="deleteStory({{ $story->id }})" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-2"></i>Delete
                    </button>
                    <a href="{{ route('dashboard.stories.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Story Details -->
        <div class="col-lg-8">
            <!-- Media Section -->
            @if($story->media_path)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-image me-2"></i>Media</h5>
                    </div>
                    <div class="card-body text-center">
                        @if($story->media_type === 'image')
                            <img src="{{ asset('storage/' . $story->media_path) }}"
                                 alt="Story Media"
                                 class="img-fluid rounded"
                                 style="max-height: 500px; width: auto;">
                        @elseif($story->media_type === 'video')
                            <video controls class="w-100 rounded" style="max-height: 500px;">
                                <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Story Content -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Story Content</h5>
                </div>
                <div class="card-body">
                    <div class="story-content">
                        {!! $story->content !!}
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            @if($story->location || $story->date)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Additional Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($story->location)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block mb-1">Location</label>
                                    <strong><i class="bi bi-geo-alt me-2"></i>{{ $story->location }}</strong>
                                </div>
                            @endif
                            @if($story->date)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block mb-1">Incident Date</label>
                                    <strong><i class="bi bi-calendar-event me-2"></i>{{ \Carbon\Carbon::parse($story->date)->format('M d, Y') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Rejection Reason -->
            @if($story->status === 'rejected' && $story->rejection_reason)
                <div class="card border-0 shadow-sm border-start border-danger border-4 mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>Rejection Reason
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $story->rejection_reason }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Submitter Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>Submitter Info</h5>
                </div>
                <div class="card-body">
                    @if($story->user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="user-avatar-lg me-3">
                                {{ strtoupper(substr($story->user->first_name, 0, 1)) }}{{ strtoupper(substr($story->user->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <strong class="d-block">{{ $story->user->first_name }} {{ $story->user->last_name }}</strong>
                                <small class="text-muted">Registered User</small>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-2">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $story->user->email }}</strong>
                        </div>
                        @if($story->user->phone)
                            <div class="mb-2">
                                <small class="text-muted d-block">Phone</small>
                                <strong>{{ $story->user->phone }}</strong>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-person-x display-4 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">Anonymous Submission</p>
                        </div>
                    @endif

                    @if($story->name)
                        <hr>
                        <div>
                            <small class="text-muted d-block">Story Subject Name</small>
                            <strong>{{ $story->name }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <small class="text-muted">Submitted</small>
                                <div><strong>{{ $story->created_at->format('M d, Y') }}</strong></div>
                                <small class="text-muted">{{ $story->created_at->format('h:i A') }}</small>
                            </div>
                        </div>

                        @if($story->status === 'approved' && $story->updated_at != $story->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <small class="text-muted">Approved</small>
                                    <div><strong>{{ $story->updated_at->format('M d, Y') }}</strong></div>
                                    <small class="text-muted">{{ $story->updated_at->format('h:i A') }}</small>
                                </div>
                            </div>
                        @endif

                        @if($story->status === 'rejected' && $story->updated_at != $story->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <small class="text-muted">Rejected</small>
                                    <div><strong>{{ $story->updated_at->format('M d, Y') }}</strong></div>
                                    <small class="text-muted">{{ $story->updated_at->format('h:i A') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Story Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Word Count</span>
                        <strong>{{ str_word_count($story->content) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Character Count</span>
                        <strong>{{ strlen($story->content) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Has Media</span>
                        <strong>
                            @if($story->media_path)
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Yes</span>
                            @else
                                <span class="text-muted"><i class="bi bi-x-circle-fill"></i> No</span>
                            @endif
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .story-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #2c3e50;
    }

    .user-avatar-lg {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #b70003 0%, #8b0002 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: #e0e0e0;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: -26px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .timeline-content {
        padding-left: 10px;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .status-dropdown-wrapper {
        min-width: 140px;
    }

    .status-select-show {
        width: 140px;
        cursor: pointer;
        border: 2px solid #e0e0e0;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .status-select-show:focus {
        border-color: #b70003;
        box-shadow: 0 0 0 0.2rem rgba(183, 0, 3, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Update Story Status from Show Page
    async function updateStatusShow(id, newStatus, currentStatus) {
        // If status hasn't changed, do nothing
        if (newStatus === currentStatus) {
            return;
        }

        // Show rejection reason input if changing to rejected
        if (newStatus === 'rejected') {
            const { value: reason, isConfirmed } = await Swal.fire({
                title: 'Reject Story',
                input: 'textarea',
                inputLabel: 'Rejection Reason (Optional)',
                inputPlaceholder: 'Enter reason for rejection...',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Reject Story',
                cancelButtonColor: '#6c757d'
            });

            if (!isConfirmed) {
                // Reset dropdown to previous status
                document.getElementById('status-select-' + id).value = currentStatus;
                return;
            }

            // Proceed with rejection
            try {
                const response = await axios.post(`/dashboard/stories/${id}/update-status`, {
                    status: newStatus,
                    reason: reason || null
                });

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.data.message,
                        confirmButtonColor: '#b70003',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    location.reload();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update status.',
                    confirmButtonColor: '#b70003'
                });
                // Reset dropdown to previous status
                document.getElementById('status-select-' + id).value = currentStatus;
            }
        } else {
            // For approved or pending status
            let statusText = newStatus === 'approved' ? 'approve' : 'set to pending';
            let statusColor = newStatus === 'approved' ? '#28a745' : '#ffc107';

            const result = await Swal.fire({
                title: `${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)} Story?`,
                text: `This will ${statusText} the story.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: statusColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${statusText.charAt(0).toUpperCase() + statusText.slice(1)}`,
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) {
                // Reset dropdown to previous status
                document.getElementById('status-select-' + id).value = currentStatus;
                return;
            }

            try {
                const response = await axios.post(`/dashboard/stories/${id}/update-status`, {
                    status: newStatus
                });

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.data.message,
                        confirmButtonColor: '#b70003',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    location.reload();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update status.',
                    confirmButtonColor: '#b70003'
                });
                // Reset dropdown to previous status
                document.getElementById('status-select-' + id).value = currentStatus;
            }
        }
    }

    // Show success toast on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Check URL for success parameter
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');

        if (successMessage) {
            // Show toast notification
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: 'success',
                title: decodeURIComponent(successMessage)
            });

            // Clean up URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });

    // Approve Story
    async function approveStory(id) {
        const result = await Swal.fire({
            title: 'Approve Story?',
            text: 'This story will be published on the website.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            try {
                const response = await axios.post(`/dashboard/stories/${id}/approve`);

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Approved!',
                        text: response.data.message,
                        confirmButtonColor: '#b70003',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    location.reload();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to approve story.',
                    confirmButtonColor: '#b70003'
                });
            }
        }
    }

    // Reject Story
    async function rejectStory(id) {
        const { value: reason } = await Swal.fire({
            title: 'Reject Story',
            input: 'textarea',
            inputLabel: 'Rejection Reason (Optional)',
            inputPlaceholder: 'Enter reason for rejection...',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Reject Story',
            cancelButtonColor: '#6c757d'
        });

        if (reason !== undefined) {
            try {
                const response = await axios.post(`/dashboard/stories/${id}/reject`, {
                    reason: reason
                });

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Rejected!',
                        text: response.data.message,
                        confirmButtonColor: '#b70003',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    location.reload();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to reject story.',
                    confirmButtonColor: '#b70003'
                });
            }
        }
    }

    // Delete Story
    async function deleteStory(id) {
        const result = await Swal.fire({
            title: 'Delete Story?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            try {
                const response = await axios.delete(`/dashboard/stories/${id}`);

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.data.message,
                        confirmButtonColor: '#b70003',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    window.location.href = '{{ route("dashboard.stories.index") }}';
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to delete story.',
                    confirmButtonColor: '#b70003'
                });
            }
        }
    }
</script>
@endpush
