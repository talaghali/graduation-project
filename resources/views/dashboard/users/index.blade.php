@extends('dashboard.layouts.app')
@section('title', 'User Management')
@section('page-title', 'User Management')
@section('content')
<div class="card border-0 shadow-sm mb-4">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-4">
<div>
<h5 class="mb-1">Registered Users</h5>
<p class="text-muted mb-0">View users and their submitted stories</p>
</div>
<div class="text-muted">
<strong>{{ $users->total() }}</strong> total users
</div>
</div>
<form method="GET" action="{{ route('dashboard.users.index') }}" class="row g-3 mb-4">
<div class="col-md-5">
<input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
</div>
<div class="col-md-3">
<input type="date" name="date_from" class="form-control" placeholder="From date" value="{{ request('date_from') }}">
</div>
<div class="col-md-3">
<input type="date" name="date_to" class="form-control" placeholder="To date" value="{{ request('date_to') }}">
</div>
<div class="col-md-1">
<button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
</div>
@if(request('search') || request('date_from') || request('date_to'))
<div class="col-12">
<a href="{{ route('dashboard.users.index') }}" class="btn btn-sm btn-outline-secondary">
<i class="bi bi-x-circle me-1"></i>Clear Filters
</a>
</div>
@endif
</form>
</div>
</div>
<div class="card border-0 shadow-sm">
<div class="card-body">
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr>
<th>User</th>
<th>Email</th>
<th>Phone</th>
<th>Stories</th>
<th>Joined</th>
<th width="150">Actions</th>
</tr>
</thead>
<tbody>
@forelse($users as $user)
<tr>
<td>
<div class="d-flex align-items-center">
<div class="avatar-circle me-3">
{{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
</div>
<div>
<strong class="d-block">{{ $user->first_name }} {{ $user->last_name }}</strong>
<small class="text-muted">ID: #{{ $user->id }}</small>
</div>
</div>
</td>
<td>{{ $user->email }}</td>
<td>{{ $user->phone ?? '-' }}</td>
<td>
<a href="{{ route('dashboard.users.show', $user->id) }}" class="badge bg-primary text-decoration-none">
{{ $user->stories_count }} {{ Str::plural('story', $user->stories_count) }}
</a>
</td>
<td>
<small class="text-muted">
{{ $user->created_at->format('M d, Y') }}<br>
{{ $user->created_at->diffForHumans() }}
</small>
</td>
<td>
<div class="btn-group" role="group">
<a href="{{ route('dashboard.users.show', $user->id) }}"
   class="btn btn-sm btn-outline-primary"
   data-bs-toggle="tooltip"
   title="View Details">
<i class="bi bi-eye"></i>
</a>
<button onclick="deleteUser({{ $user->id }})"
        class="btn btn-sm btn-outline-danger"
        data-bs-toggle="tooltip"
        title="Delete User">
<i class="bi bi-trash"></i>
</button>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="text-center py-5 text-muted">
<i class="bi bi-people display-4 d-block mb-3"></i>
<p class="mb-0">No users found</p>
@if(request('search'))
<p class="text-muted">Try adjusting your search criteria</p>
@endif
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
@if($users->hasPages())
<div class="mt-4">
{{ $users->links() }}
</div>
@endif
</div>
</div>
@endsection
@push('styles')
<style>
.avatar-circle{width:40px;height:40px;background:linear-gradient(135deg,#b70003 0%,#8b0002 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;font-size:0.85rem}
</style>
@endpush
@push('scripts')
<script>
async function deleteUser(id){const result=await Swal.fire({title:'Delete User?',text:'This will also delete all their stories and cannot be undone!',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc3545',cancelButtonColor:'#6c757d',confirmButtonText:'Yes, Delete',cancelButtonText:'Cancel'});if(result.isConfirmed){try{const response=await axios.delete(`/dashboard/users/${id}`);if(response.data.success){Toast.fire({icon:'success',title:response.data.message});setTimeout(()=>{location.reload()},1000)}}catch(error){let errorMessage='Failed to delete user.';if(error.response?.data?.message){errorMessage=error.response.data.message}Swal.fire({icon:'error',title:'Error',text:errorMessage,confirmButtonColor:'#b70003'})}}}
document.addEventListener('DOMContentLoaded',function(){const tooltipTriggerList=[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));tooltipTriggerList.map(function(tooltipTriggerEl){return new bootstrap.Tooltip(tooltipTriggerEl)})});
</script>
@endpush
