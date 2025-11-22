@extends('dashboard.layouts.app')

@section('title', 'Highlight Videos Management')
@section('page-title', 'Highlight Videos')

@section('content')
    <!-- Page Header -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Manage Highlight Videos</h5>
                    <p class="text-muted mb-0">Featured videos displayed on the homepage</p>
                </div>
                <a href="{{ route('dashboard.highlights.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Highlight
                </a>
            </div>
        </div>
    </div>

    <!-- Highlights Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">Order</th>
                            <th>Video Details</th>
                            <th width="120">Type</th>
                            <th width="120">Status</th>
                            <th width="150">Created</th>
                            <th width="250">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($highlights as $highlight)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark fw-bold">{{ $highlight->order }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $highlight->thumbnail_url }}"
                                             alt="Thumbnail"
                                             class="rounded me-3"
                                             style="width: 80px; height: 60px; object-fit: cover;">
                                        <div>
                                            <strong class="d-block">{{ Str::limit($highlight->title, 50) }}</strong>
                                            @if($highlight->description)
                                                <small class="text-muted">{{ Str::limit($highlight->description, 60) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($highlight->video_type) }}</span>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle"
                                               type="checkbox"
                                               id="status-{{ $highlight->id }}"
                                               data-highlight-id="{{ $highlight->id }}"
                                               {{ $highlight->is_active ? 'checked' : '' }}
                                               onchange="toggleStatus({{ $highlight->id }})">
                                        <label class="form-check-label" for="status-{{ $highlight->id }}">
                                            <span class="badge bg-{{ $highlight->status_badge_color }}">
                                                {{ $highlight->status_text }}
                                            </span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $highlight->created_at->format('M d, Y') }}
                                        <br>{{ $highlight->created_at->format('h:i A') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button onclick="previewVideo({{ $highlight->id }}, '{{ addslashes($highlight->title) }}', '{{ $highlight->embed_url }}', '{{ $highlight->video_type }}')"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="tooltip"
                                                title="Preview">
                                            <i class="bi bi-play-circle"></i>
                                        </button>

                                        <a href="{{ route('dashboard.highlights.edit', $highlight->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button onclick="deleteHighlight({{ $highlight->id }})"
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
                                    <i class="bi bi-film display-4 d-block mb-3"></i>
                                    <p class="mb-0">No highlights found</p>
                                    <a href="{{ route('dashboard.highlights.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="bi bi-plus-circle me-2"></i>Add Your First Highlight
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($highlights->hasPages())
                <div class="mt-4">
                    {{ $highlights->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Video Preview Modal -->
    <div class="modal fade" id="videoPreviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoPreviewTitle">Video Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="videoPreviewContainer" class="ratio ratio-16x9">
                        <!-- Video will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .video-placeholder {
        width: 80px;
        height: 60px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #dee2e6;
    }

    .status-toggle {
        cursor: pointer;
        width: 3rem;
        height: 1.5rem;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle Status
    async function toggleStatus(id) {
        try {
            const response = await axios.post(`/dashboard/highlights/${id}/toggle-status`);

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
            // Reset toggle
            const toggle = document.querySelector(`#status-${id}`);
            toggle.checked = !toggle.checked;
        }
    }

    // Preview Video
    function previewVideo(id, title, embedUrl, videoType) {
        document.getElementById('videoPreviewTitle').textContent = title;

        const container = document.getElementById('videoPreviewContainer');

        if (videoType === 'local') {
            container.innerHTML = `
                <video controls class="w-100">
                    <source src="${embedUrl}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            `;
        } else {
            container.innerHTML = `
                <iframe src="${embedUrl}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            `;
        }

        const modal = new bootstrap.Modal(document.getElementById('videoPreviewModal'));
        modal.show();

        // Clean up when modal is closed
        document.getElementById('videoPreviewModal').addEventListener('hidden.bs.modal', function () {
            container.innerHTML = '';
        });
    }

    // Delete Highlight
    async function deleteHighlight(id) {
        const result = await Swal.fire({
            title: 'Delete Highlight?',
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
                const response = await axios.delete(`/dashboard/highlights/${id}`);

                if (response.data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to delete highlight.',
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
