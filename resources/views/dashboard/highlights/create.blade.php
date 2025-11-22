@extends('dashboard.layouts.app')

@section('title', 'Add New Highlight')
@section('page-title', 'Add New Highlight')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Page Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Add New Highlight Video</h4>
                            <p class="text-muted mb-0">Add a featured video to the homepage</p>
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

            <!-- Create Form -->
            <form id="createHighlightForm" action="{{ route('dashboard.highlights.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title_create" class="form-label">Video Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title_create"
                                   name="title"
                                   value="{{ old('title') }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description_create" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description_create"
                                      name="description"
                                      rows="3"
                                      placeholder="Brief description of the video...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order_create" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control @error('order') is-invalid @enderror"
                                       id="order_create"
                                       name="order"
                                       value="{{ old('order', 0) }}"
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
                                           id="is_active_create"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active_create">
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
                                <input type="radio" class="btn-check" name="video_type" id="type_youtube" value="youtube" {{ old('video_type', 'youtube') === 'youtube' ? 'checked' : '' }} onchange="updateVideoFields()">
                                <label class="btn btn-outline-primary" for="type_youtube">
                                    <i class="bi bi-youtube me-2"></i>YouTube
                                </label>

                                <input type="radio" class="btn-check" name="video_type" id="type_vimeo" value="vimeo" {{ old('video_type') === 'vimeo' ? 'checked' : '' }} onchange="updateVideoFields()">
                                <label class="btn btn-outline-primary" for="type_vimeo">
                                    <i class="bi bi-vimeo me-2"></i>Vimeo
                                </label>

                                <input type="radio" class="btn-check" name="video_type" id="type_local" value="local" {{ old('video_type') === 'local' ? 'checked' : '' }} onchange="updateVideoFields()">
                                <label class="btn btn-outline-primary" for="type_local">
                                    <i class="bi bi-file-play me-2"></i>Upload Video
                                </label>
                            </div>
                        </div>

                        <!-- URL Input (YouTube/Vimeo) -->
                        <div class="mb-3" id="video_url_field">
                            <label for="video_url_create" class="form-label">Video URL <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('video_url') is-invalid @enderror"
                                   id="video_url_create"
                                   name="video_url"
                                   value="{{ old('video_url') }}"
                                   placeholder="https://www.youtube.com/watch?v=...">
                            <small class="text-muted" id="url_help">Paste the full YouTube video URL</small>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload (Local) -->
                        <div class="mb-3" id="video_file_field" style="display: none;">
                            <label for="video_file_create" class="form-label">Upload Video File <span class="text-danger">*</span></label>
                            <input type="file"
                                   class="form-control @error('video_file') is-invalid @enderror"
                                   id="video_file_create"
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
                        <div class="mb-0">
                            <label for="thumbnail_create" class="form-label">Upload Thumbnail (Optional)</label>
                            <input type="file"
                                   class="form-control @error('thumbnail') is-invalid @enderror"
                                   id="thumbnail_create"
                                   name="thumbnail"
                                   accept="image/jpeg,image/jpg,image/png,image/gif">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-info-circle me-1"></i>
                                <strong>YouTube videos auto-generate thumbnails.</strong> Only upload if you want a custom image.
                            </small>
                            <small class="text-muted">Recommended size: 1280x720px. Max: 10MB</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Area -->
                        <div id="thumbnailPreview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview:</label>
                            <div id="thumbnailContent"></div>
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
                            <button type="button" id="submit-btn" class="btn btn-primary" onclick="performStore()">
                                <i class="bi bi-save me-2"></i>Add Highlight
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

    #thumbnailContent img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Update video fields based on selected type
    function updateVideoFields() {
        const videoType = document.querySelector('input[name="video_type"]:checked').value;
        const urlField = document.getElementById('video_url_field');
        const fileField = document.getElementById('video_file_field');
        const urlInput = document.getElementById('video_url_create');
        const urlHelp = document.getElementById('url_help');

        if (videoType === 'local') {
            urlField.style.display = 'none';
            fileField.style.display = 'block';
            urlInput.removeAttribute('required');
        } else {
            urlField.style.display = 'block';
            fileField.style.display = 'none';
            urlInput.setAttribute('required', 'required');

            if (videoType === 'youtube') {
                urlInput.placeholder = 'https://www.youtube.com/watch?v=...';
                urlHelp.textContent = 'Paste the full YouTube video URL';
            } else {
                urlInput.placeholder = 'https://vimeo.com/123456789';
                urlHelp.textContent = 'Paste the full Vimeo video URL';
            }
        }
    }

    // Thumbnail preview
    document.getElementById('thumbnail_create').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const previewArea = document.getElementById('thumbnailPreview');
            const previewContent = document.getElementById('thumbnailContent');

            const reader = new FileReader();
            reader.onload = function(e) {
                previewContent.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                previewArea.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Perform store operation
    function performStore() {
        const formData = new FormData();

        // Add text fields
        formData.append('title', document.getElementById('title_create').value);
        formData.append('description', document.getElementById('description_create').value);
        formData.append('order', document.getElementById('order_create').value);

        // Add video type
        const videoType = document.querySelector('input[name="video_type"]:checked').value;
        formData.append('video_type', videoType);

        // Add video URL or file
        if (videoType === 'local') {
            const videoFile = document.getElementById('video_file_create').files[0];
            if (videoFile) {
                formData.append('video_file', videoFile);
            }
            formData.append('video_url', 'local'); // Placeholder
        } else {
            formData.append('video_url', document.getElementById('video_url_create').value);
        }

        // Add thumbnail if selected
        const thumbnailFile = document.getElementById('thumbnail_create').files[0];
        if (thumbnailFile) {
            formData.append('thumbnail', thumbnailFile);
        }

        // Add status
        const isActive = document.getElementById('is_active_create').checked;
        formData.append('is_active', isActive ? '1' : '0');

        // Call CRUD post function
        const url = '{{ route("dashboard.highlights.store") }}';
        const redirectUrl = '{{ route("dashboard.highlights.index") }}';

        post(url, formData, 'submit-btn', redirectUrl, 'createHighlightForm');
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateVideoFields();
    });
</script>
@endpush
