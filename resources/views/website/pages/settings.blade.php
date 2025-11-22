@extends('website.layouts.app')

@section('title', 'Settings - Voices Of Gaza')

@section('content')
    <section class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Settings Header -->
                    <div class="mb-4">
                        <h2 class="text-white">
                            <i class="bi bi-gear me-2"></i>Account Settings
                        </h2>
                        <p class="text-white-50">Manage your account information and preferences</p>
                    </div>

                    <!-- Update Profile Form -->
                    <div class="card shadow-lg border-0 mb-4" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);">
                        <div class="card-body p-4">
                            <h5 class="text-white mb-4">
                                <i class="bi bi-person-lines-fill me-2"></i>Personal Information
                            </h5>
                            <form id="updateProfileForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label text-white-50">First Name</label>
                                        <input type="text" class="form-control bg-dark text-white border-secondary"
                                               id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" required>
                                        <div class="invalid-feedback" id="error-first_name"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label text-white-50">Last Name</label>
                                        <input type="text" class="form-control bg-dark text-white border-secondary"
                                               id="last_name" name="last_name" value="{{ Auth::user()->last_name }}" required>
                                        <div class="invalid-feedback" id="error-last_name"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label text-white-50">Email Address</label>
                                        <input type="email" class="form-control bg-dark text-white border-secondary"
                                               id="email" name="email" value="{{ Auth::user()->email }}" required>
                                        <div class="invalid-feedback" id="error-email"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label text-white-50">Phone Number</label>
                                        <input type="text" class="form-control bg-dark text-white border-secondary"
                                               id="phone" name="phone" value="{{ Auth::user()->phone }}">
                                        <div class="invalid-feedback" id="error-phone"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="date_of_birth" class="form-label text-white-50">Date of Birth</label>
                                    <input type="date" class="form-control bg-dark text-white border-secondary"
                                           id="date_of_birth" name="date_of_birth"
                                           value="{{ Auth::user()->date_of_birth ? Auth::user()->date_of_birth->format('Y-m-d') : '' }}">
                                    <div class="invalid-feedback" id="error-date_of_birth"></div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('profile') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-danger" id="updateProfileBtn">
                                        <i class="bi bi-check-circle me-2"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Form -->
                    <div class="card shadow-lg border-0 mb-4" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);">
                        <div class="card-body p-4">
                            <h5 class="text-white mb-4">
                                <i class="bi bi-shield-lock me-2"></i>Change Password
                            </h5>
                            <form id="changePasswordForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label text-white-50">Current Password</label>
                                    <input type="password" class="form-control bg-dark text-white border-secondary"
                                           id="current_password" name="current_password" required>
                                    <div class="invalid-feedback" id="error-current_password"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label text-white-50">New Password</label>
                                    <input type="password" class="form-control bg-dark text-white border-secondary"
                                           id="new_password" name="new_password" required>
                                    <small class="text-white-50">Minimum 8 characters</small>
                                    <div class="invalid-feedback" id="error-new_password"></div>
                                </div>

                                <div class="mb-4">
                                    <label for="new_password_confirmation" class="form-label text-white-50">Confirm New Password</label>
                                    <input type="password" class="form-control bg-dark text-white border-secondary"
                                           id="new_password_confirmation" name="new_password_confirmation" required>
                                    <div class="invalid-feedback" id="error-new_password_confirmation"></div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger" id="changePasswordBtn">
                                        <i class="bi bi-key me-2"></i>Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="card shadow-lg border-danger" style="background: rgba(183, 0, 3, 0.1); backdrop-filter: blur(10px);">
                        <div class="card-body p-4">
                            <h5 class="text-danger mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                            </h5>
                            <p class="text-white-50 mb-3">
                                Permanently delete your account and all associated data. This action cannot be undone.
                            </p>
                            <button type="button" class="btn btn-outline-danger" id="deleteAccountBtn">
                                <i class="bi bi-trash me-2"></i>Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Update Profile Form
    document.getElementById('updateProfileForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        const submitBtn = document.getElementById('updateProfileBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        try {
            const response = await axios.post('{{ route("api.profile.update") }}', data, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (response.data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.data.message,
                    confirmButtonColor: '#b70003'
                });

                // Reload page to show updated data
                window.location.reload();
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;

                for (let field in errors) {
                    const input = document.querySelector(`#updateProfileForm [name="${field}"]`);
                    const errorDiv = document.getElementById(`error-${field}`);

                    if (input && errorDiv) {
                        input.classList.add('is-invalid');
                        errorDiv.textContent = errors[field][0];
                        errorDiv.style.display = 'block';
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please check the form for errors.',
                    confirmButtonColor: '#b70003'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'Failed to update profile.',
                    confirmButtonColor: '#b70003'
                });
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    // Change Password Form
    document.getElementById('changePasswordForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        const submitBtn = document.getElementById('changePasswordBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';

        try {
            const response = await axios.post('{{ route("api.password.update") }}', data, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (response.data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.data.message,
                    confirmButtonColor: '#b70003'
                });

                // Clear form
                this.reset();
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;

                for (let field in errors) {
                    const input = document.querySelector(`#changePasswordForm [name="${field}"]`);
                    const errorDiv = document.getElementById(`error-${field}`);

                    if (input && errorDiv) {
                        input.classList.add('is-invalid');
                        errorDiv.textContent = errors[field][0];
                        errorDiv.style.display = 'block';
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please check the form for errors.',
                    confirmButtonColor: '#b70003'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'Failed to update password.',
                    confirmButtonColor: '#b70003'
                });
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    // Delete Account
    document.getElementById('deleteAccountBtn').addEventListener('click', async function() {
        const result = await Swal.fire({
            title: 'Delete Account?',
            text: 'This will permanently delete your account and all associated data. This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b70003',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete my account',
            cancelButtonText: 'Cancel',
            input: 'password',
            inputLabel: 'Enter your password to confirm',
            inputPlaceholder: 'Password',
            inputAttributes: {
                autocomplete: 'off'
            }
        });

        if (result.isConfirmed && result.value) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                const response = await axios.post('{{ route("api.account.delete") }}', {
                    password: result.value
                }, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Account Deleted',
                        text: 'Your account has been permanently deleted.',
                        confirmButtonColor: '#b70003'
                    });

                    window.location.href = '{{ route("index") }}';
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'Failed to delete account.',
                    confirmButtonColor: '#b70003'
                });
            }
        }
    });
</script>
@endpush
