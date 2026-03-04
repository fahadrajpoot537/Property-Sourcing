@extends('layouts.admin')

@section('title', 'Team Members')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Meet The Team</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Team Members</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.team.create') }}" class="btn btn-admin-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Team Member
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Team Table -->
    <div class="content-card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>All Team Members</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Member</th>
                            <th>Name & Title</th>
                            <th>Category</th>
                            <th>Sort Order</th>
                            <th style="width: 150px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>
                                    @if($member->image_url)
                                        <img src="{{ asset('storage/' . $member->image_url) }}" class="rounded shadow-sm"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="bi bi-person text-muted fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $member->name }}</div>
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem;">{{ $member->role }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary px-3">{{ $member->category }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary fw-bold">#{{ $member->sort_order }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.team.edit', $member->id) }}" class="btn btn-sm btn-admin-edit"
                                            title="Edit Profile">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to permanently remove this team member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-admin-delete" title="Remove Member">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                                        <p class="text-muted mb-0">No team members have been added yet.</p>
                                        <a href="{{ route('admin.team.create') }}" class="btn btn-link text-admin-primary mt-2">Add your first member</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection