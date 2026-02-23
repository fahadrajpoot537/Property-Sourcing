@extends('layouts.admin')

@section('title', 'Investor Profile')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Investor: {{ $investor->name }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.investors.index') }}">Investors</a></li>
                        <li class="breadcrumb-item active">View Profile</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.investors.edit', $investor->id) }}" class="btn btn-admin-blue">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                </a>
                <a href="{{ route('admin.investors.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="content-card mb-4 text-center p-4">
                <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                    {{ substr($investor->name, 0, 1) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $investor->name }}</h4>
                <p class="text-muted small mb-3">Added on {{ $investor->created_at->format('d M Y') }}</p>
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $investor->email }}" class="btn btn-outline-blue btn-sm">
                        <i class="bi bi-envelope me-2"></i>Email Investor
                    </a>
                    <a href="tel:{{ $investor->phone }}" class="btn btn-outline-blue btn-sm">
                        <i class="bi bi-phone me-2"></i>Call Now
                    </a>
                </div>
            </div>

            <div class="content-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-pink"></i>Basic Information</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <small class="text-muted d-block">Email</small>
                        <span class="fw-600">{{ $investor->email ?? 'N/A' }}</span>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block">Phone</small>
                        <span class="fw-600">{{ $investor->phone ?? 'N/A' }}</span>
                    </li>
                    @if(auth()->user()->role === 'admin')
                        <li>
                            <small class="text-muted d-block">Managed By</small>
                            <span class="fw-600 text-pink">{{ $investor->agent->name ?? 'System' }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="content-card p-4 mb-4">
                <h6 class="fw-bold mb-4 border-bottom pb-2">Property Interests</h6>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @forelse(explode(', ', $investor->property_interests) as $interest)
                        @if(!empty($interest))
                            <span class="badge bg-blue px-3 py-2 fs-6 rounded-pill"><i
                                    class="bi bi-tag-fill me-2"></i>{{ $interest }}</span>
                        @endif
                    @empty
                        <p class="text-muted mb-0">No specific property interests recorded.</p>
                    @endforelse
                </div>

                <h6 class="fw-bold mb-3 border-bottom pb-2">Internal Notes</h6>
                <div class="bg-light p-3 rounded min-vh-20">
                    {!! nl2br(e($investor->notes ?? 'No additional notes provided.')) !!}
                </div>
            </div>
        </div>
    </div>
@endsection