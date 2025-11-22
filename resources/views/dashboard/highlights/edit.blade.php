@extends('dashboard.layouts.app')

@section('title', 'Edit Highlight')
@section('page-title', 'Edit Highlight')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Page Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Edit Highlight Video</h4>
                            <p class="text-muted mb-0">Update highlight video details</p>
                        </div>
                        <a href="{{ route('dashboard.highlights.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Highlights
                        </a>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Edit Form -->
            <form id="editHighlightForm" action="{{ route('dashboard.highlights.update', $highlight) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title_{{ $highlight->id }}" class="form-label">Video Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title_{{ $highlight->id }}"
                                   name="title"
                                   value="{{ old('title', $highlight->title) }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description_{{ $highlight->id }}" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description_{{ $highlight->id }}"
                                      name="description"
                                      rows="3"
                                      placeholder="Brief description of the video...">{{ old('description', $highlight->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order_{{ $highlight->id }}" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control @error('order') is-invalid @enderror"
                                       id="order_{{ $highlight->id }}"
                                       name="order"
                                       value="{{ old('order', $highlight->order) }}"
                                       min="0"
                                       required>
                                <small class="text-muted">Lower numbers appear first</small>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="is_active_{{ $highlight->id }}"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', $highlight->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active_{{ $highlight->id }}">
                                        Active (visible on homepage)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Source -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-play-circle me-2"></i>Video Source</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Video Type <span class="text-danger">*</span></label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="video_type" id="type_youtube_{{ $highlight->id }}" value="youtube" {{ old('video_type', $highlight->video_type) === 'youtube' ? 'checked' : '' }} onchange="updateVideoFields{{ $highlight->id }}()">
                                <label class="btn btn-outline-primary" for="type_youtube_{{ $highlight->id }}">
                                    <i class="bi bi-youtube me-2"></i>YouTube
                                </label>

                                <input type="radio" class="btn-check" name="video_type" id="type_vimeo_{{ $highlight->id }}" value="vimeo" {{ old('video_type', $highlight->video_type) === 'vimeo' ? 'checked' : '' }} onchange="updateVideoFields{{ $highlight->id }}()">
                                <label class="btn btn-outline-primary" for="type_vimeo_{{ $highlight->id }}">
                                    <i class="bi bi-vimeo me-2"></i>Vimeo
                                </label>

                                <input type="radio" class="btn-check" name="video_type" id="type_local_{{ $highlight->id }}" value="local" {{ old('video_type', $highlight->video_type) === 'local' ? 'checked' : '' }} onchange="updateVideoFields{{ $highlight->id }}()">
                                <label class="btn btn-outline-primary" for="type_local_{{ $highlight->id }}">
                                    <i class="bi bi-file-play me-2"></i>Upload Video
                                </label>
                            </div>
                        </div>

                        @if($highlight->video_type === 'local' && $highlight->video_url)
                            <div class="mb-3">
                                <label class="form-label d-block">Current Video:</label>
                                <video controls class="rounded" style="max-height: 300px; max-width: 100%;">
                                    <source src="{{ asset('storage/' . $highlight->video_url) }}" type="video/mp4">
                                </video>
                                <div class="form-check mt-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="remove_video_{{ $highlight->id }}"
                                           name="remove_video"
                                           value="1">
                                    <label class="form-check-label text-danger" for="remove_video_{{ $highlight->id }}">
                                        <i class="bi bi-trash me-1"></i>Remove current video
                                    </label>
                                </div>
                            </div>
                        @endif

                        <!-- URL Input (YouTube/Vimeo) -->
                        <div class="mb-3" id="video_url_field_{{ $highlight->id }}">
                            <label for="video_url_{{ $highlight->id }}" class="form-label">Video URL <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('video_url') is-invalid @enderror"
                                   id="video_url_{{ $highlight->id }}"
                                   name="video_url"
                                   value="{{ old('video_url', $highlight->video_url) }}">
                            <small class="text-muted" id="url_help_{{ $highlight->id }}">Video URL</small>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload (Local) -->
                        <div class="mb-3" id="video_file_field_{{ $highlight->id }}" style="display: none;">
                            <label for="video_file_{{ $highlight->id }}" class="form-label">Replace Video File</label>
                            <input type="file"
                                   class="form-control @error('video_file') is-invalid @enderror"
                                   id="video_file_{{ $highlight->id }}"
                                   name="video_file"
                                   accept="video/mp4,video/mov,video/avi,video/wmv">
                            <small class="text-muted">Supported formats: MP4, MOV, AVI, WMV (Max: 500MB)</small>
                            @error('video_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-image me-2"></i>Video Thumbnail</h5>
                    </div>
                    <div class="card-body">
                        @if($highlight->thumbnail_path)
                            <div class="current-thumbnail mb-3">
                                <label class="form-label d-block">Current Thumbnail:</label>
                                <img src="{{ asset('storage/' . $highlight->thumbnail_path) }}"
                                     alt="Current Thumbnail"
                                     class="img-fluid rounded"
                                     style="max-height: 200px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="remove_thumbnail_{{ $highlight->id }}"
                                           name="remove_thumbnail"
                                           value="1">
                                    <label class="form-check-label text-danger" for="remove_thumbnail_{{ $highlight->id }}">
                                        <i class="bi bi-trash me-1"></i>Remove current thumbnail
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="mb-0">
                            <label for="thumbnail_{{ $highlight->id }}" class="form-label">
                                {{ $highlight->thumbnail_path ? 'Replace Thumbnail' : 'Upload Thumbnail' }}
                            </label>
                            <input type="file"
                                   class="form-control @error('thumbnail') is-invalid @enderror"
                                   id="thumbnail_{{ $highlight->id }}"
                                   name="thumbnail"
                                   accept="image/jpeg,image/jpg,image/png,image/gif">
                            <small class="text-muted">Recommended size: 1280x720px. Max: 10MB</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.highlights.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="button" id="submit-btn_{{ $highlight->id }}" class="btn btn-primary" onclick="performUpdate{{ $highlight->id }}()">
                                <i class="bi bi-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #b70003;
        box-shadow: 0 0 0 0.2rem rgba(183, 0, 3, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #b70003 0%, #8b0002 100%);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(183, 0, 3, 0.4);
    }

    .btn-check:checked + .btn-outline-primary {
        background-color: #b70003;
        border-color: #b70003;
    }
</style>
@endpush

@push('scripts')
<script>
    const highlightId = {{ $highlight->id }};

    // Update video fields based on selected type
    function updateVideoFields{{ $highlight->id }}() {
        const videoType = document.querySelector('input[name="video_type"]:checked').value;
        const urlField = document.getElementById('video_url_field_{{ $highlight->id }}');
        const fileField = document.getElementById('video_file_field_{{ $highlight->id }}');
        const urlInput = document.getElementById('video_url_{{ $highlight->id }}');
        const urlHelp = document.getElementById('url_help_{{ $highlight->id }}');

        if (videoType === 'local') {
            urlField.style.display = 'none';
            fileField.style.display = 'block';
            urlInput.removeAttribute('required');
        } else {
            urlField.style.display = 'block';
            fileField.style.display = 'none';
            urlInput.setAttribute('required', 'required');

            if (videoType === 'youtube') {
                urlHelp.textContent = 'Paste the full YouTube video URL';
            } else {
                urlHelp.textContent = 'Paste the full Vimeo video URL';
            }
        }
    }

    // Perform update operation
    function performUpdate{{ $highlight->id }}() {
        const id = {{ $highlight->id }};
        const formData = new FormData();

        // Add text fields
        formData.append('title', document.getElementById('title_' + id).value);
        formData.append('description', document.getElementById('description_' + id).value);
        formData.append('order', document.getElementById('order_' + id).value);

        // Add video type
        const videoType = document.querySelector('input[name="video_type"]:checked').value;
        formData.append('video_type', videoType);

        // Add video URL or file
        if (videoType === 'local') {
            const videoFile = document.getElementById('video_file_' + id).files[0];
            if (videoFile) {
                formData.append('video_file', videoFile);
            }
            formData.append('video_url', 'local'); // Placeholder
        } else {
            formData.append('video_url', document.getElementById('video_url_' + id).value);
        }

        // Add thumbnail if selected
        const thumbnailFile = document.getElementById('thumbnail_' + id).files[0];
        if (thumbnailFile) {
            formData.append('thumbnail', thumbnailFile);
        }

        // Add remove flags
        const removeThumbnail = document.getElementById('remove_thumbnail_' + id);
        if (removeThumbnail && removeThumbnail.checked) {
            formData.append('remove_thumbnail', '1');
        }

        const removeVideo = document.getElementById('remove_video_' + id);
        if (removeVideo && removeVideo.checked) {
            formData.append('remove_video', '1');
        }

        // Add status
        const isActive = document.getElementById('is_active_' + id).checked;
        formData.append('is_active', isActive ? '1' : '0');

        // Call CRUD put function
        const url = '{{ route("dashboard.highlights.update", $highlight) }}';
        const redirectUrl = '{{ route("dashboard.highlights.index") }}';

        put(url, formData, 'submit-btn_' + id, redirectUrl, 'editHighlightForm');
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateVideoFields{{ $highlight->id }}();
    });
</script>
@endpush
