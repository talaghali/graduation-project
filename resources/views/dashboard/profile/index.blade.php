@extends('dashboard.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Profile Information Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profile Information</h5>
                </div>
                <div class="card-body">
                    <form id="profileForm" action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name_{{ auth()->id() }}" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name_{{ auth()->id() }}"
                                       name="first_name"
                                       value="{{ old('first_name', $user->first_name) }}"
                                       required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name_{{ auth()->id() }}" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name_{{ auth()->id() }}"
                                       name="last_name"
                                       value="{{ old('last_name', $user->last_name) }}"
                                       required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email_{{ auth()->id() }}" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email_{{ auth()->id() }}"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_{{ auth()->id() }}" class="form-label">Phone Number</label>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone_{{ auth()->id() }}"
                                   name="phone"
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="date_of_birth_{{ auth()->id() }}" class="form-label">Date of Birth</label>
                            <input type="date"
                                   class="form-control @error('date_of_birth') is-invalid @enderror"
                                   id="date_of_birth_{{ auth()->id() }}"
                                   name="date_of_birth"
                                   value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <button type="button" id="submit-profile-btn" class="btn btn-primary" onclick="updateProfile()">
                                <i class="bi bi-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Change Password</h5>
                </div>
                <div class="card-body">
                    <form id="passwordForm" action="{{ route('dashboard.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control"
                                   id="current_password"
                                   name="current_password"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control"
                                   id="new_password"
                                   name="new_password"
                                   required>
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>

                        <div class="mb-0">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control"
                                   id="new_password_confirmation"
                                   name="new_password_confirmation"
                                   required>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <button type="button" id="submit-password-btn" class="btn btn-warning" onclick="updatePassword()">
                                <i class="bi bi-key me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Update Profile
    function updateProfile() {
        const userId = {{ auth()->id() }};
        const formData = new FormData();

        formData.append('first_name', document.getElementById('first_name_' + userId).value);
        formData.append('last_name', document.getElementById('last_name_' + userId).value);
        formData.append('email', document.getElementById('email_' + userId).value);
        formData.append('phone', document.getElementById('phone_' + userId).value);
        formData.append('date_of_birth', document.getElementById('date_of_birth_' + userId).value);

        const url = '{{ route("dashboard.profile.update") }}';
        const redirectUrl = '{{ route("dashboard.profile.index") }}';

        put(url, formData, 'submit-profile-btn', redirectUrl, 'profileForm');
    }

    // Update Password
    function updatePassword() {
        const formData = new FormData();

        formData.append('current_password', document.getElementById('current_password').value);
        formData.append('new_password', document.getElementById('new_password').value);
        formData.append('new_password_confirmation', document.getElementById('new_password_confirmation').value);

        const url = '{{ route("dashboard.profile.password") }}';

        const button = document.getElementById('submit-password-btn');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';

        axios.put(url, formData)
            .then((response) => {
                Toast.fire({ icon: 'success', title: response.data.message });
                // Clear password fields
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('new_password_confirmation').value = '';
                button.disabled = false;
                button.innerHTML = originalText;
            })
            .catch((error) => {
                let errorMessage = 'An error occurred. Please try again.';
                if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                } else if (error.response?.data?.errors) {
                    const errors = Object.values(error.response.data.errors).flat();
                    errorMessage = errors.join('<br>');
                }
                Toast.fire({ icon: 'error', title: errorMessage });
                button.disabled = false;
                button.innerHTML = originalText;
            });
    }
</script>
@endpush
