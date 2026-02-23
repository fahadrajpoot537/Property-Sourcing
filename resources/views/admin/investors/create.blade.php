@extends('layouts.admin')

@section('title', 'Add Investor')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Add New Investor</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.investors.index') }}">Investors</a></li>
                        <li class="breadcrumb-item active">Add Investor</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.investors.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header">
                    <h5><i class="bi bi-person-plus-fill me-2"></i>Investor Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.investors.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-600">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required placeholder="e.g. John Doe">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="e.g. john@example.com">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="e.g. +44 123 456 7890">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mt-4">
                                <label class="form-label fw-600 d-block">Property Types of Interest</label>
                                <div class="row">
                                    @php
                                        $interests = ['BMV', 'HMO', 'Development Land', 'Buy to Let', 'Commercial', 'Distressed Properties', 'Rent to Rent', 'SA (Serviced Accommodation)', 'Auction Properties'];
                                    @endphp
                                    @foreach($interests as $interest)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="property_interests[]"
                                                    value="{{ $interest }}" id="interest_{{ Str::slug($interest) }}">
                                                <label class="form-check-label" for="interest_{{ Str::slug($interest) }}">
                                                    {{ $interest }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="form-label fw-600">Additional Notes</label>
                                <textarea name="notes" class="form-control" rows="4"
                                    placeholder="Any specific requirements or background info..."></textarea>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-admin-pink px-5">
                                    <i class="bi bi-check2-circle me-2"></i>Save Investor
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="content-card mb-4">
                <div class="card-header bg-blue text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Quick Guide</h6>
                </div>
                <div class="card-body p-4">
                    <p class="small text-muted mb-0">Use this form to build your personal investor database. Only you (and
                        administrators) will have access to these contacts.</p>
                    <hr>
                    <ul class="small text-muted ps-3">
                        <li class="mb-2">Ensure phone numbers include country codes.</li>
                        <li class="mb-2">Select multiple interests to filter matching properties later.</li>
                        <li class="mb-2">Accurate emails help in sending automated matching alerts.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection