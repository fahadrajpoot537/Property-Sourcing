@extends('layouts.admin')

@section('title', 'Manage Properties')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Welcome, {{ auth()->user()->name }} to your {{ ucfirst(auth()->user()->role) }}
                    Dashboard!</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Overview</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.available-properties.create') }}" class="btn btn-admin-pink">
                    <i class="bi bi-plus-lg me-2"></i>Add Available Property
                </a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.create') }}" class="btn btn-admin-primary">
                        <i class="bi bi-check-circle me-2"></i>Add Sold Property
                    </a>
                @endif
            </div>

        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card blue shadow-sm border-0">
                <div class="icon">
                    <i class="bi bi-building"></i>
                </div>
                @if(auth()->user()->role === 'admin')
                    <h3>{{ $stats['total_sold'] }}</h3>
                    <p>Sold Portfolio</p>
                @else
                    <h3>{{ $stats['total_available'] }}</h3>
                    <p>My Available Properties</p>
                @endif
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card pink shadow-sm border-0">
                <div class="icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3>{{ number_format($stats['avg_bmv'], 1) }}%</h3>
                <p>Average BMV</p>
            </div>
        </div>
        @if(auth()->user()->role === 'admin')
            <div class="col-xl-3 col-md-6">
                <div class="stats-card success shadow-sm border-0">
                    <div class="icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h3>{{ \App\Models\News::count() }}</h3>
                    <p>Blog Posts</p>
                </div>
            </div>
        @endif
        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning shadow-sm border-0">
                <div class="icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>{{ $stats['dynamic_count'] }}</h3>
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

    <!-- Quick Actions & Recent Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="content-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-blue">
                        <i class="bi bi-clock-history me-2"></i>
                        @if(auth()->user()->role === 'admin')
                            Recently Added Sold Properties
                        @else
                            My Recent Available Properties
                        @endif
                    </h5>
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.portfolio') : route('admin.available-properties.index') }}"
                        class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table admin-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Listing</th>
                                    <th>{{ auth()->user()->role === 'admin' ? 'BMV' : 'Price' }}</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_properties'] as $property)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $img = null;
                                                    if ($property instanceof \App\Models\AvailableProperty) {
                                                        $img = $property->thumbnail;
                                                    } else {
                                                        $img = $property->image_url;
                                                    }
                                                @endphp
                                                <img src="{{ $img ? (Str::startsWith($img, 'http') ? $img : asset('storage/' . $img)) : 'https://via.placeholder.com/60' }}"
                                                    alt="Property" class="rounded me-3"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                <div class="fw-bold text-dark small">
                                                    {{ $property instanceof \App\Models\AvailableProperty ? $property->headline : $property->location }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($property instanceof \App\Models\AvailableProperty)
                                                <span
                                                    class="text-pink fw-bold small">£{{ number_format($property->portal_sale_price ?? $property->price) }}</span>
                                            @else
                                                <span class="text-success fw-bold small">{{ $property->bmv_percentage }}%</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            @if($property instanceof \App\Models\AvailableProperty)
                                                <a href="{{ route('admin.available-properties.edit', $property->id) }}"
                                                    class="text-primary"><i class="bi bi-pencil"></i></a>
                                            @else
                                                <a href="{{ route('admin.edit', $property->id) }}" class="text-primary"><i
                                                        class="bi bi-pencil"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted small">No recent properties</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="content-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-lightning-fill text-warning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.available-properties.create') }}"
                            class="btn btn-light border text-start p-3 hover-lift">
                            <i class="bi bi-plus-circle-dotted text-pink me-2"></i> Add Available Property
                        </a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.create') }}" class="btn btn-light border text-start p-3 hover-lift">
                                <i class="bi bi-check-circle text-blue me-2"></i> Add Sold Property
                            </a>
                            <a href="{{ route('admin.news.create') }}" class="btn btn-light border text-start p-3 hover-lift">
                                <i class="bi bi-newspaper text-success me-2"></i> Create Blog Post
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection