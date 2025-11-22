@extends('dashboard.layouts.app')

@section('title', 'Admin Management')
@section('page-title', 'Admin Management')

@section('content')
    <!-- Page Header -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Manage Administrators</h5>
                    <p class="text-muted mb-0">View and manage admin accounts</p>
                </div>
                <a href="{{ route('dashboard.admins.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Admin</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Stories</th>
                            <th>Joined</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            {{ strtoupper(substr($admin->first_name, 0, 1)) }}{{ strtoupper(substr($admin->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong class="d-block">{{ $admin->first_name }} {{ $admin->last_name }}</strong>
                                            @if($admin->id === auth()->id())
                                                <span class="badge bg-primary">You</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('dashboard.admins.show', $admin->id) }}" class="badge bg-primary text-decoration-none">
                                        {{ $admin->stories_count }} {{ Str::plural('story', $admin->stories_count) }}
                                    </a>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $admin->created_at->format('M d, Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dashboard.admins.show', $admin->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip"
                                           title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.admins.edit', $admin->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        @if($admin->id !== auth()->id())
                                            <button onclick="deleteAdmin({{ $admin->id }})"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people display-4 d-block mb-3"></i>
                                    <p class="mb-0">No admins found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($admins->hasPages())
                <div class="mt-4">
                    {{ $admins->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #b70003 0%, #8b0002 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Delete Admin
    async function deleteAdmin(id) {
        const result = await Swal.fire({
            title: 'Delete Admin?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            try {
                const response = await axios.delete();

                if (response.data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } catch (error) {
                let errorMessage = 'Failed to delete admin.';
                if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonColor: '#b70003'
                });
            }
        }
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
