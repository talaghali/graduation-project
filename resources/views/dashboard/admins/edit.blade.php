@extends('dashboard.layouts.app')
@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('content')
<div class="row"><div class="col-lg-8 mx-auto">
<div class="card border-0 shadow-sm mb-4"><div class="card-body">
<form id="editAdminForm" action="{{ route('dashboard.admins.update', $admin) }}" method="POST">
@csrf
@method('PUT')
<div class="row">
<div class="col-md-6 mb-3">
<label for="first_name_{{ $admin->id }}" class="form-label">First Name *</label>
<input type="text" class="form-control" id="first_name_{{ $admin->id }}" name="first_name" value="{{ $admin->first_name }}" required>
</div>
<div class="col-md-6 mb-3">
<label for="last_name_{{ $admin->id }}" class="form-label">Last Name *</label>
<input type="text" class="form-control" id="last_name_{{ $admin->id }}" name="last_name" value="{{ $admin->last_name }}" required>
</div>
</div>
<div class="mb-3">
<label for="email_{{ $admin->id }}" class="form-label">Email *</label>
<input type="email" class="form-control" id="email_{{ $admin->id }}" name="email" value="{{ $admin->email }}" required>
</div>
<div class="mb-3">
<label for="phone_{{ $admin->id }}" class="form-label">Phone</label>
<input type="tel" class="form-control" id="phone_{{ $admin->id }}" name="phone" value="{{ $admin->phone }}">
</div>
<div class="mb-3">
<label for="date_of_birth_{{ $admin->id }}" class="form-label">Date of Birth</label>
<input type="date" class="form-control" id="date_of_birth_{{ $admin->id }}" name="date_of_birth" value="{{ $admin->date_of_birth?->format('Y-m-d') }}">
</div>
<hr class="my-3">
<p class="text-muted mb-3"><small>Leave password fields empty to keep current password</small></p>
<div class="mb-3">
<label for="password_{{ $admin->id }}" class="form-label">New Password</label>
<input type="password" class="form-control" id="password_{{ $admin->id }}" name="password">
</div>
<div class="mb-3">
<label for="password_confirmation_{{ $admin->id }}" class="form-label">Confirm Password</label>
<input type="password" class="form-control" id="password_confirmation_{{ $admin->id }}" name="password_confirmation">
</div>
<hr class="my-4">
<div class="d-flex justify-content-between">
<a href="{{ route('dashboard.admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
<button type="button" id="submit-btn_{{ $admin->id }}" class="btn btn-primary" onclick="performUpdate{{ $admin->id }}()">Update Admin</button>
</div>
</form>
</div></div>
</div></div>
@endsection
@push('scripts')
<script>
function performUpdate{{ $admin->id }}() {
    const id = {{ $admin->id }};
    const formData = new FormData();
    formData.append('first_name', document.getElementById('first_name_' + id).value);
    formData.append('last_name', document.getElementById('last_name_' + id).value);
    formData.append('email', document.getElementById('email_' + id).value);
    formData.append('phone', document.getElementById('phone_' + id).value);
    formData.append('date_of_birth', document.getElementById('date_of_birth_' + id).value);
    const password = document.getElementById('password_' + id).value;
    if (password) {
        formData.append('password', password);
        formData.append('password_confirmation', document.getElementById('password_confirmation_' + id).value);
    }
    const url = '{{ route("dashboard.admins.update", $admin) }}';
    const redirectUrl = '{{ route("dashboard.admins.index") }}';
    put(url, formData, 'submit-btn_' + id, redirectUrl, 'editAdminForm');
}
</script>
@endpush
