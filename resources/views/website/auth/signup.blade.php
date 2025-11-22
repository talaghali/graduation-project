@extends('website.layouts.app')

@section('title', 'Sign up - Voices Of Gaza')

@section('content')
    <section class="sign-logSec">
        <div class="container-fluid ">
            <div class="around-border">
                <div class="row gap-0 ">
                    <div
                        class="col-lg-5 col-md-12 left-panel d-flex align-items-center justify-content-center p-2 flex-column text-center">
                        <div class="circle">
                            <img src="{{ asset('front/img/logo f.png') }}" alt="logo">
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 right-panel d-flex justify-content-center align-items-center p-4">
                        <div class="form-side">
                            <img src="{{ asset('front/img/logo f.png') }}" alt="logo" style="width: 81px; height: 46px;">
                            <p class="form-titel">Create account</p>
                            <p class="form-caption">Start your journey with Voices Of Gaza</p>
                            <form id="signupForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="firstName">First name</label>
                                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                                        <div class="invalid-feedback" id="error-first_name"></div>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <label for="lastName">Last name</label>
                                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                                        <div class="invalid-feedback" id="error-last_name"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email">Email or phone number</label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                        <div class="invalid-feedback" id="error-email"></div>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <label for="dateOfBirth">Date of birth (YYYY-MM-DD)</label>
                                        <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth">
                                        <div class="invalid-feedback" id="error-date_of_birth"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" required>
                                        <div class="invalid-feedback" id="error-password"></div>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <label for="confirmPassword">Confirm password</label>
                                        <input type="password" id="confirmPassword" name="password_confirmation" class="form-control" required>
                                        <div class="invalid-feedback" id="error-password_confirmation"></div>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="remember">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="termsAccepted" name="terms_accepted" required>
                                    <label class="form-check-label" for="termsAccepted">
                                        I agree to all the <span class="form-red">Terms</span> and
                                        <span class="form-red"> Privacy policy </span>
                                    </label>
                                    <div class="invalid-feedback" id="error-terms_accepted"></div>
                                </div>

                                <div class="row mb-3 mt-4 gap-1">
                                    <div class="col-12 col-md-auto mb-2 mb-md-0">
                                        <button type="submit" id="signupBtn"
                                            class="text-decoration-none text-white sign-logBtn rounded-1 text-center border-0">
                                            Create account
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-auto">
                                        <a href="#"
                                            class="text-decoration-none text-white google-btn rounded-1  text-center">
                                            <img src="{{ asset('front/img/googel sign.png') }}" alt="googel icon"
                                                style="width: 20px; height: 20px;" class="me-2">
                                            Sign-in with Google
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-center mt-4">
                                    <small>Don't have an account? <span><a href="{{ route('login') }}"
                                                class="text-decoration-none form-red">Log In</a>
                                        </span>
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('signupForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        // Get form data
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                         document.querySelector('input[name="_token"]')?.value;

        // Disable submit button
        const submitBtn = document.getElementById('signupBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating account...';

        try {
            const response = await axios.post('{{ route("api.register") }}', data, {
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
                    confirmButtonColor: '#b70003',
                    confirmButtonText: 'Continue'
                });

                // Redirect to home page
                window.location.href = '{{ route("index") }}';
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                // Validation errors
                const errors = error.response.data.errors;

                for (let field in errors) {
                    const input = document.querySelector(`[name="${field}"]`);
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
                // Other errors
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'An error occurred. Please try again.',
                    confirmButtonColor: '#b70003'
                });
            }
        } finally {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
</script>
@endpush
