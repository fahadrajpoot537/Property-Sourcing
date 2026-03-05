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
            <div class="d-flex gap-2">
                <a href="{{ route('admin.investors.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('admin.investors.store') }}" method="POST">
                @csrf

                <!-- Basic Information -->
                <div class="content-card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-person-circle me-2"></i>Personal Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required
                                    placeholder="e.g. John Doe">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    placeholder="john@example.com">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                    placeholder="+44 123 456 7890">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Location</label>
                                <input type="text" name="location" id="location" class="form-control"
                                    value="{{ old('location') }}"
                                    placeholder="Start typing the investor's location/address..." required>
                                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
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
                                            <input type="number" name="min_budget" class="form-control"
                                                value="{{ old('min_budget') }}" placeholder="Min Budget">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text">£</span>
                                            <input type="number" name="max_budget" class="form-control"
                                                value="{{ old('max_budget') }}" placeholder="Max Budget">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_cash_buy" id="is_cash_buy"
                                        value="1" {{ old('is_cash_buy') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold ms-2" for="is_cash_buy">Verified Cash
                                        Buyer</label>
                                </div>
                            </div>

                            <!-- Deals of Interest -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold d-block mb-3">Investment Strategies (Select All That
                                    Apply)</label>
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
                                    @endphp
                                    @foreach($strategies as $key => $label)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check custom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="deals_of_interest[]"
                                                    value="{{ $key }}" id="deal_{{ $key }}">
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
                                        @endphp
                                        @foreach($pTypes as $pt)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="property_types[]"
                                                        value="{{ $pt }}" id="pt_{{ Str::slug($pt) }}">
                                                    <label class="form-check-label"
                                                        for="pt_{{ Str::slug($pt) }}">{{ $pt }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="bg-light p-3 rounded">
                                    <h6 class="small fw-bold text-uppercase text-muted mb-3">Commercial</h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="small text-muted">Commercial properties matching Rightmove standard
                                                classifications.</p>
                                            <!-- Add commercial types if needed -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="property_types[]"
                                                    value="Commercial" id="pt_commercial">
                                                <label class="form-check-label" for="pt_commercial">General
                                                    Commercial</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bed/Bath -->
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Min Bedrooms</label>
                                        <input type="number" name="min_bedrooms" class="form-control" placeholder="Any"
                                            value="{{ old('min_bedrooms') }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Max Bedrooms</label>
                                        <input type="number" name="max_bedrooms" class="form-control" placeholder="Any"
                                            value="{{ old('max_bedrooms') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Min Bathrooms</label>
                                        <input type="number" name="min_bathrooms" class="form-control" placeholder="Any"
                                            value="{{ old('min_bathrooms') }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Max Bathrooms</label>
                                        <input type="number" name="max_bathrooms" class="form-control" placeholder="Any"
                                            value="{{ old('max_bathrooms') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Areas of Interest -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Areas of Interest (UK Regions / Cities)</label>
                                <select name="areas_of_interest[]" class="form-select" multiple size="5">
                                    <option value="All">All Locations (UK Wide)</option>
                                    <option value="London">London</option>
                                    <option value="South East">South East</option>
                                    <option value="South West">South West</option>
                                    <option value="East Midlands">East Midlands</option>
                                    <option value="West Midlands">West Midlands</option>
                                    <option value="North West">North West</option>
                                    <option value="North East">North East</option>
                                    <option value="Yorkshire">Yorkshire</option>
                                    <option value="Scotland">Scotland</option>
                                    <option value="Wales">Wales</option>
                                </select>
                                <small class="text-muted">Hold Ctrl (Cmd) to select multiple</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-card mb-4 shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        <button type="submit" class="btn btn-admin-pink btn-lg px-5 py-3">
                            <i class="bi bi-person-check-fill me-2"></i>Create Global Investor Profile
                        </button>
                        <div class="mt-3">
                            <p class="text-muted small mb-0">The system will automatically attempt to match this investor
                                with existing and future listings.</p>
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
    </style>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var locationInput = document.getElementById("location");
            var autocomplete = new google.maps.places.Autocomplete(locationInput, {
                types: ['geocode'],
                componentRestrictions: { country: "gb" } // Restrict to UK
            });

            autocomplete.addListener("place_changed", function () {
                var place = autocomplete.getPlace();
                if (place.geometry) {
                    document.getElementById("latitude").value = place.geometry.location.lat();
                    document.getElementById("longitude").value = place.geometry.location.lng();
                }
            });

            locationInput.addEventListener("keydown", function (e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection