@extends('dashboard.layouts.app')

@section('title', 'Create New Story')
@section('page-title', 'Create New Story')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Page Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Create New Story</h4>
                            <p class="text-muted mb-0">Add a new story to the platform</p>
                        </div>
                        <a href="{{ route('dashboard.stories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Stories
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

            <!-- Create Form -->
            <form id="createStoryForm" action="{{ route('dashboard.stories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title_create" class="form-label">Story Title <span class="text-danger">*</span></label>
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
                            <label for="name_create" class="form-label">Story Subject Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name_create"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="e.g., John Doe, Ahmad Ali, etc.">
                            <small class="text-muted">The name of the person this story is about</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="age_create" class="form-label">Age</label>
                                <input type="number"
                                       class="form-control @error('age') is-invalid @enderror"
                                       id="age_create"
                                       name="age"
                                       value="{{ old('age') }}"
                                       min="1"
                                       max="150"
                                       placeholder="e.g., 25">
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="story_type_create" class="form-label">Story Type/Category</label>
                                <input type="text"
                                       class="form-control @error('story_type') is-invalid @enderror"
                                       id="story_type_create"
                                       name="story_type"
                                       value="{{ old('story_type') }}"
                                       placeholder="e.g., Survivor, Witness, Memorial">
                                @error('story_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location_create" class="form-label">Location</label>
                                <input type="text"
                                       class="form-control @error('location') is-invalid @enderror"
                                       id="location_create"
                                       name="location"
                                       value="{{ old('location') }}"
                                       placeholder="e.g., Gaza City, Khan Younis">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_create" class="form-label">Incident Date</label>
                                <input type="date"
                                       class="form-control @error('date') is-invalid @enderror"
                                       id="date_create"
                                       name="date"
                                       value="{{ old('date') }}">
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
                            <label for="content_create" class="form-label">Story Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content_create"
                                      name="content"
                                      rows="12"
                                      required>{{ old('content') }}</textarea>
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
                        <div class="mb-0">
                            <label for="media_create" class="form-label">Upload Media</label>
                            <input type="file"
                                   class="form-control @error('media') is-invalid @enderror"
                                   id="media_create"
                                   name="media"
                                   accept="image/jpeg,image/jpg,image/png,image/gif,video/mp4,video/mov,video/avi">
                            <small class="text-muted">
                                Supported formats: JPEG, JPG, PNG, GIF, MP4, MOV, AVI (Max: 100MB)
                            </small>
                            @error('media')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Area -->
                        <div id="mediaPreview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview:</label>
                            <div id="previewContent"></div>
                        </div>
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-toggle-on me-2"></i>Story Status</h5>
                    </div>
                    <div class="card-body">
                        <label class="form-label">Initial Status <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_pending" value="pending" {{ old('status', 'pending') === 'pending' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_pending">
                                        <span class="badge bg-warning">Pending</span>
                                        <p class="small text-muted mb-0">Requires review</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_approved" value="approved" {{ old('status') === 'approved' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_approved">
                                        <span class="badge bg-success">Approved</span>
                                        <p class="small text-muted mb-0">Visible to public</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_rejected" value="rejected" {{ old('status') === 'rejected' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_rejected">
                                        <span class="badge bg-danger">Rejected</span>
                                        <p class="small text-muted mb-0">Not published</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.stories.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="button" id="submit-btn" class="btn btn-primary" onclick="performStore()">
                                <i class="bi bi-save me-2"></i>Create Story
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

    .form-check-input:checked {
        background-color: #b70003;
        border-color: #b70003;
    }

    #previewContent img,
    #previewContent video {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
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
        selector: '#content_create',
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

    // Media preview
    document.getElementById('media_create').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            formChanged = true; // Mark form as changed when file is selected
            const previewArea = document.getElementById('mediaPreview');
            const previewContent = document.getElementById('previewContent');

            const reader = new FileReader();
            reader.onload = function(e) {
                if (file.type.startsWith('image/')) {
                    previewContent.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                } else if (file.type.startsWith('video/')) {
                    previewContent.innerHTML = `<video controls><source src="${e.target.result}" type="${file.type}"></video>`;
                }
                previewArea.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Track changes in form inputs (except the hidden ones)
    const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea:not(#content_create)');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            formChanged = true;
        });
    });

    // Warn if trying to leave with unsaved changes
    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Perform store operation
    function performStore() {
        // Ensure TinyMCE content is saved to textarea
        if (tinymce.get('content_create')) {
            tinymce.get('content_create').save();
        }

        // Create FormData and manually add all fields
        const formData = new FormData();

        // Add text fields
        formData.append('title', document.getElementById('title_create').value);
        formData.append('content', document.getElementById('content_create').value);
        formData.append('name', document.getElementById('name_create').value);

        // Age field (optional)
        const ageValue = document.getElementById('age_create').value;
        if (ageValue) {
            formData.append('age', ageValue);
        }

        formData.append('story_type', document.getElementById('story_type_create').value);
        formData.append('location', document.getElementById('location_create').value);
        formData.append('date', document.getElementById('date_create').value);

        // Add media file if selected
        const mediaInput = document.getElementById('media_create');
        if (mediaInput.files.length > 0) {
            formData.append('media', mediaInput.files[0]);
        }

        // Add status (get selected radio button value)
        const statusRadio = document.querySelector('input[name="status"]:checked');
        if (statusRadio) {
            formData.append('status', statusRadio.value);
        }

        // Call CRUD post function
        const url = '{{ route("dashboard.stories.store") }}';
        const redirectUrl = '{{ route("dashboard.stories.index") }}';

        // Mark form as unchanged to prevent unsaved changes warning
        formChanged = false;

        // Use FormData for file uploads
        post(url, formData, 'submit-btn', redirectUrl, 'createStoryForm');
    }
</script>
@endpush
