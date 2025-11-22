@extends('dashboard.layouts.app')
@section('title', 'Add New Admin')
@section('page-title', 'Add New Admin')
@section('content')
<div class="row"><div class="col-lg-8 mx-auto">
<div class="card border-0 shadow-sm mb-4"><div class="card-body">
<form id="createAdminForm" action="{{ route('dashboard.admins.store') }}" method="POST">
@csrf
<div class="row">
<div class="col-md-6 mb-3">
<label for="first_name_create" class="form-label">First Name *</label>
<input type="text" class="form-control" id="first_name_create" name="first_name" required>
</div>
<div class="col-md-6 mb-3">
<label for="last_name_create" class="form-label">Last Name *</label>
<input type="text" class="form-control" id="last_name_create" name="last_name" required>
</div>
</div>
<div class="mb-3">
<label for="email_create" class="form-label">Email *</label>
<input type="email" class="form-control" id="email_create" name="email" required>
</div>
<div class="mb-3">
<label for="phone_create" class="form-label">Phone</label>
<input type="tel" class="form-control" id="phone_create" name="phone">
</div>
<div class="mb-3">
<label for="date_of_birth_create" class="form-label">Date of Birth</label>
<input type="date" class="form-control" id="date_of_birth_create" name="date_of_birth">
</div>
<div class="mb-3">
<label for="password_create" class="form-label">Password *</label>
<input type="password" class="form-control" id="password_create" name="password" required>
</div>
<div class="mb-3">
<label for="password_confirmation_create" class="form-label">Confirm Password *</label>
<input type="password" class="form-control" id="password_confirmation_create" name="password_confirmation" required>
</div>
<hr class="my-4">
<div class="d-flex justify-content-between">
<a href="{{ route('dashboard.admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
<button type="button" id="submit-btn" class="btn btn-primary" onclick="performStore()">Create Admin</button>
</div>
</form>
</div></div>
</div></div>
@endsection
@push('scripts')
<script>
function performStore() {
    const formData = new FormData();
    formData.append('first_name', document.getElementById('first_name_create').value);
    formData.append('last_name', document.getElementById('last_name_create').value);
    formData.append('email', document.getElementById('email_create').value);
    formData.append('phone', document.getElementById('phone_create').value);
    formData.append('date_of_birth', document.getElementById('date_of_birth_create').value);
    formData.append('password', document.getElementById('password_create').value);
    formData.append('password_confirmation', document.getElementById('password_confirmation_create').value);
    const url = '{{ route("dashboard.admins.store") }}';
    const redirectUrl = '{{ route("dashboard.admins.index") }}';
    post(url, formData, 'submit-btn', redirectUrl, 'createAdminForm');
}
</script>
@endpush
