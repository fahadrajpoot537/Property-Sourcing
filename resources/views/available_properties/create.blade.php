@extends('layouts.admin')

@section('title', 'Create Property Deal')

@push('styles')
    <style>
        :root {
            --wizard-accent: var(--primary-pink);
            --wizard-primary: var(--primary-blue);
        }

        /* Wizard Header & Navigation */
        .wizard-header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            border-bottom: 3px solid var(--wizard-accent);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .step-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .step-nav::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e3e6f0;
            z-index: 1;
        }

        .step-anchor {
            position: relative;
            z-index: 2;
            background: white;
            padding: 0 10px;
            text-align: center;
            flex: 1;
            cursor: pointer;
        }

        .step-icon {
            width: 42px;
            height: 42px;
            background: white;
            border: 2px solid #e3e6f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 700;
            color: #b7b9cc;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-anchor.active .step-icon {
            border-color: var(--wizard-accent);
            color: var(--wizard-accent);
            transform: scale(1.1);
            box-shadow: 0 0 0 6px rgba(249, 92, 168, 0.1);
        }

        .step-anchor.completed .step-icon {
            background: var(--wizard-accent);
            border-color: var(--wizard-accent);
            color: white;
        }

        .step-text {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #b7b9cc;
        }

        .step-anchor.active .step-text {
            color: var(--wizard-primary);
        }

        /* Step Visibility */
        .wizard-step {
            display: none;
            animation: slideUp 0.4s ease-out;
        }

        .wizard-step.active {
            display: block;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Elements */
        .admin-form-group {
            margin-bottom: 25px;
        }

        .admin-label {
            display: block;
            font-weight: 700;
            color: var(--primary-blue);
            font-size: 0.85rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-input {
            width: 100%;
            padding: 14px 20px;
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            background-color: #f8f9fc;
            transition: all 0.3s;
            color: #4e5e7a;
            font-weight: 500;
        }

        .admin-input:focus {
            background-color: #fff;
            border-color: var(--primary-pink);
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(249, 92, 168, 0.1);
        }

        .admin-input:read-only {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        /* Sections */
        .form-section-title {
            color: var(--primary-pink);
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1.5px dashed #e3e6f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Calculation Badge */
        .calc-badge {
            background: rgba(30, 64, 114, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-top: 10px;
        }

        /* Media Upload */
        .upload-placeholder {
            border: 2px dashed #e3e6f0;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            background: #f8f9fc;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-placeholder:hover {
            border-color: var(--primary-pink);
            background: white;
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

        .preview-item img,
        .preview-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-preview-item {
            aspect-ratio: 16/9;
            width: 100%;
            max-width: 400px;
        }

        /* Wizard Footer */
        .wizard-footer {
            margin-top: 30px;
            padding: 25px 0;
            border-top: 1px solid #e3e6f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-badge-premium {
            background: var(--primary-blue);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .price-badge-premium div span {
            display: block;
            text-transform: uppercase;
            font-size: 0.65rem;
            font-weight: 800;
            opacity: 0.7;
            letter-spacing: 0.5px;
        }

        .price-badge-premium h4 {
            margin: 0;
            font-weight: 800;
            color: #4CD7F6;
        }

        .ck-editor__editable {
            min-height: 250px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Broadcast New Deal</h2>
            <p class="text-muted mb-0">Follow the property sourcing worksheet to upload your deal</p>
        </div>
        <a href="{{ route('admin.available-properties.index') }}" class="btn btn-admin-edit">
            <i class="bi bi-x-lg me-2"></i>Cancel
        </a>
    </div>

    <div class="wizard-header">
        <div class="step-nav">
            <div class="step-anchor active" onclick="goToStep(1)" id="nav-1">
                <div class="step-icon">1</div>
                <div class="step-text">Valuation & Location</div>
            </div>
            <div class="step-anchor" onclick="goToStep(2)" id="nav-2">
                <div class="step-icon">2</div>
                <div class="step-text">Property Specs</div>
            </div>
            <div class="step-anchor" id="nav-3">
                <div class="step-icon">3</div>
                <div class="step-text">Media & Description</div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.available-properties.store') }}" method="POST" enctype="multipart/form-data"
        id="multistep-form">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger ms-5 me-5 mt-4 p-4 rounded-4 border-0 shadow-sm">
                <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> Please fix the
                    following errors:</h6>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="wizard-step active" id="step-1">
            <div class="content-card">
                <div class="card-header">
                    <h5><i class="bi bi-tag-fill me-2 text-pink"></i>Valuation & Basic Details</h5>
                </div>
                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4 mb-5">
                        <div class="col-md-6 admin-form-group">
                            <label class="admin-label">Deal Type</label>
                            <select name="investment_type" id="investment_type" class="admin-input" required>
                                <option value="bmv_deal" {{ old('investment_type') == 'bmv_deal' ? 'selected' : '' }}>Below
                                    Market Value (BMV)</option>
                                <option value="refurb_deal" {{ old('investment_type') == 'refurb_deal' ? 'selected' : '' }}>
                                    Refurbishment Project</option>
                                <option value="rental" {{ old('investment_type') == 'rental' ? 'selected' : '' }}>Rental Yield
                                    / BTL</option>
                                <option value="hmo" {{ old('investment_type') == 'hmo' ? 'selected' : '' }}>HMO</option>
                                <option value="buy_to_sell" {{ old('investment_type') == 'buy_to_sell' ? 'selected' : '' }}>
                                    Development / Buy to Sell</option>
                                <option value="serviced_accommodation" {{ old('investment_type') == 'serviced_accommodation' ? 'selected' : '' }}>Serviced Accommodation (SA)</option>
                                <option value="r2r" {{ old('investment_type') == 'r2r' ? 'selected' : '' }}>Rent to Rent (R2R)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Marketing Purpose</label>
                            <select name="marketing_purpose_id" class="admin-input" required>
                                @foreach($marketingPurposes as $purpose)
                                    <option value="{{ $purpose->id }}" {{ old('marketing_purpose_id') == $purpose->id ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 admin-form-group">
                            <label class="admin-label">Property Title / Headline</label>
                            <input type="text" name="headline" class="admin-input" value="{{ old('headline') }}"
                                placeholder="e.g. Stunning 3 Bed Semi-Detached" required>
                        </div>
                    </div>

                    <div class="form-section-title"><i class="bi bi-currency-pound"></i> Pricing & Fees</div>
                    <div class="row g-4">
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Vendor Sale Price (£)</label>
                            <input type="number" step="1" name="price" id="vendor-price" class="admin-input"
                                value="{{ old('price') }}" placeholder="0" required>
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">PSG Sourcing Fee (£)</label>
                            <input type="text" id="psg-fees-display" class="admin-input" readonly
                                placeholder="Auto-calculated">
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Portal Sale Price (£)</label>
                            <input type="text" id="portal-price-display" class="admin-input" readonly
                                placeholder="Auto-calculated (B3+B4)">
                        </div>
                    </div>

                    <div class="form-section-title mt-4"><i class="bi bi-graph-up-arrow"></i> Market Analysis</div>
                    <div class="row g-4">
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Min Market Value (£)</label>
                            <input type="number" step="1" name="market_value_min" id="mv-min" class="admin-input"
                                value="{{ old('market_value_min') }}" placeholder="0">
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Max Market Value (£)</label>
                            <input type="number" step="1" name="market_value_max" id="mv-max" class="admin-input"
                                value="{{ old('market_value_max') }}" placeholder="0">
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Average Market Value (£)</label>
                            <input type="text" id="mv-avg-display" class="admin-input" readonly
                                placeholder="Auto (avg check)">
                        </div>
                        <div class="col-12">
                            <div class="calc-badge d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="admin-label mb-0" style="font-size: 0.7rem;">Calculated Investor
                                        Discount</span>
                                    <h3 class="mb-0 fw-black text-pink" id="discount-display">0%</h3>
                                </div>
                                <i class="bi bi-percent fs-1 text-muted opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title mt-5"><i class="bi bi-geo-alt-fill"></i> Property Location</div>
                    <div class="row g-3">
                        <div class="col-12 admin-form-group">
                            <label class="admin-label">Search Address</label>
                            <input type="text" id="location-input" name="location" class="admin-input"
                                value="{{ old('location') }}" placeholder="Type here to autocomplete from Google Maps...">
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                        </div>
                        <div class="col-md-3 admin-form-group">
                            <label class="admin-label">Door Number</label>
                            <input type="text" name="door_number" class="admin-input" placeholder="e.g. 52">
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">City</label>
                            <input type="text" name="city" id="city-input" class="admin-input"
                                placeholder="e.g. Manchester">
                        </div>
                        <div class="col-md-5 admin-form-group">
                            <label class="admin-label">Post Code</label>
                            <input type="text" name="postcode" id="postcode-input" class="admin-input"
                                placeholder="e.g. M1 1AF">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: PROPERTY SPECS -->
        <div class="wizard-step" id="step-2">
            <div class="content-card">
                <div class="card-header">
                    <h5><i class="bi bi-house-gear-fill me-2 text-pink"></i>Property Hardware & Tenure</h5>
                </div>
                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6 admin-form-group">
                            <label class="admin-label">Property Category</label>
                            <select name="property_type_id" id="property-type-select" class="admin-input" required>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 admin-form-group">
                            <label class="admin-label">Property Type (Specific)</label>
                            <select name="unit_type_id" id="unit-type-select" class="admin-input">
                                <option value="">Select Type</option>
                                @foreach($unitTypes as $unit)
                                    <option value="{{ $unit->id }}" data-parent="{{ $unit->property_type_id }}">
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">No. of Bedrooms</label>
                            <select name="bedrooms" class="admin-input">
                                @for($i = 1; $i <= 10; $i++)
                                <option value="{{$i}}">{{$i}} Bed</option> @endfor
                                <option value="11">10+ Bed</option>
                            </select>
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">No. of Bathrooms</label>
                            <select name="bathrooms" class="admin-input">
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{$i}}">{{$i}} Bath</option> @endfor
                                <option value="6">5+ Bath</option>
                            </select>
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Area (Sq Ft)</label>
                            <input type="number" name="area_sq_ft" class="admin-input" placeholder="Total Area">
                        </div>
                    </div>

                    <div class="form-section-title mt-4"><i class="bi bi-journal-check"></i> Tenure & Contracts</div>
                    <div class="row g-4">
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Tenure Type</label>
                            <select name="tenure_type" id="tenure-type" class="admin-input">
                                <option value="freehold">Freehold</option>
                                <option value="leasehold">Leasehold</option>
                            </select>
                        </div>
                        <div class="col-md-4 admin-form-group" id="lease-years-container" style="display: none;">
                            <label class="admin-label">Lease Years Remaining</label>
                            <input type="number" name="lease_years_remaining" class="admin-input" placeholder="e.g. 999">
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Share of Freehold?</label>
                            <select name="share_of_freehold" class="admin-input">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-6 admin-form-group">
                            <label class="admin-label">Assignable Contract?</label>
                            <select name="assignable_contract" class="admin-input">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rental Fields (Hidden by default, shown based on JS) -->
                    <div id="rental-fields-section" style="display: none;">
                        <div class="form-section-title mt-4 text-success"><i class="bi bi-wallet2"></i> Rental Information
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4 admin-form-group">
                                <label class="admin-label text-success">Monthly Rent (£)</label>
                                <input type="number" name="monthly_rent" class="admin-input" placeholder="0">
                            </div>
                            <div class="col-md-4 admin-form-group d-flex align-items-end">
                                <div
                                    class="form-check form-switch admin-input d-flex align-items-center justify-content-between py-3">
                                    <label class="admin-label mb-0 text-success" for="is_currently_rented">Currently
                                        Rented?</label>
                                    <input class="form-check-input" type="checkbox" name="is_currently_rented"
                                        id="is_currently_rented" value="1">
                                </div>
                            </div>
                            <div class="col-md-4 admin-form-group" id="yearly-rent-container" style="display: none;">
                                <label class="admin-label text-success">Yearly Rent (£)</label>
                                <input type="number" name="yearly_rent" class="admin-input" placeholder="Total annual">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="admin-label">Amenities & Selling Points</label>
                        <div class="feature-chips">
                            @foreach($features as $feature)
                                <div class="feature-chip">
                                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                                        id="f_{{ $feature->id }}">
                                    <label for="f_{{ $feature->id }}"><i class="bi bi-check2"></i> {{ $feature->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: MEDIA & STATUS -->
        <div class="wizard-step" id="step-3">
            <div class="content-card">
                <div class="card-header">
                    <h5><i class="bi bi-camera-fill me-2 text-pink"></i>Marketing & Status</h5>
                </div>
                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4 mb-5">
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Cash Buyers Only?</label>
                            <select name="is_cash_buy" class="admin-input">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Exchange Deadline</label>
                            <select name="exchange_deadline" class="admin-input">
                                <option value="14 days">Within 14 Days</option>
                                <option value="28 days">Within 28 Days</option>
                                <option value="6 weeks">6 Weeks</option>
                                <option value="flexible">Flexible</option>
                            </select>
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label class="admin-label">Completion Deadline</label>
                            <select name="completion_deadline" class="admin-input">
                                <option value="14 days">Within 14 Days</option>
                                <option value="28 days">Within 28 Days</option>
                                <option value="6 weeks">6 Weeks</option>
                                <option value="flexible">Flexible</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title"><i class="bi bi-card-text"></i> Property Description</div>
                    <div class="admin-form-group">
                        <textarea name="full_description" id="editor"
                            class="admin-input">{{ old('full_description') }}</textarea>
                    </div>

                    <div class="form-section-title mt-5"><i class="bi bi-images"></i> Media Assets</div>
                    <div class="row g-4">
                        <div class="col-md-6 admin-form-group">
                            <label class="admin-label">Main Display Image</label>
                            <div class="upload-placeholder" onclick="document.getElementById('thumb-input').click()">
                                <i class="bi bi-cloud-arrow-up fs-1 text-pink opacity-50"></i>
                                <p class="mb-0 text-muted mt-2">Click to upload Thumbnail</p>
                                <input type="file" id="thumb-input" name="thumbnail" class="d-none" accept="image/*">
                                <div id="thumb-preview" class="preview-container"></div>
                            </div>
                        </div>
                        <div class="col-md-6 admin-form-group">
                            <label class="admin-label">Gallery Images (Up to 10)</label>
                            <div class="upload-placeholder" onclick="document.getElementById('gallery-input').click()">
                                <i class="bi bi-images fs-1 text-pink opacity-50"></i>
                                <p class="mb-0 text-muted mt-2">Click to upload Multi-images</p>
                                <input type="file" id="gallery-input" name="gallery_images[]" class="d-none" multiple
                                    accept="image/*">
                                <div id="gallery-preview" class="preview-container"></div>
                            </div>
                        </div>
                        <div class="col-12 admin-form-group">
                            <label class="admin-label">Property Video (Optional)</label>
                            <input type="file" id="video-input" name="video" class="form-control admin-input p-2"
                                accept="video/*">
                            <div id="video-preview" class="mt-3" style="display: none;">
                                <video controls
                                    style="max-width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"></video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- WIZARD FOOTER -->
        <div class="wizard-footer">
            <button type="button" class="btn btn-outline-secondary px-5 py-3 rounded-pill fw-bold" id="prev-btn"
                style="visibility: hidden;">
                <i class="bi bi-arrow-left me-2"></i>Back To Previous
            </button>

            <div class="price-badge-premium d-none d-md-flex">
                <i class="bi bi-shield-check fs-2 text-pink"></i>
                <div>
                    <span>Investor Cost (Portal Price)</span>
                    <h4 id="footer-portal-price">£0.00</h4>
                </div>
            </div>

            <div>
                <button type="button" class="btn btn-admin-primary px-5 py-3 rounded-pill" id="next-btn">
                    Next Step <i class="bi bi-arrow-right ms-2"></i>
                </button>
                <button type="submit" name="status" value="pending" class="btn btn-admin-pink px-5 py-3 rounded-pill"
                    id="finish-btn" style="display: none;">
                    Publish Deal <i class="bi bi-broadcast ms-2"></i>
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places"></script>
        <script>
            let currentStep = 1;
            const totalSteps = 3;

            function updateWizard() {
                document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
                document.getElementById(`step-${currentStep}`).classList.add('active');

                document.querySelectorAll('.step-anchor').forEach((item, idx) => {
                    const sIdx = idx + 1;
                    item.classList.remove('active', 'completed');
                    if (sIdx === currentStep) item.classList.add('active');
                    if (sIdx < currentStep) item.classList.add('completed');
                });

                document.getElementById('prev-btn').style.visibility = currentStep === 1 ? 'hidden' : 'visible';

                if (currentStep === totalSteps) {
                    document.getElementById('next-btn').style.display = 'none';
                    document.getElementById('finish-btn').style.display = 'block';
                } else {
                    document.getElementById('next-btn').style.display = 'block';
                    document.getElementById('finish-btn').style.display = 'none';
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            function goToStep(s) {
                if (s < currentStep) {
                    currentStep = s;
                    updateWizard();
                }
            }

            document.getElementById('next-btn').addEventListener('click', () => {
                if (currentStep < totalSteps) { currentStep++; updateWizard(); }
            });

            document.getElementById('prev-btn').addEventListener('click', () => {
                if (currentStep > 1) { currentStep--; updateWizard(); }
            });

            // Editor
            ClassicEditor.create(document.querySelector('#editor')).catch(console.error);

            // Maps Autocomplete
            function initAutocomplete() {
                const input = document.getElementById("location-input");
                const autocomplete = new google.maps.places.Autocomplete(input, { componentRestrictions: { country: "gb" } });
                autocomplete.addListener("place_changed", () => {
                    const place = autocomplete.getPlace();
                    if (place.geometry) {
                        document.getElementById("latitude").value = place.geometry.location.lat();
                        document.getElementById("longitude").value = place.geometry.location.lng();

                        // Parse Address Components
                        place.address_components.forEach(comp => {
                            const types = comp.types;
                            if (types.includes('postal_code')) document.getElementById('postcode-input').value = comp.long_name;
                            if (types.includes('locality')) document.getElementById('city-input').value = comp.long_name;
                        });
                    }
                });
            }
            document.addEventListener('DOMContentLoaded', initAutocomplete);

            // REAL-TIME CALCULATIONS
            const vendorInput = document.getElementById('vendor-price');
            const psgFeesDisplay = document.getElementById('psg-fees-display');
            const portalPriceDisplay = document.getElementById('portal-price-display');
            const footerPortalPrice = document.getElementById('footer-portal-price');

            const mvMin = document.getElementById('mv-min');
            const mvMax = document.getElementById('mv-max');
            const mvAvgDisplay = document.getElementById('mv-avg-display');
            const discountDisplay = document.getElementById('discount-display');

            function runCalcs() {
                // Price & Fees
                const vendor = parseFloat(vendorInput.value) || 0;
                const fee = vendor * 0.02;
                const portal = vendor + fee;

                psgFeesDisplay.value = fee.toLocaleString('en-GB', { minimumFractionDigits: 2 });
                portalPriceDisplay.value = portal.toLocaleString('en-GB', { minimumFractionDigits: 2 });
                footerPortalPrice.textContent = '£' + portal.toLocaleString('en-GB', { minimumFractionDigits: 2 });

                // Market Value & Discount
                const min = parseFloat(mvMin.value) || 0;
                const max = parseFloat(mvMax.value) || 0;
                const avg = (min + max) / 2;

                if (avg > 0) {
                    mvAvgDisplay.value = avg.toLocaleString('en-GB', { minimumFractionDigits: 2 });
                    const disc = ((1 - (portal / avg)) * 100);
                    discountDisplay.textContent = Math.max(0, disc).toFixed(1) + '%';
                } else {
                    mvAvgDisplay.value = '';
                    discountDisplay.textContent = '0%';
                }
            }

            [vendorInput, mvMin, mvMax].forEach(el => el.addEventListener('input', runCalcs));

            // Logic Togglers
            const investmentType = document.getElementById('investment_type');
            const tenureType = document.getElementById('tenure-type');
            const rentedCheck = document.getElementById('is_currently_rented');

            function toggleLogic() {
                // Tenure
                document.getElementById('lease-years-container').style.display = (tenureType.value === 'leasehold') ? 'block' : 'none';

                // Rental Strategy
                const isRental = (investmentType.value === 'rental' || investmentType.value === 'hmo' || investmentType.value === 'r2r');
                document.getElementById('rental-fields-section').style.display = isRental ? 'block' : 'none';

                // Yearly Rent
                document.getElementById('yearly-rent-container').style.display = (isRental && rentedCheck.checked) ? 'block' : 'none';
            }

            [investmentType, tenureType, rentedCheck].forEach(el => el.addEventListener('change', toggleLogic));
            toggleLogic();

            // Property Type Filtering
            const propertyTypeSelect = document.getElementById('property-type-select');
            const unitTypeSelect = document.getElementById('unit-type-select');
            const unitOptions = Array.from(unitTypeSelect.options);

            function filterUnitTypes() {
                const parentId = propertyTypeSelect.value;
                unitTypeSelect.innerHTML = '<option value="">Select Type</option>';

                unitOptions.forEach(opt => {
                    if (opt.getAttribute('data-parent') === parentId) {
                        unitTypeSelect.appendChild(opt.cloneNode(true));
                    }
                });
            }

            propertyTypeSelect.addEventListener('change', filterUnitTypes);
            filterUnitTypes(); // Initial run

            // PREVIEW SYSTEM
            function setupPreview(inputId, previewId, isMultiple = false) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function (e) {
                    if (isMultiple) preview.innerHTML = '';
                    else preview.innerHTML = '';

                    const files = e.target.files;
                    if (!files) return;

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        if (!file.type.startsWith('image/')) continue;

                        const reader = new FileReader();
                        reader.onload = function (e) {
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

            videoInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('video/')) {
                    const url = URL.createObjectURL(file);
                    videoElement.src = url;
                    videoPreviewDiv.style.display = 'block';
                } else {
                    videoPreviewDiv.style.display = 'none';
                }
            });
        </script>
    @endpush
@endsection