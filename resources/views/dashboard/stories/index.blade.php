@extends('dashboard.layouts.app')

@section('title', 'Stories Management')
@section('page-title', 'Stories Management')

@section('content')
    <!-- Filter Tabs -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Filter Stories</h5>
                <a href="{{ route('dashboard.stories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Story
                </a>
            </div>
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') || request('status') == 'all' ? 'active' : '' }}"
                       href="{{ route('dashboard.stories.index') }}">
                        All Stories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                       href="{{ route('dashboard.stories.index', ['status' => 'pending']) }}">
                        Pending
                        <span class="badge bg-warning ms-2">{{ \App\Models\Story::pending()->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}"
                       href="{{ route('dashboard.stories.index', ['status' => 'approved']) }}">
                        Approved
                        <span class="badge bg-success ms-2">{{ \App\Models\Story::approved()->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}"
                       href="{{ route('dashboard.stories.index', ['status' => 'rejected']) }}">
                        Rejected
                        <span class="badge bg-danger ms-2">{{ \App\Models\Story::rejected()->count() }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Stories Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Story Details</th>
                            <th>Submitted By</th>
                            <th width="120">Status</th>
                            <th width="150">Date</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stories as $story)
                            <tr>
                                <td><span class="badge bg-light text-dark">#{{ $story->id }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($story->media_path && $story->media_type === 'image')
                                            <img src="{{ asset('storage/' . $story->media_path) }}"
                                                 alt="Story"
                                                 class="rounded me-3"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="story-placeholder me-3">
                                                <i class="bi bi-file-text-fill"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="d-block">{{ Str::limit($story->title, 50) }}</strong>
                                            @if($story->name)
                                                <small class="text-muted">{{ $story->name }}</small>
                                            @endif
                                            @if($story->story_type)
                                                <br><span class="badge bg-secondary mt-1">{{ $story->story_type }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($story->user)
                                        <div>
                                            <strong>{{ $story->user->first_name }} {{ $story->user->last_name }}</strong>
                                            <br><small class="text-muted">{{ $story->user->email }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">Anonymous</span>
                                    @endif
                                </td>
                                <td>
                                    <select class="form-select form-select-sm status-select"
                                            data-story-id="{{ $story->id }}"
                                            onchange="updateStatus({{ $story->id }}, this.value, '{{ $story->status }}')">
                                        <option value="pending" {{ $story->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $story->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $story->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $story->created_at->format('M d, Y') }}
                                        <br>{{ $story->created_at->format('h:i A') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dashboard.stories.show', $story->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip"
                                           title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('dashboard.stories.edit', $story->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        @if($story->isPending())
                                            <button onclick="approveStory({{ $story->id }})"
                                                    class="btn btn-sm btn-outline-success"
                                                    data-bs-toggle="tooltip"
                                                    title="Approve">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                            <button onclick="rejectStory({{ $story->id }})"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Reject">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        @endif

                                        <button onclick="deleteStory({{ $story->id }})"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="tooltip"
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                    <p class="mb-0">No stories found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($stories->hasPages())
                <div class="mt-4">
                    {{ $stories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .nav-pills .nav-link {
        color: #6c757d;
        border-radius: 10px;
        padding: 0.5rem 1.25rem;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #b70003 0%, #8b0002 100%);
        color: white;
    }

    .story-placeholder {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #dee2e6;
    }

    .status-select {
        width: 120px;
        cursor: pointer;
        border: 2px solid #e0e0e0;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .status-select:focus {
        border-color: #b70003;
        box-shadow: 0 0 0 0.2rem rgba(183, 0, 3, 0.1);
    }

    .status-select option[value="pending"] {
        color: #856404;
    }

    .status-select option[value="approved"] {
        color: #155724;
    }

    .status-select option[value="rejected"] {
        color: #721c24;
    }
</style>
@endpush

@push('scripts')
<script>
    // Update Story Status
    async function updateStatus(id, newStatus, currentStatus) {
        // If status hasn't changed, do nothing
        if (newStatus === currentStatus) {
            return;
        }

        let confirmOptions = {
            showCancelButton: true,
            cancelButtonColor: '#6c757d',
            cancelButtonText: 'Cancel'
        };

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
                const select = document.querySelector(`select[data-story-id="${id}"]`);
                select.value = currentStatus;
                return;
            }

            // Proceed with rejection
            try {
                const response = await axios.post(`/dashboard/stories/${id}/update-status`, {
                    status: newStatus,
                    reason: reason || null
                });

                if (response.data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    // Reload page after short delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } catch (error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to update status'
                });
                // Reset dropdown to previous status
                const select = document.querySelector(`select[data-story-id="${id}"]`);
                select.value = currentStatus;
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
                const select = document.querySelector(`select[data-story-id="${id}"]`);
                select.value = currentStatus;
                return;
            }

            try {
                const response = await axios.post(`/dashboard/stories/${id}/update-status`, {
                    status: newStatus
                });

                if (response.data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    // Reload page after short delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } catch (error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to update status'
                });
                // Reset dropdown to previous status
                const select = document.querySelector(`select[data-story-id="${id}"]`);
                select.value = currentStatus;
            }
        }
    }

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
                    location.reload();
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

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
