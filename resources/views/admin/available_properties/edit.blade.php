@extends('layouts.admin')

@section('title', 'Edit Available Property')

@push('css')
    <style>
        .ck-editor__editable {
            min-height: 300px;
        }

        .form-label {
            color: #333;
            font-size: 0.9rem;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .05);
        }

        .text-blue {
            color: #0d6efd;
        }

        .upload-container {
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-container:hover {
            background-color: #f1f1f1 !important;
            border-color: #0d6efd !important;
        }

        .custom-checkbox .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e3e6f0;
        }

        .preview-item img, .preview-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Edit Available Property</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.available-properties.index') }}">Available
                                Properties</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="content-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold text-blue">Property Details: {{ $property->headline }}</h5>
                </div>
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.available-properties.update', $property->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column: Property Details -->
                            <div class="col-lg-8">
                                <div class="card shadow-sm mb-4 border-0">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-blue"><i class="fas fa-info-circle me-2"></i>Basic
                                            Information</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Property Headline</label>
                                            <input type="text" name="headline" class="form-control form-control-lg"
                                                placeholder="e.g. Luxury 5 Bedroom Villa in London"
                                                value="{{ old('headline', $property->headline) }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Property Location (UK Only)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i
                                                        class="fas fa-map-marker-alt text-danger"></i></span>
                                                <input type="text" id="location-input" name="location"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Search UK address..."
                                                    value="{{ old('location', $property->location) }}" required>
                                            </div>
                                            <input type="hidden" id="latitude" name="latitude"
                                                value="{{ $property->latitude }}">
                                            <input type="hidden" id="longitude" name="longitude"
                                                value="{{ $property->longitude }}">
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Marketing Purpose</label>
                                                <select name="marketing_purpose_id" class="form-select" required>
                                                    <option value="">Select Purpose</option>
                                                    @foreach($marketingPurposes as $purpose)
                                                        <option value="{{ $purpose->id }}" {{ (old('marketing_purpose_id', $property->marketing_purpose_id) == $purpose->id) ? 'selected' : '' }}>
                                                            {{ $purpose->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Price/Rent (£)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">£</span>
                                                    <input type="number" step="0.01" name="price" class="form-control"
                                                        placeholder="0.00" value="{{ old('price', $property->price) }}"
                                                        required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-bold text-blue"><i
                                                    class="fas fa-align-left me-2"></i>Full Description</label>
                                            <textarea name="full_description" id="editor" class="form-control"
                                                rows="10">{{ old('full_description', $property->full_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4 border-0">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-blue"><i class="fas fa-tools me-2"></i>Property
                                            Specifications</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Property Type</label>
                                                <select name="property_type_id" id="property_type_id" class="form-select"
                                                    required>
                                                    <option value="">Select Type</option>
                                                    @foreach($propertyTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                            data-name="{{ strtolower($type->name) }}" {{ (old('property_type_id', $property->property_type_id) == $type->id) ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Unit Type</label>
                                                <select name="unit_type_id" id="unit_type_id" class="form-select">
                                                    <option value="">Choose Category (Optional)</option>
                                                    @foreach($unitTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                            data-property-type="{{ $type->property_type_id }}" {{ (old('unit_type_id', $property->unit_type_id) == $type->id) ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row align-items-end">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Area (Sq Ft)</label>
                                                <div class="input-group">
                                                    <input type="number" name="area_sq_ft" class="form-control"
                                                        placeholder="e.g. 1500"
                                                        value="{{ old('area_sq_ft', $property->area_sq_ft) }}">
                                                    <span class="input-group-text">sq ft</span>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row" id="bed-bath-section">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Bedrooms</label>
                                                        <select name="bedrooms" class="form-select">
                                                            <option value="">Select Bedrooms</option>
                                                            <option value="Studio" {{ old('bedrooms', $property->bedrooms) == 'Studio' ? 'selected' : '' }}>Studio
                                                            </option>
                                                            @for($i = 1; $i <= 9; $i++)
                                                                <option value="{{ $i }}" {{ old('bedrooms', $property->bedrooms) == $i ? 'selected' : '' }}>{{ $i }}
                                                                </option>
                                                            @endfor
                                                            <option value="10+" {{ old('bedrooms', $property->bedrooms) == '10+' ? 'selected' : '' }}>10+
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Bathrooms</label>
                                                        <select name="bathrooms" class="form-select">
                                                            <option value="">Select Bathrooms</option>
                                                            @for($i = 1; $i <= 9; $i++)
                                                                <option value="{{ $i }}" {{ old('bathrooms', $property->bathrooms) == $i ? 'selected' : '' }}>{{ $i }}
                                                                </option>
                                                            @endfor
                                                            <option value="10+" {{ old('bathrooms', $property->bathrooms) == '10+' ? 'selected' : '' }}>10+
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Financial Details -->
                                <div class="card shadow-sm mb-4 border-0">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-blue"><i class="fas fa-pound-sign me-2"></i>Financial
                                            Details</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Current Value</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">£</span>
                                                    <input type="number" step="0.01" name="current_value"
                                                        class="form-control" placeholder="0.00"
                                                        value="{{ old('current_value', $property->current_value) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Purchase Date</label>
                                                <input type="date" name="purchase_date" class="form-control"
                                                    value="{{ old('purchase_date', $property->purchase_date ? $property->purchase_date->format('Y-m-d') : '') }}">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Is it a cash buy?</label>
                                                <select name="is_cash_buy" class="form-select">
                                                    <option value="0" {{ old('is_cash_buy', $property->is_cash_buy) == '0' ? 'selected' : '' }}>No</option>
                                                    <option value="1" {{ old('is_cash_buy', $property->is_cash_buy) == '1' ? 'selected' : '' }}>Yes</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Completion Deadline</label>
                                                <input type="date" name="completion_deadline" class="form-control"
                                                    value="{{ old('completion_deadline', $property->completion_deadline ? \Carbon\Carbon::parse($property->completion_deadline)->format('Y-m-d') : '') }}">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Financing Type</label>
                                            <select name="financing_type" id="financing_type" class="form-select mb-3">
                                                <option value="cash" {{ old('financing_type', $property->financing_type) == 'cash' ? 'selected' : '' }}>Cash Purchase
                                                </option>
                                                <option value="mortgage" {{ old('financing_type', $property->financing_type) == 'mortgage' ? 'selected' : '' }}>Mortgage
                                                </option>
                                            </select>

                                            <!-- Mortgage Details -->
                                            <div id="mortgage_details" style="display: none;">
                                                <div class="row g-3 p-3 bg-light rounded border">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Loan Amount</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="loan_amount"
                                                                class="form-control"
                                                                value="{{ old('loan_amount', $property->loan_amount) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Interest Rate</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" step="0.01" name="interest_rate"
                                                                class="form-control"
                                                                value="{{ old('interest_rate', $property->interest_rate) }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Lender Name</label>
                                                        <input type="text" name="lender_name"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('lender_name', $property->lender_name) }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Monthly Payment
                                                            (Override)</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="monthly_payment"
                                                                class="form-control"
                                                                value="{{ old('monthly_payment', $property->monthly_payment) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Costs Section -->
                                        <div class="mb-2">
                                            <label class="form-label fw-bold mb-3">Associated Costs</label>
                                            <div id="costs_container">
                                                @foreach($property->costs as $index => $cost)
                                                    <div class="row g-2 mb-2 align-items-center cost-row">
                                                        <div class="col-7">
                                                            <input type="text" name="costs[{{ $index }}][name]"
                                                                class="form-control form-control-sm" placeholder="Cost Name"
                                                                value="{{ $cost->name }}">
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text">£</span>
                                                                <input type="number" step="0.01"
                                                                    name="costs[{{ $index }}][amount]" class="form-control"
                                                                    placeholder="0.00" value="{{ $cost->amount }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-1 text-end">
                                                            <button type="button" class="btn btn-sm text-danger"
                                                                onclick="this.closest('.cost-row').remove()"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                                onclick="addCostRow()">
                                                <i class="fas fa-plus me-1"></i> Add Cost
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Investment Strategy -->
                                <div class="card shadow-sm mb-4 border-0">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-blue"><i class="fas fa-chart-line me-2"></i>Investment
                                            Strategy</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Investment Type</label>
                                            <select name="investment_type" id="investment_type" class="form-select mb-3">
                                                <option value="">Select Strategy</option>
                                                <option value="buy_to_sell" {{ old('investment_type', $property->investment_type) == 'buy_to_sell' ? 'selected' : '' }}>Buy to
                                                    Sell</option>
                                                <option value="rental" {{ old('investment_type', $property->investment_type) == 'rental' ? 'selected' : '' }}>Rental
                                                    Property</option>
                                                <option value="bmv_deal" {{ old('investment_type', $property->investment_type) == 'bmv_deal' ? 'selected' : '' }}>BMV Deal
                                                </option>
                                                <option value="refurb_deal" {{ old('investment_type', $property->investment_type) == 'refurb_deal' ? 'selected' : '' }}>Refurb
                                                    Deal</option>
                                                <option value="hmo" {{ old('investment_type', $property->investment_type) == 'hmo' ? 'selected' : '' }}>HMO</option>
                                                <option value="btl" {{ old('investment_type', $property->investment_type) == 'btl' ? 'selected' : '' }}>BTL (Buy to Let)
                                                </option>
                                                <option value="brr" {{ old('investment_type', $property->investment_type) == 'brr' ? 'selected' : '' }}>BRR (Buy Refurb
                                                    Refinance)</option>
                                                <option value="r2r" {{ old('investment_type', $property->investment_type) == 'r2r' ? 'selected' : '' }}>R2R (Rent to
                                                    Rent)</option>
                                                <option value="serviced_accommodation" {{ old('investment_type', $property->investment_type) == 'serviced_accommodation' ? 'selected' : '' }}>Serviced Accommodation (SA)</option>
                                            </select>

                                            <div id="buy_to_sell_details" style="display: none;">
                                                <div class="row g-3 p-3 bg-light rounded border">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Sale Price</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="sale_price"
                                                                class="form-control"
                                                                value="{{ old('sale_price', $property->sale_price) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Sale Date</label>
                                                        <input type="date" name="sale_date"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('sale_date', $property->sale_date ? $property->sale_date->format('Y-m-d') : '') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="rental_details" style="display: none;">
                                                <div class="row g-3 p-3 bg-light rounded border">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Monthly Rent</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="monthly_rent"
                                                                class="form-control"
                                                                value="{{ old('monthly_rent', $property->monthly_rent) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <div class="form-check mt-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_currently_rented" id="is_currently_rented" {{ old('is_currently_rented', $property->is_currently_rented) ? 'checked' : '' }}>
                                                            <label class="form-check-label small fw-bold"
                                                                for="is_currently_rented">
                                                                Currently Rented?
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-bold">Tenure Details</label>
                                            <select name="tenure_type" id="tenure_type" class="form-select mb-3">
                                                <option value="">Select Tenure</option>
                                                <option value="freehold" {{ old('tenure_type', $property->tenure_type) == 'freehold' ? 'selected' : '' }}>Freehold
                                                </option>
                                                <option value="leasehold" {{ old('tenure_type', $property->tenure_type) == 'leasehold' ? 'selected' : '' }}>Leasehold
                                                </option>
                                            </select>

                                            <div id="leasehold_details" style="display: none;">
                                                <div class="row g-3 p-3 bg-light rounded border">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Annual Service
                                                            Charge</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="service_charge"
                                                                class="form-control"
                                                                value="{{ old('service_charge', $property->service_charge) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Annual Ground Rent</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="ground_rent"
                                                                class="form-control"
                                                                value="{{ old('ground_rent', $property->ground_rent) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold">Years Remaining on
                                                            Lease</label>
                                                        <input type="number" name="lease_years_remaining"
                                                            class="form-control form-control-sm" placeholder="e.g. 125"
                                                            value="{{ old('lease_years_remaining', $property->lease_years_remaining) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tenancy & Compliance -->
                                <div class="card shadow-sm mb-4 border-0">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-blue"><i class="fas fa-file-contract me-2"></i>Tenancy
                                            & Compliance</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold mb-3">Tenants (Optional)</label>
                                            <div id="tenants_container">
                                                @foreach($property->tenants as $index => $tenant)
                                                    <div
                                                        class="row g-2 mb-3 p-2 border rounded bg-white tenant-row position-relative">
                                                        <button type="button"
                                                            class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 text-decoration-none"
                                                            onclick="this.closest('.tenant-row').remove()"
                                                            style="z-index:10;">&times;</button>
                                                        <div class="col-md-6">
                                                            <label class="form-label small mb-1">Full Name</label>
                                                            <input type="text" name="tenants[{{ $index }}][name]"
                                                                class="form-control form-control-sm" value="{{ $tenant->name }}"
                                                                required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small mb-1">Phone</label>
                                                            <input type="text" name="tenants[{{ $index }}][phone]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $tenant->phone }}">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="form-label small mb-1">Email</label>
                                                            <input type="email" name="tenants[{{ $index }}][email]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $tenant->email }}">
                                                        </div>
                                                        <div class="col-md-4 d-flex align-items-end">
                                                            <div class="form-check mb-1">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="tenants[{{ $index }}][is_primary]"
                                                                    id="primary_{{ $index }}" {{ $tenant->is_primary ? 'checked' : '' }}>
                                                                <label class="form-check-label small"
                                                                    for="primary_{{ $index }}">Primary Contact</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                                onclick="addTenantRow()">
                                                <i class="fas fa-user-plus me-1"></i> Add Tenant
                                            </button>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-bold mb-3">Compliance Certificates</label>
                                            <div class="row g-3 p-3 bg-light rounded border">
                                                <div class="col-12 fw-bold text-secondary small text-uppercase">Gas Safety
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Issue Date</label>
                                                    <input type="date" name="gas_safety_issue_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('gas_safety_issue_date', $property->gas_safety_issue_date ? $property->gas_safety_issue_date->format('Y-m-d') : '') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Expiry Date</label>
                                                    <input type="date" name="gas_safety_expiry_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('gas_safety_expiry_date', $property->gas_safety_expiry_date ? $property->gas_safety_expiry_date->format('Y-m-d') : '') }}">
                                                </div>

                                                <div class="col-12 fw-bold text-secondary small text-uppercase mt-2">
                                                    Electrical Safety (EICR)</div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Issue Date</label>
                                                    <input type="date" name="electrical_issue_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('electrical_issue_date', $property->electrical_issue_date ? $property->electrical_issue_date->format('Y-m-d') : '') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Expiry Date</label>
                                                    <input type="date" name="electrical_expiry_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('electrical_expiry_date', $property->electrical_expiry_date ? $property->electrical_expiry_date->format('Y-m-d') : '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Media & Features -->
                            <div class="col-lg-4">
                                <div class="card shadow-sm mb-4 border-0">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-blue"><i class="fas fa-images me-2"></i>Media & Gallery
                                        </h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-dark">Thumbnail Image</label>
                                            @if($property->thumbnail)
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url($property->thumbnail) }}" alt="Thumbnail"
                                                        class="img-fluid rounded border shadow-sm" style="max-height: 150px;">
                                                </div>
                                            @endif
                                            <div class="upload-container text-center border p-3 rounded bg-light">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                                <input type="file" id="thumb-input" name="thumbnail" class="form-control" accept="image/*">
                                                <div id="thumb-preview" class="preview-container"></div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-dark">Gallery Images</label>
                                            @if($property->gallery_images)
                                                <div class="d-flex flex-wrap gap-2 mb-2">
                                                    @foreach($property->gallery_images as $image)
                                                        <img src="{{ Storage::url($image) }}" alt="Gallery" class="img-thumbnail"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endforeach
                                                </div>
                                            @endif
                                            <input type="file" id="gallery-input" name="gallery_images[]" class="form-control" accept="image/*"
                                                multiple>
                                            <div id="gallery-preview" class="preview-container"></div>
                                            <small class="text-muted">Will replace current gallery</small>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-bold text-dark">Property Video</label>
                                            @if($property->video_url)
                                                <div class="mb-2">
                                                    <video width="100%" height="auto" controls class="rounded border shadow-sm">
                                                        <source src="{{ Storage::url($property->video_url) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                    <p class="small text-muted mt-1">Current Video</p>
                                                </div>
                                            @endif
                                            <input type="file" id="video-input" name="video" class="form-control" accept="video/*">
                                            <div id="video-preview" class="mt-3" style="display: none;">
                                                <video controls style="max-width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></video>
                                            </div>
                                            <small class="text-muted">Upload property walkthrough (MP4, Max 20MB)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4 border-0">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-blue"><i class="fas fa-list-ul me-2"></i>Features</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row">
                                            @foreach($features as $feature)
                                                <div class="col-6 mb-2">
                                                    <div class="form-check custom-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="features[]"
                                                            value="{{ $feature->id }}" id="feature_{{ $feature->id }}" {{ in_array($feature->id, old('features', $selectedFeatures)) ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="feature_{{ $feature->id }}">
                                                            {{ $feature->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm border-0 bg-light border-top border-4 border-primary">
                                    <div class="card-body p-4 text-center">
                                        <div class="mb-4 text-start">
                                            <label class="form-label fw-bold">Listing Status</label>
                                            <select name="status" class="form-select fw-600 text-dark">
                                                @if(auth()->user()->role === 'admin')
                                                    <option value="pending" {{ old('status', $property->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved" {{ old('status', $property->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="disapproved" {{ old('status', $property->status) == 'disapproved' ? 'selected' : '' }}>Disapproved
                                                    </option>
                                                    <option value="sold out" {{ old('status', $property->status) == 'sold out' ? 'selected' : '' }}>Sold Out</option>
                                                @else
                                                    <option value="pending" {{ old('status', $property->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="sold out" {{ old('status', $property->status) == 'sold out' ? 'selected' : '' }}>Sold Out</option>
                                                    @if(!in_array($property->status, ['pending', 'sold out']))
                                                        <option value="{{ $property->status }}" selected disabled>
                                                            {{ ucfirst($property->status) }}
                                                        </option>
                                                    @endif
                                                @endif
                                            </select>
                                            <small class="text-muted">Only 'Approved' properties are shown on the
                                                website.</small>
                                        </div>

                                        <div class="form-check mb-4 d-inline-block text-start">
                                            <input class="form-check-input" type="checkbox" name="discount_available"
                                                id="discountCheck" {{ old('discount_available', $property->discount_available) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="discountCheck">
                                                Mark as Discounted Property
                                            </label>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg fw-bold shadow-sm py-3 mb-2">
                                                <i class="fas fa-sync-alt me-2"></i>Update Property
                                            </button>
                                            <a href="{{ route('admin.available-properties.index') }}"
                                                class="btn btn-light btn-lg small text-muted border">
                                                Back to List
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @push('scripts')
                    <!-- CKEditor 5 -->
                    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
                    <!-- Google Maps Places API -->
                    <scriptsrc="https:
                        //maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places">
                        </script>
                        <script>
                            // Initialize CKEditor
                            ClassicEditor
                                .create(document.querySelector('#editor'), {
                                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
                                })
                                .catch(error => {
                                    console.error(error);
                                });

                            function initAutocomplete() {
                                const input = document.getElementById("location-input");
                                const options = {
                                    componentRestrictions: { country: "gb" },
                                    fields: ["address_components", "geometry", "icon", "name"],
                                    strictBounds: false,
                                };

                                const autocomplete = new google.maps.places.Autocomplete(input, options);

                                autocomplete.addListener("place_changed", () => {
                                    const place = autocomplete.getPlace();

                                    if (!place.geometry || !place.geometry.location) {
                                        window.alert("No details available for input: '" + place.name + "'");
                                        return;
                                    }

                                    document.getElementById("latitude").value = place.geometry.location.lat();
                                    document.getElementById("longitude").value = place.geometry.location.lng();
                                });
                            }

                            // Dynamic Unit Type Filtering & Bed/Bath Visibility
                            const propertyTypeSelect = document.getElementById('property_type_id');
                            const unitTypeSelect = document.getElementById('unit_type_id');
                            const bedBathSection = document.getElementById('bed-bath-section');
                            const unitTypeOptions = Array.from(unitTypeSelect.options);

                            function filterUnitTypes(isInitial = false) {
                                const selectedTypeId = propertyTypeSelect.value;
                                const selectedTypeName = propertyTypeSelect.options[propertyTypeSelect.selectedIndex]?.dataset.name || '';
                                const currentUnitTypeId = unitTypeSelect.value;

                                // Show/Hide Bed Bath section for Commercial
                                if (selectedTypeName.includes('commercial')) {
                                    bedBathSection.style.display = 'none';
                                } else {
                                    bedBathSection.style.display = 'flex';
                                }

                                // Filter Unit Types
                                unitTypeSelect.innerHTML = '<option value="">Choose Category (Optional)</option>';

                                if (selectedTypeId) {
                                    const filteredOptions = unitTypeOptions.filter(opt =>
                                        opt.dataset.propertyType === selectedTypeId || opt.value === ""
                                    );

                                    filteredOptions.forEach(opt => {
                                        if (opt.value !== "") {
                                            const newOpt = opt.cloneNode(true);
                                            if (isInitial && newOpt.value === currentUnitTypeId) {
                                                newOpt.selected = true;
                                            }
                                            unitTypeSelect.appendChild(newOpt);
                                        }
                                    });
                                }
                            }

                            propertyTypeSelect.addEventListener('change', () => filterUnitTypes(false));

                            // Initial call
                            if (propertyTypeSelect.value) {
                                filterUnitTypes(true);
                            }

                            // --- Dynamic Financial Fields ---
                            const financingSelect = document.getElementById('financing_type');
                            const mortgageDetails = document.getElementById('mortgage_details');

                            if (financingSelect) {
                                financingSelect.addEventListener('change', function () {
                                    mortgageDetails.style.display = this.value === 'mortgage' ? 'block' : 'none';
                                });
                                if (financingSelect.value === 'mortgage') mortgageDetails.style.display = 'block';
                            }

                            // --- Dynamic Investment Fields ---
                            const investmentSelect = document.getElementById('investment_type');
                            const buyToSellDetails = document.getElementById('buy_to_sell_details');
                            const rentalDetails = document.getElementById('rental_details');

                            if (investmentSelect) {
                                investmentSelect.addEventListener('change', function () {
                                    buyToSellDetails.style.display = this.value === 'buy_to_sell' ? 'block' : 'none';
                                    rentalDetails.style.display = this.value === 'rental' ? 'block' : 'none';
                                });
                                if (investmentSelect.value === 'buy_to_sell') buyToSellDetails.style.display = 'block';
                                if (investmentSelect.value === 'rental') rentalDetails.style.display = 'block';
                            }

                            // --- Dynamic Tenure Fields ---
                            const tenureSelect = document.getElementById('tenure_type');
                            const leaseholdDetails = document.getElementById('leasehold_details');

                            if (tenureSelect) {
                                tenureSelect.addEventListener('change', function () {
                                    leaseholdDetails.style.display = this.value === 'leasehold' ? 'block' : 'none';
                                });
                                if (tenureSelect.value === 'leasehold') leaseholdDetails.style.display = 'block';
                            }

                            // PREVIEW SYSTEM
                            function setupPreview(inputId, previewId, isMultiple = false) {
                                const input = document.getElementById(inputId);
                                const preview = document.getElementById(previewId);

                                input.addEventListener('change', function(e) {
                                    if (isMultiple) preview.innerHTML = '';
                                    else preview.innerHTML = '';

                                    const files = e.target.files;
                                    if (!files) return;

                                    for (let i = 0; i < files.length; i++) {
                                        const file = files[i];
                                        if (!file.type.startsWith('image/')) continue;

                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const div = document.createElement('div');
                                            div.className = 'preview-item';
                                            div.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                                            preview.appendChild(div);
                                        }
                                        reader.readAsDataURL(file);
                                    }
                                });
                            }

                            setupPreview('thumb-input', 'thumb-preview', false);
                            setupPreview('gallery-input', 'gallery-preview', true);

                            // Video Preview
                            const videoInput = document.getElementById('video-input');
                            const videoPreviewDiv = document.getElementById('video-preview');
                            const videoElement = videoPreviewDiv.querySelector('video');

                            videoInput.addEventListener('change', function(e) {
                                const file = e.target.files[0];
                                if (file && file.type.startsWith('video/')) {
                                    const url = URL.createObjectURL(file);
                                    videoElement.src = url;
                                    videoPreviewDiv.style.display = 'block';
                                } else {
                                    videoPreviewDiv.style.display = 'none';
                                }
                            });

                            // --- Dynamic Costs Rows ---
                            let costIndex = 1000;
                            window.addCostRow = function () {
                                const container = document.getElementById('costs_container');
                                const html = `
                                                <div class="row g-2 mb-2 align-items-center cost-row">
                                                    <div class="col-7">
                                                        <input type="text" name="costs[${costIndex}][name]" class="form-control form-control-sm" placeholder="Cost Name (e.g. Stamp Duty)">
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="costs[${costIndex}][amount]" class="form-control" placeholder="0.00">
                                                        </div>
                                                    </div>
                                                    <div class="col-1 text-end">
                                                        <button type="button" class="btn btn-sm text-danger" onclick="this.closest('.cost-row').remove()"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            `;
                                container.insertAdjacentHTML('beforeend', html);
                                costIndex++;
                            }

                            // --- Dynamic Tenants Rows ---
                            let tenantIndex = 1000;
                            window.addTenantRow = function () {
                                const container = document.getElementById('tenants_container');
                                const html = `
                                                <div class="row g-2 mb-3 p-2 border rounded bg-white tenant-row position-relative">
                                                    <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 text-decoration-none" onclick="this.closest('.tenant-row').remove()" style="z-index:10;">&times;</button>
                                                    <div class="col-md-6">
                                                        <label class="form-label small mb-1">Full Name</label>
                                                        <input type="text" name="tenants[${tenantIndex}][name]" class="form-control form-control-sm" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small mb-1">Phone</label>
                                                        <input type="text" name="tenants[${tenantIndex}][phone]" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="form-label small mb-1">Email</label>
                                                        <input type="email" name="tenants[${tenantIndex}][email]" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-4 d-flex align-items-end">
                                                        <div class="form-check mb-1">
                                                            <input class="form-check-input" type="checkbox" name="tenants[${tenantIndex}][is_primary]" id="primary_${tenantIndex}">
                                                            <label class="form-check-label small" for="primary_${tenantIndex}">Primary Contact</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                container.insertAdjacentHTML('beforeend', html);
                                tenantIndex++;
                            }

                            if (typeof google === 'object' && typeof google.maps === 'object') {
                                initAutocomplete();
                            }
                        </script>
                @endpush

@endsection