@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="available-properties-hero py-5 position-relative overflow-hidden">
        <div class="hero-overlay"></div>
        <div class="container py-lg-5 position-relative z-1">
            <div class="text-center mb-5">
                <h1 class="display-3 fw-800 text-white mb-3">Available Properties</h1>
                <p class="lead text-white opacity-90 mx-auto" style="max-width: 600px;">
                    Discover exclusive off-market property investment deals curated by the UK's leading sourcing agents.
                </p>
            </div>
            <br>

            <!-- Filter Section -->
            <div class="filter-container mx-auto" style="max-width: 1200px;">
                <div class="filter-wrapper p-4 p-lg-5 rounded-5 bg-white shadow-2xl border border-light-subtle">
                    <form action="{{ route('available-properties.index') }}" method="GET" id="filter-form">
                        <!-- Hidden View State -->
                        <input type="hidden" name="view" id="view-type" value="{{ request('view', 'grid') }}">

                        <div class="row g-3">
                            <!-- Basic Search (Always Visible) -->
                            <div class="col-lg-4">
                                <div class="filter-group">
                                    <label class="filter-label"><i class="bi bi-geo-alt-fill text-pink me-1"></i>
                                        Location</label>
                                    <div class="premium-field-group">
                                        <input type="text" id="location-search" class="premium-input w-100"
                                            placeholder="City, Area or Postcode..." value="{{ request('location') }}"
                                            name="location">
                                        <select name="radius" class="radius-select-floating">
                                            <option value="">Radius</option>
                                            <option value="5" {{ request('radius') == 5 ? 'selected' : '' }}>5m</option>
                                            <option value="10" {{ request('radius') == 10 ? 'selected' : '' }}>10m</option>
                                            <option value="20" {{ request('radius') == 20 ? 'selected' : '' }}>20m</option>
                                            <option value="50" {{ request('radius') == 50 ? 'selected' : '' }}>50m</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="lat" id="lat" value="{{ request('lat') }}">
                                    <input type="hidden" name="lng" id="lng" value="{{ request('lng') }}">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="filter-group">
                                    <label class="filter-label"><i class="bi bi-house-door-fill text-blue me-1"></i>
                                        Category</label>
                                    <select name="property_type" class="premium-select-v2 w-100">
                                        <option value="">All Categories</option>
                                        @foreach($propertyTypes as $type)
                                            <option value="{{ $type->id }}" {{ request('property_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="filter-group">
                                    <label class="filter-label"><i class="bi bi-currency-pound text-pink me-1"></i> Price
                                        Range</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="number" name="min_price" class="premium-input-small flex-grow-1"
                                            placeholder="Min" value="{{ request('min_price') }}">
                                        <input type="number" name="max_price" class="premium-input-small flex-grow-1"
                                            placeholder="Max" value="{{ request('max_price') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 d-flex gap-2 align-items-end">
                                <button type="submit" class="premium-search-btn flex-grow-1">
                                    <i class="bi bi-search me-2"></i> Search
                                </button>
                                <button type="button" class="advanced-toggle-btn" id="toggleAdvanced">
                                    <i class="bi bi-sliders2"></i>
                                </button>
                            </div>

                            <!-- Advanced Filters (Collapsible) -->
                            <div class="col-12 mt-3" id="advancedFiltersDiv"
                                style="{{ request()->anyFilled(['bedrooms', 'bathrooms', 'investment_strategy', 'tenure', 'unit_type']) ? '' : 'display: none;' }}">
                                <div class="row g-3 pt-3 border-top">
                                    <div class="col-lg-2">
                                        <div class="filter-group">
                                            <label class="filter-label">Bedrooms</label>
                                            <select name="bedrooms" class="premium-select-v2 w-100">
                                                <option value="">Any Beds</option>
                                                @for($i = 1; $i <= 8; $i++)
                                                    <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>
                                                        {{ $i }} Beds
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="filter-group">
                                            <label class="filter-label">Bathrooms</label>
                                            <select name="bathrooms" class="premium-select-v2 w-100">
                                                <option value="">Any Baths</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>
                                                        {{ $i }} Baths
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="filter-group">
                                            <label class="filter-label">Investment Strategy</label>
                                            <select name="investment_strategy" class="premium-select-v2 w-100">
                                                <option value="">All Strategies</option>
                                                <option value="bmv_deal" {{ request('investment_strategy') == 'bmv_deal' ? 'selected' : '' }}>BMV Deal</option>
                                                <option value="hmo" {{ request('investment_strategy') == 'hmo' ? 'selected' : '' }}>HMO</option>
                                                <option value="serviced_accommodation" {{ request('investment_strategy') == 'serviced_accommodation' ? 'selected' : '' }}>Serviced Accommodation</option>
                                                <option value="development" {{ request('investment_strategy') == 'development' ? 'selected' : '' }}>Development</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="filter-group">
                                            <label class="filter-label">Tenure</label>
                                            <select name="tenure" class="premium-select-v2 w-100">
                                                <option value="">All Tenures</option>
                                                <option value="freehold" {{ request('tenure') == 'freehold' ? 'selected' : '' }}>Freehold</option>
                                                <option value="leasehold" {{ request('tenure') == 'leasehold' ? 'selected' : '' }}>Leasehold</option>
                                                <option value="share_of_freehold" {{ request('tenure') == 'share_of_freehold' ? 'selected' : '' }}>Share of Freehold</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="filter-group">
                                            <label class="filter-label">Property Type</label>
                                            <select name="unit_type" class="premium-select-v2 w-100">
                                                <option value="">All Types</option>
                                                @foreach($unitTypes as $uType)
                                                    <option value="{{ $uType->id }}" {{ request('unit_type') == $uType->id ? 'selected' : '' }}>{{ $uType->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(request()->anyFilled(['location', 'min_price', 'max_price', 'property_type', 'bedrooms', 'bathrooms', 'investment_strategy', 'tenure', 'unit_type']))
                            <div class="mt-4 pt-4 border-top d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div class="applied-filters d-flex flex-wrap gap-2">
                                    <span class="small text-muted fw-bold me-2">ACTIVE FILTERS:</span>
                                    @foreach(request()->all() as $key => $value)
                                        @if($value && !in_array($key, ['lat', 'lng', 'view']))
                                            <span class="badge-premium">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</span>
                                        @endif
                                    @endforeach
                                </div>
                                <a href="{{ route('available-properties.index') }}" class="reset-link">
                                    <i class="bi bi-trash3 me-1"></i> Clear All
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Properties Grid/List -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-blue mb-0">
                    {{ $properties->total() }} Properties Found
                </h4>
                <div class="view-switcher d-flex gap-2">
                    <button class="btn-view-toggle {{ request('view', 'grid') == 'grid' ? 'active' : '' }}"
                        onclick="switchView('grid')">
                        <i class="bi bi-grid-fill"></i>
                    </button>
                    <button class="btn-view-toggle {{ request('view') == 'list' ? 'active' : '' }}"
                        onclick="switchView('list')">
                        <i class="bi bi-list-ul"></i>
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4 border-0 rounded-4 shadow-sm fw-600">{{ session('success') }}</div>
            @endif

            <div id="properties-container" class="{{ request('view', 'grid') == 'list' ? 'list-view' : 'grid-view' }}">
                @if($properties->count() > 0)
                    <div class="row g-4">
                        @foreach($properties as $property)
                            <div class="{{ request('view', 'grid') == 'list' ? 'col-12' : 'col-lg-4 col-md-6' }} property-item">
                                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden property-card-v2">
                                    <div class="row g-0 h-100">
                                        <div
                                            class="{{ request('view', 'grid') == 'list' ? 'col-md-4' : 'col-12' }} position-relative">
                                            <div class="property-image-wrapper h-100" style="min-height: 250px;">
                                                @if($property->thumbnail)
                                                    <img src="{{ Storage::url($property->thumbnail) }}" alt="{{ $property->headline }}"
                                                        class="w-100 h-100 object-fit-cover">
                                                @else
                                                    <img src="https://via.placeholder.com/400x300?text=No+Image" alt="No Image"
                                                        class="w-100 h-100 object-fit-cover">
                                                @endif

                                                <div class="status-badges">
                                                    <span
                                                        class="badge bg-pink shadow-sm">{{ $property->marketingPurpose->name ?? 'For Sale' }}</span>
                                                    @if($property->investment_type)
                                                        <span
                                                            class="badge bg-blue shadow-sm ms-1 text-uppercase">{{ str_replace('_', ' ', $property->investment_type) }}</span>
                                                    @endif
                                                </div>

                                                <div class="favorite-overlay">
                                                    <form action="{{ route('property.favorite.toggle', $property->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn-favorite-circle {{ $property->isFavoritedBy(auth()->user()) ? 'active' : '' }}">
                                                            <i
                                                                class="bi {{ $property->isFavoritedBy(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="{{ request('view', 'grid') == 'list' ? 'col-md-8' : 'col-12' }}">
                                            <div class="card-body p-4 d-flex flex-column h-100">
                                                <div class="mb-auto">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <span
                                                            class="text-pink fw-bold h4 mb-0">£{{ number_format($property->portal_sale_price, 0) }}</span>
                                                        <span
                                                            class="badge-tenure">{{ ucfirst($property->tenure_type ?? 'N/A') }}</span>
                                                    </div>
                                                    <h5 class="card-title fw-800 text-blue mb-2">{{ $property->headline }}</h5>
                                                    <div class="property-location text-muted mb-3"><i
                                                            class="bi bi-geo-alt-fill me-1 text-blue"></i>{{ $property->location }}
                                                    </div>

                                                    <div class="property-features mb-3">
                                                        <div class="feature-item">
                                                            <i class="bi bi-door-open"></i>
                                                            <span>{{ $property->bedrooms }} Beds</span>
                                                        </div>
                                                        <div class="feature-item">
                                                            <i class="bi bi-droplet"></i>
                                                            <span>{{ $property->bathrooms }} Baths</span>
                                                        </div>
                                                        <div class="feature-item">
                                                            <i class="bi bi-arrows-move"></i>
                                                            <span>{{ $property->area_sq_ft }} sqft</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-actions mt-3 pt-3 border-top d-flex gap-2">
                                                    <a href="{{ route('available-properties.show', $property->id) }}"
                                                        class="btn btn-blue btn-sm flex-grow-1 fw-bold py-2">View Details</a>
                                                    <button type="button" class="btn btn-outline-pink btn-sm py-2 px-3"
                                                        data-bs-toggle="modal" data-bs-target="#offerModal"
                                                        data-property-id="{{ $property->id }}"
                                                        data-property-title="{{ $property->headline }}">
                                                        <i class="bi bi-tag-fill"></i> Offer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex justify-content-center">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="text-center py-5 bg-white rounded-5 shadow-sm">
                        <i class="bi bi-house-door display-1 text-muted opacity-25 mb-3"></i>
                        <h3 class="text-blue fw-700">No Properties Found</h3>
                        <p class="text-muted">Try adjusting your filters to find more properties.</p>
                        <a href="{{ route('available-properties.index') }}" class="btn btn-pink px-4 py-2 mt-2 rounded-3">Reset
                            Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Offer & Message Modals remain the same as previous (skipping repeat to keep focus on redesign) -->
    @include('available_properties.partials.modals')

    <style>
        :root {
            --primary-blue: #1E4072;
            --primary-pink: #F95CA8;
        }

        .fw-800 {
            font-weight: 800;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fw-600 {
            font-weight: 600;
        }

        .available-properties-hero {
            background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            min-height: 450px;
            display: flex;
            align-items: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 64, 114, 0.95) 0%, rgba(30, 64, 114, 0.6) 100%);
        }

        .filter-wrapper {
            transition: all 0.4s ease;
            transform: translateY(-50px);
            margin-bottom: -50px;
            position: relative;
            z-index: 10;
        }

        .filter-label {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 800;
            margin-bottom: 8px;
            display: block;
        }

        .premium-field-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 2px;
            transition: 0.3s;
        }

        .premium-field-group:focus-within {
            border-color: var(--primary-pink);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(249, 92, 168, 0.1);
        }

        .premium-input {
            border: none;
            background: transparent;
            padding: 12px 15px;
            font-weight: 600;
            color: var(--primary-blue);
            font-size: 0.95rem;
            outline: none;
        }

        .premium-input-small {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 15px;
            font-weight: 600;
            color: var(--primary-blue);
            width: 100%;
            font-size: 0.9rem;
            outline: none;
            transition: 0.3s;
        }

        .premium-input-small:focus {
            border-color: var(--primary-pink);
            background: #fff;
        }

        .radius-select-floating {
            border: none;
            background: #fff;
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary-blue);
            cursor: pointer;
            margin-right: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .premium-select-v2 {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 15px;
            font-weight: 600;
            color: var(--primary-blue);
            font-size: 0.95rem;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%231E4072' viewBox='0 0 16 16'%3E%3Cpath d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .premium-search-btn {
            background: var(--primary-pink);
            color: white !important;
            border: none;
            border-radius: 12px;
            height: 56px;
            font-weight: 700;
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px -5px rgba(249, 92, 168, 0.4);
        }

        .premium-search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(249, 92, 168, 0.5);
        }

        .advanced-toggle-btn {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: var(--primary-blue);
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .advanced-toggle-btn:hover {
            background: var(--primary-blue);
            color: #fff;
            border-color: var(--primary-blue);
        }

        /* View Switcher */
        .btn-view-toggle {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .btn-view-toggle.active {
            background: var(--primary-blue);
            color: #fff;
            border-color: var(--primary-blue);
        }

        /* Property Card V2 */
        .property-card-v2 {
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .grid-view .property-image-wrapper {
            height: 250px !important;
            min-height: 250px !important;
            max-height: 250px !important;
            overflow: hidden;
        }

        .grid-view .card-title {
            height: 54px;
            /* Fixed height for 2 lines */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 27px;
        }

        .grid-view .property-location {
            height: 40px;
            /* Fixed height for location */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            font-size: 0.85rem;
        }

        .property-card-v2:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1) !important;
        }

        .status-badges {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 2;
        }

        .status-badges .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 700;
        }

        .favorite-overlay {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 2;
        }

        .btn-favorite-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: 0.3s;
        }

        .btn-favorite-circle.active {
            color: #ff4757;
            background: #fff;
        }

        .badge-tenure {
            padding: 4px 10px;
            background: rgba(30, 64, 114, 0.08);
            border-radius: 6px;
            color: var(--primary-blue);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .property-features {
            display: flex;
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #4b5563;
            font-weight: 600;
        }

        .feature-item i {
            color: var(--primary-pink);
        }

        /* List View Tweaks */
        .list-view .property-item {
            margin-bottom: 20px;
        }

        .list-view .property-card-v2 {
            min-height: 250px;
        }

        .list-view .property-image-wrapper {
            height: 100% !important;
        }

        @media (max-width: 768px) {
            .list-view .property-image-wrapper {
                height: 250px !important;
            }
        }

        .badge-premium {
            background: rgba(30, 64, 114, 0.05);
            color: var(--primary-blue);
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid rgba(30, 64, 114, 0.1);
        }

        .btn-pink {
            background: var(--primary-pink);
            color: #fff;
        }

        .btn-blue {
            background: var(--primary-blue);
            color: #fff;
        }

        .btn-outline-pink {
            border: 2px solid var(--primary-pink);
            color: var(--primary-pink);
            font-weight: 700;
        }

        .btn-outline-pink:hover {
            background: var(--primary-pink);
            color: #fff;
        }

        .btn-blue:hover {
            border-color: var(--primary-blue);
            color: #000000ff;
        }
    </style>

    @push('scripts')
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Advanced Toggle
                const toggleBtn = document.getElementById('toggleAdvanced');
                const advancedDiv = document.getElementById('advancedFiltersDiv');

                toggleBtn.addEventListener('click', function () {
                    if (advancedDiv.style.display === 'none') {
                        advancedDiv.style.display = 'block';
                        this.classList.add('active');
                        this.style.background = '#1E4072';
                        this.style.color = '#fff';
                    } else {
                        advancedDiv.style.display = 'none';
                        this.classList.remove('active');
                        this.style.background = '#fff';
                        this.style.color = '#1E4072';
                    }
                });

                // Init Google Places
                initAutocomplete();
            });

            function switchView(type) {
                document.getElementById('view-type').value = type;
                const form = document.getElementById('filter-form');

                // If we want to switch without reloading everything, we can do it via JS
                // but since the user wants it to work 100% (likely including layout logic),
                // submitting the form is safer or we just reload with the param.
                const url = new URL(window.location.href);
                url.searchParams.set('view', type);
                window.location.href = url.toString();
            }

            function initAutocomplete() {
                const input = document.getElementById('location-search');
                if (!input) return;

                const options = {
                    componentRestrictions: { country: "gb" },
                    fields: ["geometry", "name"],
                };

                const autocomplete = new google.maps.places.Autocomplete(input, options);

                autocomplete.addListener("place_changed", () => {
                    const place = autocomplete.getPlace();
                    if (!place.geometry || !place.geometry.location) return;

                    document.getElementById('lat').value = place.geometry.location.lat();
                    document.getElementById('lng').value = place.geometry.location.lng();
                });

                input.addEventListener('input', function () {
                    if (this.value === '') {
                        document.getElementById('lat').value = '';
                        document.getElementById('lng').value = '';
                    }
                });
            }
        </script>
    @endpush

@endsection