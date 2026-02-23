@extends('layouts.admin')

@section('title', 'Add New Property')

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
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Add New Property</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('available-properties.index') }}">Available
                                Properties</a></li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="content-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold text-blue">Property Details</h5>
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

                    <form action="{{ route('admin.available-properties.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

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
                                                value="{{ old('headline') }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Property Location (UK Only)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i
                                                        class="fas fa-map-marker-alt text-danger"></i></span>
                                                <input type="text" id="location-input" name="location"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Search UK address..." value="{{ old('location') }}"
                                                    required>
                                            </div>
                                            <input type="hidden" id="latitude" name="latitude">
                                            <input type="hidden" id="longitude" name="longitude">
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Marketing Purpose</label>
                                                <select name="marketing_purpose_id" class="form-select" required>
                                                    <option value="">Select Purpose</option>
                                                    @foreach($marketingPurposes as $purpose)
                                                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Price/Rent (£)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">£</span>
                                                    <input type="number" step="0.01" name="price" class="form-control"
                                                        placeholder="0.00" value="{{ old('price') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-bold text-blue"><i
                                                    class="fas fa-align-left me-2"></i>Full Description</label>
                                            <textarea name="full_description" id="editor" class="form-control"
                                                rows="10">{{ old('full_description') }}</textarea>
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
                                                            data-name="{{ strtolower($type->name) }}">
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
                                                            data-property-type="{{ $type->property_type_id }}">{{ $type->name }}
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
                                                        placeholder="e.g. 1500" value="{{ old('area_sq_ft') }}">
                                                    <span class="input-group-text">sq ft</span>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row" id="bed-bath-section">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Bedrooms</label>
                                                        <select name="bedrooms" class="form-select">
                                                            <option value="">Select Bedrooms</option>
                                                            <option value="Studio" {{ old('bedrooms') == 'Studio' ? 'selected' : '' }}>Studio</option>
                                                            @for($i = 1; $i <= 9; $i++)
                                                                <option value="{{ $i }}" {{ old('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                            @endfor
                                                            <option value="10+" {{ old('bedrooms') == '10+' ? 'selected' : '' }}>10+</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Bathrooms</label>
                                                        <select name="bathrooms" class="form-select">
                                                            <option value="">Select Bathrooms</option>
                                                            @for($i = 1; $i <= 9; $i++)
                                                                <option value="{{ $i }}" {{ old('bathrooms') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                            @endfor
                                                            <option value="10+" {{ old('bathrooms') == '10+' ? 'selected' : '' }}>10+</option>
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
                                                        value="{{ old('current_value') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Purchase Date</label>
                                                <input type="date" name="purchase_date" class="form-control"
                                                    value="{{ old('purchase_date') }}">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Financing Type</label>
                                            <select name="financing_type" id="financing_type" class="form-select mb-3">
                                                <option value="cash" {{ old('financing_type') == 'cash' ? 'selected' : '' }}>
                                                    Cash Purchase</option>
                                                <option value="mortgage" {{ old('financing_type') == 'mortgage' ? 'selected' : '' }}>Mortgage</option>
                                            </select>

                                            <!-- Mortgage Details -->
                                            <div id="mortgage_details" style="display: none;">
                                                <div class="row g-3 p-3 bg-light rounded border">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Loan Amount</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="loan_amount"
                                                                class="form-control" value="{{ old('loan_amount') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Interest Rate</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" step="0.01" name="interest_rate"
                                                                class="form-control" value="{{ old('interest_rate') }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Lender Name</label>
                                                        <input type="text" name="lender_name"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('lender_name') }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Monthly Payment
                                                            (Override)</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="monthly_payment"
                                                                class="form-control" value="{{ old('monthly_payment') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Costs Section -->
                                        <div class="mb-2">
                                            <label class="form-label fw-bold mb-3">Associated Costs</label>
                                            <div id="costs_container">
                                                <!-- Dynamic Rows -->
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
                                                <option value="buy_to_sell" {{ old('investment_type') == 'buy_to_sell' ? 'selected' : '' }}>Buy to Sell</option>
                                                <option value="rental" {{ old('investment_type') == 'rental' ? 'selected' : '' }}>Rental Property</option>
                                                <option value="bmv_deal" {{ old('investment_type') == 'bmv_deal' ? 'selected' : '' }}>BMV Deal</option>
                                                <option value="refurb_deal" {{ old('investment_type') == 'refurb_deal' ? 'selected' : '' }}>Refurb Deal</option>
                                                <option value="hmo" {{ old('investment_type') == 'hmo' ? 'selected' : '' }}>HMO</option>
                                                <option value="btl" {{ old('investment_type') == 'btl' ? 'selected' : '' }}>BTL (Buy to Let)</option>
                                                <option value="brr" {{ old('investment_type') == 'brr' ? 'selected' : '' }}>BRR (Buy Refurb Refinance)</option>
                                                <option value="r2r" {{ old('investment_type') == 'r2r' ? 'selected' : '' }}>R2R (Rent to Rent)</option>
                                                <option value="serviced_accommodation" {{ old('investment_type') == 'serviced_accommodation' ? 'selected' : '' }}>Serviced Accommodation (SA)</option>
                                            </select>

                                            <div id="buy_to_sell_details" style="display: none;">
                                                <div class="row g-3 p-3 bg-light rounded border">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Sale Price</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="sale_price"
                                                                class="form-control" value="{{ old('sale_price') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Sale Date</label>
                                                        <input type="date" name="sale_date"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('sale_date') }}">
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
                                                                class="form-control" value="{{ old('monthly_rent') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <div class="form-check mt-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_currently_rented" id="is_currently_rented" {{ old('is_currently_rented') ? 'checked' : '' }}>
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
                                                <option value="freehold" {{ old('tenure_type') == 'freehold' ? 'selected' : '' }}>Freehold</option>
                                                <option value="leasehold" {{ old('tenure_type') == 'leasehold' ? 'selected' : '' }}>Leasehold</option>
                                            </select>

                                            <div id="leasehold_details" style="display: none;">
                                                <div class="row g-3 p-3 bg-light rounded border">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Annual Service
                                                            Charge</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="service_charge"
                                                                class="form-control" value="{{ old('service_charge') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Annual Ground Rent</label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">£</span>
                                                            <input type="number" step="0.01" name="ground_rent"
                                                                class="form-control" value="{{ old('ground_rent') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold">Years Remaining on
                                                            Lease</label>
                                                        <input type="number" name="lease_years_remaining"
                                                            class="form-control form-control-sm" placeholder="e.g. 125"
                                                            value="{{ old('lease_years_remaining') }}">
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
                                                <!-- Dynamic Rows -->
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
                                                        value="{{ old('gas_safety_issue_date') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Expiry Date</label>
                                                    <input type="date" name="gas_safety_expiry_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('gas_safety_expiry_date') }}">
                                                </div>

                                                <div class="col-12 fw-bold text-secondary small text-uppercase mt-2">
                                                    Electrical Safety (EICR)</div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Issue Date</label>
                                                    <input type="date" name="electrical_issue_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('electrical_issue_date') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Expiry Date</label>
                                                    <input type="date" name="electrical_expiry_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('electrical_expiry_date') }}">
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
                                            <div class="upload-container text-center border p-3 rounded bg-light">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                                <small class="text-muted d-block mt-1">Main image for the property
                                                    listing</small>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-dark">Gallery Images</label>
                                            <input type="file" name="gallery_images[]" class="form-control" accept="image/*"
                                                multiple>
                                            <small class="text-muted">You can select multiple images</small>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-bold text-dark">Property Video</label>
                                            <input type="file" name="video" class="form-control" accept="video/*">
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
                                                            value="{{ $feature->id }}" id="feature_{{ $feature->id }}">
                                                        <label class="form-check-label small" for="feature_{{ $feature->id }}">
                                                            {{ $feature->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm border-0 bg-light">
                                    <div class="card-body p-4 text-center">
                                        <div class="mb-4 text-start">
                                            <label class="form-label fw-bold">Listing Status</label>
                                            <select name="status" class="form-select fw-600 text-dark">
                                                @if(auth()->user()->role === 'admin')
                                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>
                                                        Approved</option>
                                                    <option value="disapproved" {{ old('status') == 'disapproved' ? 'selected' : '' }}>Disapproved</option>
                                                    <option value="sold out" {{ old('status') == 'sold out' ? 'selected' : '' }}>
                                                        Sold Out</option>
                                                @else
                                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="sold out" {{ old('status') == 'sold out' ? 'selected' : '' }}>
                                                        Sold Out</option>
                                                @endif
                                            </select>
                                            <small class="text-muted">Only 'Approved' properties are shown on the
                                                website.</small>
                                        </div>

                                        <div class="form-check mb-4 d-inline-block text-start">
                                            <input class="form-check-input" type="checkbox" name="discount_available"
                                                id="discountCheck" {{ old('discount_available') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="discountCheck">
                                                Mark as Discounted Property
                                            </label>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg fw-bold shadow-sm py-3 mb-2">
                                                <i class="fas fa-paper-plane me-2"></i>Publish Property
                                            </button>
                                            <a href="{{ route('available-properties.index') }}"
                                                class="btn btn-light btn-lg small text-muted border">
                                                Save as Draft
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <!-- CKEditor 5 -->
        <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
        <!-- Google Maps Places API -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places"></script>
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
                        // User entered the name of a Place that was not suggested and
                        // pressed the Enter key, or the Place Details request failed.
                        window.alert("No details available for input: '" + place.name + "'");
                        return;
                    }

                    // Fill hidden fields
                    document.getElementById("latitude").value = place.geometry.location.lat();
                    document.getElementById("longitude").value = place.geometry.location.lng();
                });
            }

            // Dynamic Unit Type Filtering & Bed/Bath Visibility
            const propertyTypeSelect = document.getElementById('property_type_id');
            const unitTypeSelect = document.getElementById('unit_type_id');
            const bedBathSection = document.getElementById('bed-bath-section');
            const unitTypeOptions = Array.from(unitTypeSelect.options);

            function filterUnitTypes() {
                const selectedTypeId = propertyTypeSelect.value;
                const selectedTypeName = propertyTypeSelect.options[propertyTypeSelect.selectedIndex]?.dataset.name || '';

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
                            unitTypeSelect.appendChild(opt.cloneNode(true));
                        }
                    });
                }
            }

            propertyTypeSelect.addEventListener('change', filterUnitTypes);

            // Initial call if editing or validation failed
            if (propertyTypeSelect.value) {
                filterUnitTypes();
            }

            // --- Dynamic Financial Fields ---
            const financingSelect = document.getElementById('financing_type');
            const mortgageDetails = document.getElementById('mortgage_details');

            financingSelect.addEventListener('change', function () {
                mortgageDetails.style.display = this.value === 'mortgage' ? 'block' : 'none';
            });
            // Init
            if (financingSelect.value === 'mortgage') mortgageDetails.style.display = 'block';

            // --- Dynamic Investment Fields ---
            const investmentSelect = document.getElementById('investment_type');
            const buyToSellDetails = document.getElementById('buy_to_sell_details');
            const rentalDetails = document.getElementById('rental_details');

            investmentSelect.addEventListener('change', function () {
                buyToSellDetails.style.display = this.value === 'buy_to_sell' ? 'block' : 'none';
                rentalDetails.style.display = this.value === 'rental' ? 'block' : 'none';
            });
            // Init
            if (investmentSelect.value === 'buy_to_sell') buyToSellDetails.style.display = 'block';
            if (investmentSelect.value === 'rental') rentalDetails.style.display = 'block';

            // --- Dynamic Tenure Fields ---
            const tenureSelect = document.getElementById('tenure_type');
            const leaseholdDetails = document.getElementById('leasehold_details');

            tenureSelect.addEventListener('change', function () {
                leaseholdDetails.style.display = this.value === 'leasehold' ? 'block' : 'none';
            });
            // Init
            if (tenureSelect.value === 'leasehold') leaseholdDetails.style.display = 'block';

            // --- Dynamic Costs Rows ---
            let costIndex = 1000; // Start high to avoid collision or just increment
            function addCostRow() {
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
            function addTenantRow() {
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

            // Initialize if Google script is loaded
            if (typeof google === 'object' && typeof google.maps === 'object') {
                initAutocomplete();
            }
        </script>
    @endpush

@endsection