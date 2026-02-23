@extends('layouts.admin')

@section('title', 'Manage Investors')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Manage Investors</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Investors</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.investors.create') }}" class="btn btn-admin-pink">
                <i class="bi bi-person-plus me-2"></i>Add New Investor
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card blue">
                <div class="icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>{{ $investors->total() }}</h3>
                <p>Total Investors</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Investors Table -->
    <div class="content-card">
        <div class="card-header">
            <h5><i class="bi bi-person-lines-fill me-2"></i>Investor List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Investor Name</th>
                            <th>Contact Info</th>
                            <th>Interests</th>
                            @if(auth()->user()->role === 'admin')
                                <th>Added By</th>
                            @endif
                            <th style="width: 150px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($investors as $investor)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $investor->name }}</div>
                                    <small class="text-muted">ID: #{{ $investor->id }}</small>
                                </td>
                                <td>
                                    <div><i class="bi bi-envelope me-1"></i>{{ $investor->email ?? 'N/A' }}</div>
                                    <div><i class="bi bi-phone me-1"></i>{{ $investor->phone ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    @if($investor->property_interests)
                                        @foreach(explode(', ', $investor->property_interests) as $interest)
                                            <span class="badge bg-light text-blue border mb-1">{{ $interest }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">No interests set</span>
                                    @endif
                                </td>
                                @if(auth()->user()->role === 'admin')
                                    <td>
                                        <div class="fw-600 text-blue">{{ $investor->agent->name ?? 'N/A' }}</div>
                                        <small class="text-muted text-uppercase"
                                            style="font-size: 10px;">{{ $investor->agent->role ?? '' }}</small>
                                    </td>
                                @endif
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.investors.show', $investor->id) }}"
                                            class="btn btn-sm btn-admin-edit" title="View Profile">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.investors.edit', $investor->id) }}"
                                            class="btn btn-sm btn-admin-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.investors.destroy', $investor->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to remove this investor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-admin-delete" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-person-slash fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted mb-3">No investors found in your list.</p>
                                    <a href="{{ route('admin.investors.create') }}" class="btn btn-admin-pink">
                                        <i class="bi bi-plus-lg me-2"></i>Add First Investor
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($investors->hasPages())
        <div class="mt-4">
            {{ $investors->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endsection