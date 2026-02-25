@extends('layouts.admin')

@section('title', 'Manage Properties')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Recent Properties</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Recent Properties</li>
                    </ol>
                </nav>
            </div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.create') }}" class="btn btn-admin-pink">
                    <i class="bi bi-plus-lg me-2"></i>Add New Property
                </a>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card blue">
                <div class="icon">
                    <i class="bi bi-building"></i>
                </div>
                <h3>{{ $properties->total() }}</h3>
                <p>Total Properties</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card pink">
                <div class="icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3>{{ number_format($properties->avg('bmv_percentage'), 1) }}%</h3>
                <p>Average BMV</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card success">
                <div class="icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h3>{{ $properties->where('type', '!=', null)->count() }}</h3>
                <p>With Investment Type</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning">
                <div class="icon">
                    <i class="bi bi-eye"></i>
                </div>
                <h3>Active</h3>
                <p>Status</p>
            </div>
        </div>

        @if(auth()->user()->role !== 'admin')
            <div class="col-xl-3 col-md-6">
                <div class="stats-card warning position-relative">
                    <div class="icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h3>{{ auth()->user()->investment_credits ?? 0 }}</h3>
                    <p>Investment Credits</p>
                    <a href="{{ route('user.credits.index') }}" class="stretched-link"></a>
                </div>
            </div>
        @endif
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Properties Table -->
    <div class="content-card">
        <div class="card-header">
            <h5><i class="bi bi-list-ul me-2"></i>Recent Properties</h5>

        </div>
        <div class="card-body">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th style="width: 100px;">BMV %</th>
                        <th style="width: 100px;">Yield</th>
                        <th style="width: 150px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>
                                <img src="{{ $property->image_url ? (Str::startsWith($property->image_url, 'http') ? $property->image_url : asset('storage/' . $property->image_url)) : 'https://via.placeholder.com/60' }}"
                                    alt="Property" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $property->location }}</div>
                                <small
                                    class="text-muted">{{ $property->description ? Str::limit($property->description, 30) : 'N/A' }}</small>
                            </td>
                            <td>
                                @if($property->type)
                                    <span class="badge badge-admin bg-primary">{{ $property->type }}</span>
                                @else
                                    <span class="text-muted small">Not set</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-secondary small" style="max-width: 250px;">
                                    {{ Str::limit($property->description, 60) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-admin bg-success">{{ $property->bmv_percentage }}%</span>
                            </td>
                            <td>
                                <span class="text-dark fw-600">{{ $property->yield ?? 'N/A' }}</span>
                            </td>
                            <td class="text-end">
                                @if(auth()->user()->role === 'admin')
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.edit', $property->id) }}" class="btn btn-sm btn-admin-edit"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.destroy', $property->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this property?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-admin-delete" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">View Only</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-3">No properties found.</p>
                                <a href="{{ route('admin.create') }}" class="btn btn-admin-pink">
                                    <i class="bi bi-plus-lg me-2"></i>Add Your First Property
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="mt-4">
            {{ $properties->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endsection