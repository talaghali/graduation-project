@extends('dashboard.layouts.app')
@section('title', 'Delete Requests')
@section('page-title', 'Delete Requests Management')
@section('content')
<div class="card border-0 shadow-sm mb-4">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
<div>
<h5 class="mb-1">Story Delete Requests</h5>
<p class="text-muted mb-0">Review and manage user story deletion requests</p>
</div>
<div class="btn-group" role="group">
<a href="{{ route('dashboard.delete-requests.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status', 'pending') === 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
Pending
</a>
<a href="{{ route('dashboard.delete-requests.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') === 'approved' ? 'btn-success' : 'btn-outline-success' }}">
Approved
</a>
<a href="{{ route('dashboard.delete-requests.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
Rejected
</a>
<a href="{{ route('dashboard.delete-requests.index') }}" class="btn btn-sm btn-outline-secondary">
All
</a>
</div>
</div>
</div>
</div>
<div class="card border-0 shadow-sm">
<div class="card-body">
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr>
<th>User</th>
<th>Story</th>
<th>Reason</th>
<th>Status</th>
<th>Requested</th>
<th width="150">Actions</th>
</tr>
</thead>
<tbody>
@forelse($requests as $request)
<tr>
<td>
<div class="d-flex align-items-center">
<div class="avatar-circle me-2">
{{ strtoupper(substr($request->user->first_name, 0, 1)) }}{{ strtoupper(substr($request->user->last_name, 0, 1)) }}
</div>
<div>
<strong class="d-block">{{ $request->user->first_name }} {{ $request->user->last_name }}</strong>
<small class="text-muted">{{ $request->user->email }}</small>
</div>
</div>
</td>
<td>
@if($request->story)
<div>
<strong class="d-block">{{ Str::limit($request->story->title, 40) }}</strong>
<small class="text-muted">ID: #{{ $request->story->id }}</small>
</div>
@else
<span class="text-danger">Story Deleted</span>
@endif
</td>
<td>
<small>{{ Str::limit($request->reason ?? 'No reason provided', 50) }}</small>
</td>
<td>
@if($request->status === 'pending')
<span class="badge bg-warning text-dark">Pending</span>
@elseif($request->status === 'approved')
<span class="badge bg-success">Approved</span>
@else
<span class="badge bg-danger">Rejected</span>
@endif
</td>
<td>
<small class="text-muted">
{{ $request->created_at->format('M d, Y') }}<br>
{{ $request->created_at->diffForHumans() }}
</small>
</td>
<td>
<div class="btn-group" role="group">
<a href="{{ route('dashboard.delete-requests.show', $request->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
<i class="bi bi-eye"></i>
</a>
@if($request->status === 'pending')
<button onclick="approveRequest({{ $request->id }})" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Approve">
<i class="bi bi-check-circle"></i>
</button>
<button onclick="rejectRequest({{ $request->id }})" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Reject">
<i class="bi bi-x-circle"></i>
</button>
@endif
</div>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="text-center py-5 text-muted">
<i class="bi bi-inbox display-4 d-block mb-3"></i>
<p class="mb-0">No delete requests found</p>
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
@if($requests->hasPages())
<div class="mt-4">
{{ $requests->links() }}
</div>
@endif
</div>
</div>
@endsection
@push('styles')
<style>
.avatar-circle{width:35px;height:35px;background:linear-gradient(135deg,#b70003 0%,#8b0002 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;font-size:0.75rem}
</style>
@endpush
@push('scripts')
<script>
async function approveRequest(id){const{value:notes}=await Swal.fire({title:'Approve Delete Request',input:'textarea',inputLabel:'Admin Notes (Optional)',inputPlaceholder:'Add any notes about this approval...',showCancelButton:true,confirmButtonColor:'#28a745',cancelButtonColor:'#6c757d',confirmButtonText:'Approve',cancelButtonText:'Cancel'});if(notes!==undefined){try{const response=await axios.post(`/dashboard/delete-requests/${id}/approve`,{admin_notes:notes});if(response.data.success){Toast.fire({icon:'success',title:response.data.message});setTimeout(()=>{location.reload()},1000)}}catch(error){Swal.fire({icon:'error',title:'Error',text:error.response?.data?.message||'Failed to approve request.',confirmButtonColor:'#b70003'})}}}
async function rejectRequest(id){const{value:notes}=await Swal.fire({title:'Reject Delete Request',input:'textarea',inputLabel:'Reason for Rejection (Required)',inputPlaceholder:'Explain why this request is being rejected...',inputValidator:(value)=>{if(!value){return'You need to provide a reason!'}},showCancelButton:true,confirmButtonColor:'#dc3545',cancelButtonColor:'#6c757d',confirmButtonText:'Reject',cancelButtonText:'Cancel'});if(notes){try{const response=await axios.post(`/dashboard/delete-requests/${id}/reject`,{admin_notes:notes});if(response.data.success){Toast.fire({icon:'success',title:response.data.message});setTimeout(()=>{location.reload()},1000)}}catch(error){Swal.fire({icon:'error',title:'Error',text:error.response?.data?.message||'Failed to reject request.',confirmButtonColor:'#b70003'})}}}
document.addEventListener('DOMContentLoaded',function(){const tooltipTriggerList=[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));tooltipTriggerList.map(function(tooltipTriggerEl){return new bootstrap.Tooltip(tooltipTriggerEl)})});
</script>
@endpush
