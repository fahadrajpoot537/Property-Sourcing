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
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i>Import Investors
                </button>
                <a href="{{ route('admin.investors.create') }}" class="btn btn-admin-pink">
                    <i class="bi bi-person-plus me-2"></i>Add New Investor
                </a>
            </div>
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
                            <th>Budget</th>
                            <th>Investment Preferences</th>
                            <th>Locations</th>
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
                                    @if($investor->is_cash_buy)
                                        <span class="badge bg-success-soft text-success small"><i class="bi bi-patch-check-fill me-1"></i>Cash Buyer</span>
                                    @endif
                                </td>
                                <td>
                                    <div><i class="bi bi-envelope me-1"></i>{{ $investor->email ?? 'N/A' }}</div>
                                    <div><i class="bi bi-phone me-1"></i>{{ $investor->phone ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    @if($investor->min_budget || $investor->max_budget)
                                        <div class="fw-bold text-pink">£{{ number_format($investor->min_budget/1000, 0) }}k - £{{ number_format($investor->max_budget/1000, 0) }}k</div>
                                    @elseif($investor->budget)
                                        <div class="fw-bold text-pink">Up to £{{ number_format((float) preg_replace('/[^0-9.]/', '', $investor->budget)/1000, 0) }}k</div>
                                    @else
                                        <span class="text-muted small">Not specified</span>
                                    @endif
                                </td>
                                <td>
                                    @if($investor->deals_of_interest)
                                        @foreach($investor->deals_of_interest as $deal)
                                            <span class="badge bg-light text-primary border mb-1">{{ $deal }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">None set</span>
                                    @endif
                                </td>
                                <td>
                                    @if($investor->areas_of_interest)
                                        @foreach($investor->areas_of_interest as $area)
                                            <span class="badge bg-light text-danger border mb-1"><i class="bi bi-geo-alt me-1"></i>{{ $area }}</span>
                                        @endforeach
                                    @else
                                        <div class="small fw-600 text-muted">{{ $investor->location ?? 'N/A' }}</div>
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
@section('scripts')
    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content text-start">
                <form action="{{ route('admin.investors.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Import Investors</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="bg-light p-3 rounded mb-3">
                            <h6 class="fw-bold small mb-2"><i class="bi bi-info-circle me-1"></i>Formatting Instructions</h6>
                            <p class="small text-muted mb-2">Upload a CSV file with these headers: <code>name, email, phone, address, budget, is_cash_buy, notes</code></p>
                            <a href="{{ route('admin.investors.template') }}" class="btn btn-sm btn-link p-0 text-decoration-none fw-bold">
                                <i class="bi bi-download me-1"></i>Download Blank Template
                            </a>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Choose CSV File</label>
                            <input type="file" name="file" class="form-control" accept=".csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Start Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection