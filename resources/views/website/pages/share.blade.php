@extends('website.layouts.app')

@section('title', 'Share Your Story - Voices Of Gaza')

@section('content')
    <!-- section بداية  -->
    <section class="share-large shadow-sm">
        <div class="container-fluid p-0">
            <div class="share-background d-flex justify-content-center align-items-center text-center text-white"
                data-aos="fade-up" data-aos-duration="1000">
                <div>
                    <p class="main-headings">Share your story with the world</p>
                    <p class="share-p p-2" style="max-width: 845px;">Help us document your voice and your story so that
                        the
                        truth
                        remains present in
                        memory.</p>
                </div>
            </div>
            <section class="form mt-5">
                <div class="container-fluid">
                    <form id="storyForm" class="form-border form-center p-5" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control form-control-w" placeholder="optional">
                            </div>
                            <div class="col">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" class="form-control form-control-w" placeholder="optional" min="1" max="150">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col pb-5">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control form-control-w" placeholder="optional">
                            </div>
                            <hr>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Story Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Your Story <span class="text-danger">*</span></label>
                            <textarea id="content" name="content" class="form-control story-textarea"
                                placeholder="Tell your story in detail..." required></textarea>
                        </div>
                        <div class="mt-5">
                            <label class="form-label">Upload Photo or Video</label>
                            <label class="upload-box" style="height:223px">
                                <input type="file" name="media" id="mediaUpload" accept="image/*,video/*" hidden>
                                <div class="text-center" id="uploadPreview">
                                    <div class="fs-3">+</div>
                                    <div>Upload Photo or Video</div>
                                </div>
                            </label>
                            <small class="text-muted">Maximum file size: 50MB. Supported formats: JPG, PNG, GIF, MP4, MOV, AVI</small>
                        </div>

                        <div class="row mt-4">
                            <div class="col pb-5">
                                <label class="form-label">Story Type</label>
                                <input type="text" name="story_type" class="form-control form-control-w" placeholder="e.g., Personal, Family, Journalist">
                            </div>
                        </div>



                        <!--  Popup حركة/نموذج  -->
                        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered custom-modal">
                                <div class="modal-content text-center p-4">
                                    <div
                                        class="modal-body d-flex flex-column justify-content-center align-items-center text-center">
                                        <p id="successModalLabel">Story submitted successfully!</p>
                                        <p id="successModalLabel-two">Thank you for being part of our collective memory.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" id="submitBtn"
                                class="submit-btn rounded-3 d-flex align-items-center justify-content-center border-0">
                                <span class="text-white">Submit Story</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/rnnwqb5qb51b3r1rw76jgr4nj74a3mougohwna6euymoltpu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'charmap',
                'searchreplace', 'visualblocks', 'code',
                'insertdatetime', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat | help',
            content_style: 'body { font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; line-height: 1.6; }',
            placeholder: 'Tell your story in detail...',
            setup: function(editor) {
                editor.on('init', function() {
                    // Add placeholder styling
                    if (editor.getContent() === '') {
                        editor.setContent('');
                    }
                });
            }
        });
    </script>

    <script>
        AOS.init();
    </script>

    <!-- سكربت خاص بالهوفر قوائم الناف بار  -->
    <script>
        // الحصول على كل الروابط في القائمة
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                // فقط امنع التنقل إذا الرابط هو "#" أو فارغ
                if (this.getAttribute('href') === '#' || this.getAttribute('href') === '') {
                    e.preventDefault();
                }

                // إزالة active من كل الروابط
                navLinks.forEach(l => l.classList.remove('active'));

                // إضافة active للرابط المضغوط
                this.classList.add('active');
            });
        });
    </script>

    <!-- Story submission script -->
    <script>
        document.getElementById('storyForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');

            // Save TinyMCE content before creating FormData
            if (tinymce.get('content')) {
                tinymce.get('content').save();
            }

            const formData = new FormData(this);

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.querySelector('span').textContent = 'Submitting...';

            try {
                const response = await axios.post('{{ route("stories.store") }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.success) {
                    // Show success modal
                    const modal = new bootstrap.Modal(document.getElementById('successModal'));
                    modal.show();

                    // Reset form and TinyMCE
                    this.reset();
                    if (tinymce.get('content')) {
                        tinymce.get('content').setContent('');
                    }
                    document.getElementById('uploadPreview').innerHTML = `
                        <div class="fs-3">+</div>
                        <div>Upload Photo or Video</div>
                    `;

                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route("stories.my") }}';
                    }, 2000);
                }
            } catch (error) {
                console.error('Error:', error);

                let errorMessage = 'Failed to submit story. Please try again.';

                if (error.response?.data?.errors) {
                    const errors = Object.values(error.response.data.errors).flat();
                    errorMessage = errors.join('<br>');
                }

                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessage,
                    confirmButtonColor: '#b70003'
                });
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.querySelector('span').textContent = 'Submit Story';
            }
        });

        // File upload preview
        document.getElementById('mediaUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('uploadPreview');
                const fileType = file.type.startsWith('image/') ? 'Image' : 'Video';
                preview.innerHTML = `
                    <div class="text-success">
                        <i class="bi bi-check-circle fs-3"></i>
                        <div class="mt-2">${fileType} selected: ${file.name}</div>
                        <small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                    </div>
                `;
            }
        });
    </script>
@endpush
