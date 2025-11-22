@extends('dashboard.layouts.app')
@section('title', 'Admin Details')
@section('page-title', 'Admin Details')
@section('content')
<div class="row">
<div class="col-lg-4 mb-4">
<div class="card border-0 shadow-sm">
<div class="card-body text-center">
<div class="avatar-circle-large mx-auto mb-3">
{{ strtoupper(substr($admin->first_name, 0, 1)) }}{{ strtoupper(substr($admin->last_name, 0, 1)) }}
</div>
<h4 class="mb-1">{{ $admin->first_name }} {{ $admin->last_name }}</h4>
<p class="text-muted mb-3">
<span class="badge bg-danger">Administrator</span>
<br><small>ID: #{{ $admin->id }}</small>
</p>
<hr>
<div class="text-start">
<div class="mb-3">
<label class="text-muted small d-block mb-1">Email</label>
<strong>{{ $admin->email }}</strong>
</div>
<div class="mb-3">
<label class="text-muted small d-block mb-1">Phone</label>
<strong>{{ $admin->phone ?? 'Not provided' }}</strong>
</div>
<div class="mb-3">
<label class="text-muted small d-block mb-1">Date of Birth</label>
<strong>{{ $admin->date_of_birth ? $admin->date_of_birth->format('M d, Y') : 'Not provided' }}</strong>
</div>
<div class="mb-3">
<label class="text-muted small d-block mb-1">Admin Since</label>
<strong>{{ $admin->created_at->format('M d, Y') }}</strong>
<br><small class="text-muted">{{ $admin->created_at->diffForHumans() }}</small>
</div>
<div class="mb-0">
<label class="text-muted small d-block mb-1">Total Stories</label>
<strong class="text-primary">{{ $admin->stories_count }}</strong>
</div>
</div>
<hr>
<div class="d-grid gap-2">
<a href="{{ route('dashboard.admins.index') }}" class="btn btn-outline-secondary">
<i class="bi bi-arrow-left me-2"></i>Back to Admins
</a>
<a href="{{ route('dashboard.admins.edit', $admin->id) }}" class="btn btn-outline-primary">
<i class="bi bi-pencil me-2"></i>Edit Admin
</a>
@if($admin->id !== auth()->id())
<button onclick="deleteAdmin({{ $admin->id }})" class="btn btn-outline-danger">
<i class="bi bi-trash me-2"></i>Delete Admin
</button>
@endif
</div>
</div>
</div>
</div>
<div class="col-lg-8">
<div class="card border-0 shadow-sm">
<div class="card-header bg-white border-bottom">
<h5 class="mb-0"><i class="bi bi-book me-2"></i>Admin Stories ({{ $stories->total() }})</h5>
</div>
<div class="card-body">
@forelse($stories as $story)
<div class="story-item p-3 mb-3 border rounded">
<div class="d-flex justify-content-between align-items-start">
<div class="flex-grow-1">
<h6 class="mb-2">
<a href="{{ route('dashboard.stories.show', $story->id) }}" class="text-decoration-none text-dark">
{{ $story->title }}
</a>
</h6>
<div class="mb-2">
<span class="badge bg-{{ $story->status_badge_color }}">{{ ucfirst($story->status) }}</span>
@if($story->story_type)
<span class="badge bg-secondary">{{ $story->story_type }}</span>
@endif
@if($story->media_type)
<span class="badge bg-info">{{ ucfirst($story->media_type) }}</span>
@endif
</div>
<p class="text-muted small mb-2">{{ Str::limit(strip_tags($story->content), 150) }}</p>
<small class="text-muted">
<i class="bi bi-calendar3"></i> {{ $story->created_at->format('M d, Y h:i A') }}
</small>
</div>
<div class="ms-3">
<a href="{{ route('dashboard.stories.show', $story->id) }}" class="btn btn-sm btn-outline-primary">
<i class="bi bi-eye"></i>
</a>
</div>
</div>
</div>
@empty
<div class="text-center py-5 text-muted">
<i class="bi bi-inbox display-4 d-block mb-3"></i>
<p class="mb-0">This admin hasn't submitted any stories yet</p>
</div>
@endforelse
@if($stories->hasPages())
<div class="mt-4">
{{ $stories->links() }}
</div>
@endif
</div>
</div>
</div>
</div>
@endsection
@push('styles')
<style>
.avatar-circle-large{width:120px;height:120px;background:linear-gradient(135deg,#b70003 0%,#8b0002 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:2.5rem}
.story-item{transition:all 0.3s ease}
.story-item:hover{background:#f8f9fa;transform:translateX(5px)}
</style>
@endpush
@push('scripts')
<script>
async function deleteAdmin(id){const result=await Swal.fire({title:'Delete Admin?',text:'This will also delete all their stories and cannot be undone!',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc3545',cancelButtonColor:'#6c757d',confirmButtonText:'Yes, Delete',cancelButtonText:'Cancel'});if(result.isConfirmed){try{const response=await axios.delete(`/dashboard/admins/${id}`);if(response.data.success){Toast.fire({icon:'success',title:response.data.message});setTimeout(()=>{window.location.href='{{ route("dashboard.admins.index") }}'},1000)}}catch(error){let errorMessage='Failed to delete admin.';if(error.response?.data?.message){errorMessage=error.response.data.message}Swal.fire({icon:'error',title:'Error',text:errorMessage,confirmButtonColor:'#b70003'})}}}
</script>
@endpush
