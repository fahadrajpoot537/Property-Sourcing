@extends('layouts.admin')

@section('title', 'Inquiry Details')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Inquiry Details</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inquiries.index') }}">Inquiries</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-admin-edit">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Details -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header">
                    <h5><i class="bi bi-person-circle me-2"></i>Contact Information</h5>
                    <div class="d-flex gap-2">
                        @if($inquiry->type === 'general')
                            <span class="badge badge-admin bg-primary">General Inquiry</span>
                        @elseif($inquiry->type === 'investor')
                            <span class="badge badge-admin bg-success">Investor Inquiry</span>
                        @elseif($inquiry->type === 'event')
                            <span class="badge badge-admin bg-warning">Event Registration</span>
                        @endif

                        @if(!$inquiry->is_read)
                            <span class="badge badge-admin bg-danger">Unread</span>
                        @else
                            <span class="badge badge-admin bg-secondary">Read</span>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Full Name</label>
                                <div class="fw-bold text-dark fs-5">{{ $inquiry->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Email Address</label>
                                <div class="fw-bold">
                                    <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">
                                        <i class="bi bi-envelope me-2"></i>{{ $inquiry->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Phone Number</label>
                                <div class="fw-bold">
                                    <a href="tel:{{ $inquiry->phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-2"></i>{{ $inquiry->phone }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Inquiry Type</label>
                                <div class="fw-bold text-capitalize">{{ $inquiry->type }}</div>
                            </div>
                        </div>

                        @if($inquiry->ready_to_buy)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Ready to Buy</label>
                                    <div class="fw-bold">{{ $inquiry->ready_to_buy }}</div>
                                </div>
                            </div>
                        @endif

                        @if($inquiry->investment_type)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Investment Interests</label>
                                    <div class="fw-bold">{{ $inquiry->investment_type }}</div>
                                </div>
                            </div>
                        @endif

                        @if($inquiry->is_cash_buyer)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Cash Buyer</label>
                                    <div class="fw-bold">{{ $inquiry->is_cash_buyer }}</div>
                                </div>
                            </div>
                        @endif

                        @if($inquiry->budget)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Budget</label>
                                    <div class="fw-bold">{{ $inquiry->budget }}</div>
                                </div>
                            </div>
                        @endif

                        @if($inquiry->experience_level)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Experience Level</label>
                                    <div class="fw-bold text-capitalize">{{ $inquiry->experience_level }}</div>
                                </div>
                            </div>
                        @endif

                        @if($inquiry->comments)
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Additional Comments</label>
                                    <div class="p-3 bg-light rounded">{{ $inquiry->comments }}</div>
                                </div>
                            </div>
                        @endif

                        @if($inquiry->source_page)
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Source Page</label>
                                    <div class="text-muted">{{ $inquiry->source_page }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Actions -->
            <div class="content-card mb-4">
                <div class="card-header">
                    <h5><i class="bi bi-gear me-2"></i>Actions</h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        @if(!$inquiry->is_read)
                            <form action="{{ route('admin.inquiries.mark-read', $inquiry->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-admin-primary w-100">
                                    <i class="bi bi-check2 me-2"></i>Mark as Read
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.inquiries.mark-unread', $inquiry->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-admin-edit w-100">
                                    <i class="bi bi-envelope me-2"></i>Mark as Unread
                                </button>
                            </form>
                        @endif

                        <a href="mailto:{{ $inquiry->email }}" class="btn btn-admin-pink w-100">
                            <i class="bi bi-reply me-2"></i>Reply via Email
                        </a>

                        <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-admin-delete w-100">
                                <i class="bi bi-trash me-2"></i>Delete Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="content-card">
                <div class="card-header">
                    <h5><i class="bi bi-info-circle me-2"></i>Meta Information</h5>
                </div>
                <div class="card-body p-3">
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Received On</label>
                        <div class="fw-bold">{{ $inquiry->created_at->format('F d, Y') }}</div>
                        <div class="text-muted small">{{ $inquiry->created_at->format('h:i A') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Time Ago</label>
                        <div class="text-muted">{{ $inquiry->created_at->diffForHumans() }}</div>
                    </div>
                    @if($inquiry->is_read)
                        <div class="mb-0">
                            <label class="text-muted small mb-1">Status</label>
                            <div><span class="badge bg-success">Read</span></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection