@extends('layouts.admin')

@section('title', 'Sold Properties Portfolio')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Sold Properties Portfolio</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Portfolio</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.create') }}" class="btn btn-admin-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Sold Property
            </a>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="content-card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-building me-2"></i>Managed Properties</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table admin-table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Listing</th>
                            <th>BMV Percentage</th>
                            <th>Created At</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $property)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $property->image_url ? (Str::startsWith($property->image_url, 'http') ? $property->image_url : asset('storage/' . $property->image_url)) : 'https://via.placeholder.com/60' }}"
                                            alt="Property" class="rounded shadow-sm me-3"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $property->location }}</div>
                                            <div class="text-muted small">
                                                {{ Str::limit(strip_tags($property->description), 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success-soft text-success rounded-pill px-3 fw-bold">
                                        {{ $property->bmv_percentage }}%
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $property->created_at->format('M d, Y') }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded">
                                        <a href="{{ route('admin.edit', $property->id) }}" class="btn btn-white btn-sm"
                                            title="Edit">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </a>
                                        <form action="{{ route('admin.destroy', $property->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this property?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm" title="Delete">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-building fs-1 d-block mb-3 opacity-25"></i>
                                        No properties found in portfolio.
                                    </div>
                                    <a href="{{ route('admin.create') }}" class="btn btn-admin-pink mt-3">
                                        <i class="bi bi-plus-lg me-2"></i>Add First Property
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
    @if($properties->hasPages())
        <div class="mt-4">
            {{ $properties->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endsection