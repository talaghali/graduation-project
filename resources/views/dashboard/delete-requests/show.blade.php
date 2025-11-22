@extends('dashboard.layouts.app')
@section('title', 'Delete Request Details')
@section('page-title', 'Delete Request #' . $deleteRequest->id)
@section('content')
<div class="row">
<div class="col-lg-8">
<div class="card border-0 shadow-sm mb-4">
<div class="card-header bg-white border-bottom">
<h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Story Information</h5>
</div>
<div class="card-body">
@if($deleteRequest->story)
<div class="mb-3">
<label class="text-muted small d-block mb-1">Story Title</label>
<h6 class="mb-0">{{ $deleteRequest->story->title }}</h6>
</div>
<hr>
<div class="mb-3">
<label class="text-muted small d-block mb-1">Story Content</label>
<div class="story-content">{{ Str::limit(strip_tags($deleteRequest->story->content), 300) }}</div>
</div>
<hr>
<div class="row">
<div class="col-md-6">
<label class="text-muted small d-block mb-1">Status</label>
<span class="badge bg-{{ $deleteRequest->story->status_badge_color }}">{{ ucfirst($deleteRequest->story->status) }}</span>
</div>
<div class="col-md-6">
<label class="text-muted small d-block mb-1">Created</label>
<p class="mb-0">{{ $deleteRequest->story->created_at->format('M d, Y h:i A') }}</p>
</div>
</div>
<hr>
<a href="{{ route('dashboard.stories.show', $deleteRequest->story->id) }}" class="btn btn-outline-primary" target="_blank">
<i class="bi bi-eye me-2"></i>View Full Story
</a>
@else
<div class="alert alert-warning mb-0">
<i class="bi bi-exclamation-triangle me-2"></i>
This story has already been deleted.
</div>
@endif
</div>
</div>
<div class="card border-0 shadow-sm">
<div class="card-header bg-white border-bottom">
<h5 class="mb-0"><i class="bi bi-chat-left-text me-2"></i>Delete Request Details</h5>
</div>
<div class="card-body">
<div class="mb-3">
<label class="text-muted small d-block mb-1">Request Status</label>
@if($deleteRequest->status === 'pending')
<span class="badge bg-warning text-dark fs-6">Pending Review</span>
@elseif($deleteRequest->status === 'approved')
<span class="badge bg-success fs-6">Approved</span>
@else
<span class="badge bg-danger fs-6">Rejected</span>
@endif
</div>
<hr>
<div class="mb-3">
<label class="text-muted small d-block mb-1">User's Reason</label>
<p class="mb-0">{{ $deleteRequest->reason ?? 'No reason provided' }}</p>
</div>
@if($deleteRequest->status !== 'pending')
<hr>
<div class="mb-3">
<label class="text-muted small d-block mb-1">Handled By</label>
<p class="mb-0">
@if($deleteRequest->handledBy)
{{ $deleteRequest->handledBy->first_name }} {{ $deleteRequest->handledBy->last_name }}
@else
Unknown
@endif
</p>
</div>
<div class="mb-3">
<label class="text-muted small d-block mb-1">Handled At</label>
<p class="mb-0">{{ $deleteRequest->handled_at?->format('M d, Y h:i A') }}</p>
</div>
@if($deleteRequest->admin_notes)
<div class="mb-0">
<label class="text-muted small d-block mb-1">Admin Notes</label>
<div class="alert alert-info mb-0">{{ $deleteRequest->admin_notes }}</div>
</div>
@endif
@endif
</div>
</div>
</div>
<div class="col-lg-4">
<div class="card border-0 shadow-sm mb-4">
<div class="card-header bg-white border-bottom">
<h5 class="mb-0"><i class="bi bi-person me-2"></i>Requester Info</h5>
</div>
<div class="card-body">
<div class="text-center mb-3">
<div class="avatar-circle-large mx-auto">
{{ strtoupper(substr($deleteRequest->user->first_name, 0, 1)) }}{{ strtoupper(substr($deleteRequest->user->last_name, 0, 1)) }}
</div>
</div>
<div class="text-center mb-3">
<h6 class="mb-1">{{ $deleteRequest->user->first_name }} {{ $deleteRequest->user->last_name }}</h6>
<p class="text-muted small mb-0">{{ $deleteRequest->user->email }}</p>
</div>
<hr>
<div class="mb-2">
<label class="text-muted small d-block mb-1">Requested Date</label>
<p class="mb-0">{{ $deleteRequest->created_at->format('M d, Y') }}</p>
<small class="text-muted">{{ $deleteRequest->created_at->diffForHumans() }}</small>
</div>
</div>
</div>
@if($deleteRequest->status === 'pending')
<div class="card border-0 shadow-sm">
<div class="card-header bg-white border-bottom">
<h5 class="mb-0"><i class="bi bi-gear me-2"></i>Actions</h5>
</div>
<div class="card-body">
<div class="d-grid gap-2">
<button onclick="approveRequest({{ $deleteRequest->id }})" class="btn btn-success">
<i class="bi bi-check-circle me-2"></i>Approve Request
</button>
<button onclick="rejectRequest({{ $deleteRequest->id }})" class="btn btn-danger">
<i class="bi bi-x-circle me-2"></i>Reject Request
</button>
<a href="{{ route('dashboard.delete-requests.index') }}" class="btn btn-outline-secondary">
<i class="bi bi-arrow-left me-2"></i>Back to List
</a>
</div>
</div>
</div>
@else
<div class="card border-0 shadow-sm">
<div class="card-body text-center">
<a href="{{ route('dashboard.delete-requests.index') }}" class="btn btn-outline-secondary w-100">
<i class="bi bi-arrow-left me-2"></i>Back to List
</a>
</div>
</div>
@endif
</div>
</div>
@endsection
@push('styles')
<style>
.avatar-circle-large{width:80px;height:80px;background:linear-gradient(135deg,#b70003 0%,#8b0002 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:2rem}
.story-content{background:#f8f9fa;padding:1rem;border-radius:8px;border-left:4px solid #b70003}
</style>
@endpush
@push('scripts')
<script>
async function approveRequest(id){const{value:notes}=await Swal.fire({title:'Approve Delete Request',input:'textarea',inputLabel:'Admin Notes (Optional)',inputPlaceholder:'Add any notes about this approval...',showCancelButton:true,confirmButtonColor:'#28a745',cancelButtonColor:'#6c757d',confirmButtonText:'Approve & Delete Story',cancelButtonText:'Cancel'});if(notes!==undefined){try{const response=await axios.post(`/dashboard/delete-requests/${id}/approve`,{admin_notes:notes});if(response.data.success){await Swal.fire({icon:'success',title:'Approved!',text:response.data.message,confirmButtonColor:'#b70003'});window.location.href='{{ route("dashboard.delete-requests.index") }}'}}catch(error){Swal.fire({icon:'error',title:'Error',text:error.response?.data?.message||'Failed to approve request.',confirmButtonColor:'#b70003'})}}}
async function rejectRequest(id){const{value:notes}=await Swal.fire({title:'Reject Delete Request',input:'textarea',inputLabel:'Reason for Rejection (Required)',inputPlaceholder:'Explain why this request is being rejected...',inputValidator:(value)=>{if(!value){return'You need to provide a reason!'}},showCancelButton:true,confirmButtonColor:'#dc3545',cancelButtonColor:'#6c757d',confirmButtonText:'Reject Request',cancelButtonText:'Cancel'});if(notes){try{const response=await axios.post(`/dashboard/delete-requests/${id}/reject`,{admin_notes:notes});if(response.data.success){await Swal.fire({icon:'success',title:'Rejected!',text:response.data.message,confirmButtonColor:'#b70003'});window.location.href='{{ route("dashboard.delete-requests.index") }}'}}catch(error){Swal.fire({icon:'error',title:'Error',text:error.response?.data?.message||'Failed to reject request.',confirmButtonColor:'#b70003'})}}}
</script>
@endpush
