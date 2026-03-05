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
    <div class="col-lg-12">
        <form action="{{ route('admin.investors.update', $investor->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="content-card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-person-circle me-2"></i>Personal Details</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $investor->name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $investor->email) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $investor->phone) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $investor->address) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investment Requirements -->
            <div class="content-card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-sliders me-2"></i>Investment Criteria</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Budget Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text">£</span>
                                        <input type="number" name="min_budget" class="form-control" value="{{ old('min_budget', $investor->min_budget) }}" placeholder="Min Budget">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text">£</span>
                                        <input type="number" name="max_budget" class="form-control" value="{{ old('max_budget', $investor->max_budget) }}" placeholder="Max Budget">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_cash_buy" id="is_cash_buy" value="1" {{ old('is_cash_buy', $investor->is_cash_buy) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold ms-2" for="is_cash_buy">Verified Cash Buyer</label>
                            </div>
                        </div>

                        <!-- Deals of Interest -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold d-block mb-3">Investment Strategies (Select All That Apply)</label>
                            <div class="row">
                                @php
                                    $strategies = [
                                        'BMV' => 'Below Market Value',
                                        'Refurbishment' => 'Refurbishment project',
                                        'Rental' => 'Rental Yield',
                                        'HMO' => 'HMO',
                                        'Development' => 'Development opportunity',
                                        'Other' => 'Other',
                                        'All' => 'All (Show me everything)'
                                    ];
                                    $selectedDeals = is_array($investor->deals_of_interest) ? $investor->deals_of_interest : [];
                                @endphp
                                @foreach($strategies as $key => $label)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="deals_of_interest[]" value="{{ $key }}" id="deal_{{ $key }}" 
                                            {{ in_array($key, $selectedDeals) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="deal_{{ $key }}">{{ $label }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Property Types -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold d-block mb-2">Property Types of Interest</label>
                            <div class="bg-light p-3 rounded mb-3">
                                <h6 class="small fw-bold text-uppercase text-muted mb-3">Residential</h6>
                                <div class="row">
                                    @php
                                        $pTypes = ['House', 'Flat/Apartment', 'Bungalows', 'Land', 'Detached', 'Semi detached', 'Terraced', 'Any'];
                                        $selectedTypes = is_array($investor->property_types) ? $investor->property_types : [];
                                    @endphp
                                    @foreach($pTypes as $pt)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="property_types[]" value="{{ $pt }}" id="pt_{{ Str::slug($pt) }}"
                                                {{ in_array($pt, $selectedTypes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pt_{{ Str::slug($pt) }}">{{ $pt }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Bed/Bath -->
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label fw-bold">Min Bedrooms</label>
                                    <input type="number" name="min_bedrooms" class="form-control" value="{{ old('min_bedrooms', $investor->min_bedrooms) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold">Max Bedrooms</label>
                                    <input type="number" name="max_bedrooms" class="form-control" value="{{ old('max_bedrooms', $investor->max_bedrooms) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label fw-bold">Min Bathrooms</label>
                                    <input type="number" name="min_bathrooms" class="form-control" value="{{ old('min_bathrooms', $investor->min_bathrooms) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold">Max Bathrooms</label>
                                    <input type="number" name="max_bathrooms" class="form-control" value="{{ old('max_bathrooms', $investor->max_bathrooms) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Areas of Interest -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Areas of Interest (UK Regions / Cities)</label>
                            @php
                                $selectedAreas = is_array($investor->areas_of_interest) ? $investor->areas_of_interest : [];
                                $allAreas = ['London', 'South East', 'South West', 'East Midlands', 'West Midlands', 'North West', 'North East', 'Yorkshire', 'Scotland', 'Wales'];
                            @endphp
                            <select name="areas_of_interest[]" class="form-select" multiple size="5">
                                <option value="All" {{ in_array('All', $selectedAreas) ? 'selected' : '' }}>All Locations (UK Wide)</option>
                                @foreach($allAreas as $area)
                                    <option value="{{ $area }}" {{ in_array($area, $selectedAreas) ? 'selected' : '' }}>{{ $area }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl (Cmd) to select multiple</small>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Legacy Location (for mapping)</label>
                            <input type="text" id="investor_location" name="location" class="form-control" value="{{ old('location', $investor->location) }}">
                            <input type="hidden" id="latitude" name="latitude" value="{{ $investor->latitude }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ $investor->longitude }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Additional Notes</label>
                            <textarea name="notes" class="form-control" rows="4">{{ old('notes', $investor->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card mb-4 shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <button type="submit" class="btn btn-admin-pink btn-lg px-5 py-3">
                        <i class="bi bi-check-circle-fill me-2"></i>Save Changes
                    </button>
                    <div class="mt-3">
                        <p class="text-muted small mb-0">Updating profile will trigger a re-match check for existing listings.</p>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<style>
    .custom-checkbox .form-check-input:checked {
        background-color: var(--primary-pink);
        border-color: var(--primary-pink);
    }
    .form-switch .form-check-input:checked {
        background-color: var(--primary-pink);
        border-color: var(--primary-pink);
    }
</style>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places"></script>
<script>
    function initAutocomplete() {
        const input = document.getElementById('investor_location');
        if (!input) return;
        const autocomplete = new google.maps.places.Autocomplete(input, { componentRestrictions: { country: "gb" } });
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (place.geometry) {
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            }
        });
    }
    document.addEventListener('DOMContentLoaded', initAutocomplete);
</script>
@endpush
