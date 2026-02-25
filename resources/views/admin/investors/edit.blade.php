@extends('layouts.admin')

@section('title', 'Edit Investor')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Edit Investor: {{ $investor->name }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.investors.index') }}">Investors</a></li>
                        <li class="breadcrumb-item active">Edit Investor</li>
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
                    <h5><i class="bi bi-pencil-square me-2"></i>Update Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.investors.update', $investor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-600">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $investor->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $investor->email) }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $investor->phone) }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600">What's your budget?</label>
                                <input type="text" name="budget" class="form-control @error('budget') is-invalid @enderror"
                                    value="{{ old('budget', $investor->budget) }}" placeholder="e.g. £100,000 - £200,000">
                                @error('budget') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600">Investment Interest (Type of Deals)</label>
                                <input type="text" name="investment_interest" class="form-control @error('investment_interest') is-invalid @enderror"
                                    value="{{ old('investment_interest', $investor->investment_interest) }}" placeholder="e.g. BMV Deal, HMO, BTL">
                                @error('investment_interest') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="form-label fw-600">Investor Location Interest <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" id="investor_location" name="location" class="form-control @error('location') is-invalid @enderror"
                                        value="{{ old('location', $investor->location) }}" placeholder="Enter preferred city, area or postcode" required>
                                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $investor->latitude) }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $investor->longitude) }}">
                                </div>
                                <small class="text-muted mt-1 d-block">This location will be used to auto-match new property deals.</small>
                                @error('location') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                                <input class="form-check-input" type="checkbox" name="property_interests[]" value="{{ $interest }}" id="interest_{{ Str::slug($interest) }}"
                                                    {{ in_array($interest, $selectedInterests) ? 'checked' : '' }}>
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
                                <textarea name="notes" class="form-control" rows="4">{{ old('notes', $investor->notes) }}</textarea>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-admin-pink px-5">
                                    <i class="bi bi-check2-circle me-2"></i>Update Investor
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places"></script>
    <script>
        function initAutocomplete() {
            const input = document.getElementById('investor_location');
            if (!input) return;

            const options = {
                componentRestrictions: { country: "gb" },
                fields: ["geometry", "name", "formatted_address"],
            };
            const autocomplete = new google.maps.places.Autocomplete(input, options);

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) return;
                
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            });
        }
        document.addEventListener('DOMContentLoaded', initAutocomplete);
    </script>
@endpush
