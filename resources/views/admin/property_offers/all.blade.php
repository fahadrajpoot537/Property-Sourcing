@extends('layouts.admin')

@section('title', 'All Property Offers')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">All Received Offers</h1>
                <p class="text-muted">Overview of all offers across all properties.</p>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Global Offers List</h6>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Property</th>
                                <th>User</th>
                                <th>Amount (£)</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th style="min-width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offers as $offer)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary">{{ $offer->property->headline }}</div>
                                        <small class="text-muted">{{ $offer->property->location }}</small>
                                    </td>
                                    <td>
                                        {{ $offer->user->name }} <br>
                                        <small class="text-muted">{{ $offer->user->email }}</small>
                                    </td>
                                    <td class="fw-bold text-pink">£{{ number_format($offer->offer_amount, 2) }}</td>
                                    <td>
                                        @if($offer->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($offer->status == 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($offer->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @elseif($offer->status == 'completed')
                                            <span class="badge bg-info">Completed (Sold)</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $offer->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $offer->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if($offer->status == 'pending')
                                                <form action="{{ route('admin.property-offers.update', $offer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        onclick="return confirm('Accept this offer?')">Accept</button>
                                                </form>
                                                <form action="{{ route('admin.property-offers.update', $offer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Reject this offer?')">Reject</button>
                                                </form>
                                            @elseif($offer->status == 'accepted')
                                                <form action="{{ route('admin.property-offers.complete', $offer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-sm text-white"
                                                        onclick="return confirm('Mark as Completed (Sold)?')">
                                                        Complete
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('available-properties.show', $offer->property->id) }}"
                                                class="btn btn-secondary btn-sm" title="View Property">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No offers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection