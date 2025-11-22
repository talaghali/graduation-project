@extends('dashboard.layouts.app')

@section('title', 'Edit Story')
@section('page-title', 'Edit Story')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Page Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Edit Story</h4>
                            <p class="text-muted mb-0">Update story details and content</p>
                        </div>
                        <a href="{{ route('dashboard.stories.show', $story) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Story
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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
            <form id="editStoryForm" action="{{ route('dashboard.stories.update', $story) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title_{{ $story->id }}" class="form-label">Story Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title_{{ $story->id }}"
                                   name="title"
                                   value="{{ old('title', $story->title) }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name_{{ $story->id }}" class="form-label">Story Subject Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name_{{ $story->id }}"
                                   name="name"
                                   value="{{ old('name', $story->name) }}"
                                   placeholder="e.g., John Doe, Ahmad Ali, etc.">
                            <small class="text-muted">The name of the person this story is about</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="story_type_{{ $story->id }}" class="form-label">Story Type/Category</label>
                            <input type="text"
                                   class="form-control @error('story_type') is-invalid @enderror"
                                   id="story_type_{{ $story->id }}"
                                   name="story_type"
                                   value="{{ old('story_type', $story->story_type) }}"
                                   placeholder="e.g., Survivor, Witness, Memorial, etc.">
                            @error('story_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location_{{ $story->id }}" class="form-label">Location</label>
                                <input type="text"
                                       class="form-control @error('location') is-invalid @enderror"
                                       id="location_{{ $story->id }}"
                                       name="location"
                                       value="{{ old('location', $story->location) }}"
                                       placeholder="e.g., Gaza City, Khan Younis, etc.">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_{{ $story->id }}" class="form-label">Incident Date</label>
                                <input type="date"
                                       class="form-control @error('date') is-invalid @enderror"
                                       id="date_{{ $story->id }}"
                                       name="date"
                                       value="{{ old('date', $story->date ? \Carbon\Carbon::parse($story->date)->format('Y-m-d') : '') }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story Content -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Story Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <label for="content_{{ $story->id }}" class="form-label">Story Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content_{{ $story->id }}"
                                      name="content"
                                      rows="12"
                                      required>{{ old('content', $story->content) }}</textarea>
                            <small class="text-muted">Use the editor to format your story with headings, lists, images, and more...</small>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Media Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-image me-2"></i>Media</h5>
                    </div>
                    <div class="card-body">
                        @if($story->media_path)
                            <div class="current-media mb-3">
                                <label class="form-label d-block">Current Media:</label>
                                <div class="position-relative d-inline-block">
                                    @if($story->media_type === 'image')
                                        <img src="{{ asset('storage/' . $story->media_path) }}"
                                             alt="Current Media"
                                             class="img-fluid rounded"
                                             style="max-height: 300px;">
                                    @elseif($story->media_type === 'video')
                                        <video controls class="rounded" style="max-height: 300px;">
                                            <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                                        </video>
                                    @endif
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="remove_media_{{ $story->id }}"
                                           name="remove_media"
                                           value="1">
                                    <label class="form-check-label text-danger" for="remove_media_{{ $story->id }}">
                                        <i class="bi bi-trash me-1"></i>Remove current media
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="mb-0">
                            <label for="media_{{ $story->id }}" class="form-label">
                                {{ $story->media_path ? 'Replace with New Media' : 'Upload Media' }}
                            </label>
                            <input type="file"
                                   class="form-control @error('media') is-invalid @enderror"
                                   id="media_{{ $story->id }}"
                                   name="media"
                                   accept="image/jpeg,image/jpg,image/png,image/gif,video/mp4,video/mov,video/avi">
                            <small class="text-muted">
                                Supported formats: JPEG, JPG, PNG, GIF, MP4, MOV, AVI (Max: 100MB)
                            </small>
                            @error('media')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Story Status Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Current Status</small>
                                <span class="badge bg-{{ $story->status_badge_color }} fs-6">
                                    {{ ucfirst($story->status) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Submitted By</small>
                                <strong>
                                    @if($story->user)
                                        {{ $story->user->first_name }} {{ $story->user->last_name }}
                                    @else
                                        Anonymous
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.stories.show', $story) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="button" id="submit-btn_{{ $story->id }}" class="btn btn-primary" onclick="performUpdate('{{ $story->id }}')">
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

    textarea.form-control {
        resize: vertical;
        min-height: 200px;
    }

    .current-media img,
    .current-media video {
        border: 3px solid #e0e0e0;
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

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/rnnwqb5qb51b3r1rw76jgr4nj74a3mougohwna6euymoltpu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Track form changes
    let formChanged = false;
    let editorReady = false;
    const form = document.querySelector('form');

    // Initialize TinyMCE
    tinymce.init({
        selector: '#content_{{ $story->id }}',
        height: 500,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; line-height: 1.6; }',
        directionality: 'ltr',
        language: 'en',
        setup: function(editor) {
            // Mark editor as ready after initialization
            editor.on('init', function() {
                editorReady = true;
            });

            // Only track changes after editor is ready (ignore initialization events)
            editor.on('input change', function() {
                if (editorReady) {
                    formChanged = true;
                    editor.save(); // Save content back to textarea
                }
            });
        }
    });

    // Track changes in form inputs (except the hidden ones)
    const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="file"]), select, textarea:not(#content_{{ $story->id }})');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            formChanged = true;
        });
    });

    // Track checkbox changes separately
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            formChanged = true;
        });
    });

    // Handle media file input
    const mediaInput = document.getElementById('media_{{ $story->id }}');
    if (mediaInput) {
        mediaInput.addEventListener('change', () => {
            formChanged = true;
        });
    }

    // Warn if trying to leave with unsaved changes
    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Perform update operation
    function performUpdate(id) {
        // Ensure TinyMCE content is saved to textarea
        const editorId = 'content_' + id;
        if (tinymce.get(editorId)) {
            tinymce.get(editorId).save();
        }

        // Create FormData and manually add all fields
        const formData = new FormData();

        // Add text fields
        formData.append('title', document.getElementById('title_' + id).value);
        formData.append('content', document.getElementById('content_' + id).value);
        formData.append('name', document.getElementById('name_' + id).value);
        formData.append('story_type', document.getElementById('story_type_' + id).value);
        formData.append('location', document.getElementById('location_' + id).value);
        formData.append('date', document.getElementById('date_' + id).value);

        // Add media file if selected
        const mediaInput = document.getElementById('media_' + id);
        if (mediaInput.files.length > 0) {
            formData.append('media', mediaInput.files[0]);
        }

        // Add remove_media checkbox value
        const removeMediaCheckbox = document.getElementById('remove_media_' + id);
        if (removeMediaCheckbox && removeMediaCheckbox.checked) {
            formData.append('remove_media', '1');
        }

        // Call CRUD put function
        const url = '{{ route("dashboard.stories.update", $story) }}';
        const redirectUrl = '{{ route("dashboard.stories.show", $story) }}';

        // Mark form as unchanged to prevent unsaved changes warning
        formChanged = false;

        // Use FormData for file uploads (put function will handle _method automatically)
        put(url, formData, 'submit-btn_' + id, redirectUrl, 'editStoryForm');
    }
</script>
@endpush
