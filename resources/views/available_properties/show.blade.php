@extends('layouts.app')

@section('content')

    <div class="container py-5">
        <a href="{{ route('available-properties.index') }}" class="text-decoration-none text-muted mb-4 d-inline-block"><i
                class="bi bi-arrow-left me-2"></i>Back to Properties</a>

        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <span class="badge bg-pink mb-2">{{ $property->marketingPurpose->name ?? 'For Sale' }}</span>
                    @if($property->discount_available)
                        <span class="badge bg-success mb-2 ms-2">Discount Available</span>
                    @endif
                    <h1 class="fw-bold text-blue">{{ $property->headline }}</h1>
                    <p class="h4 text-muted">
                        <i class="bi bi-geo-alt-fill me-2 text-pink"></i>
                        @if($property->door_number) {{ $property->door_number }}, @endif
                        {{ $property->location }}

                    </p>
                </div>

                <!-- Gallery -->
                <div class="card border-0 rounded-4 overflow-hidden mb-4 shadow-sm">
                    @if($property->thumbnail)
                        <img src="{{ Storage::url($property->thumbnail) }}" class="img-fluid w-100 object-fit-cover"
                            style="max-height: 500px;" alt="{{ $property->headline }}">
                    @else
                        <img src="https://via.placeholder.com/800x500?text=No+Wait+Image" class="img-fluid w-100"
                            alt="No Image">
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                    <h4 class="fw-bold text-blue mb-3">Property Description</h4>
                    <div class="text-muted leading-relaxed">
                        {!! $property->full_description !!}
                    </div>
                </div>

                <!-- Features -->
                @if($property->features->count() > 0)
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h4 class="fw-bold text-blue mb-3">Features & Amenities</h4>
                        <div class="row g-3">
                            @foreach($property->features as $feature)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span>{{ $feature->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Gallery Grid -->
                @if($property->gallery_images)
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h4 class="fw-bold text-blue mb-3">Photo Gallery</h4>
                        <div class="row g-2">
                            @foreach($property->gallery_images as $image)
                                <div class="col-6 col-md-4">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                        <img src="{{ Storage::url($image) }}"
                                            class="img-fluid rounded-3 w-100 object-fit-cover hover-zoom" style="height: 150px;"
                                            alt="Gallery Image">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Video -->
                @if($property->video_url)
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h4 class="fw-bold text-blue mb-3">Video Tour</h4>
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                            @if(Str::contains($property->video_url, ['youtube.com', 'youtu.be', 'vimeo.com']))
                                <iframe src="{{ str_replace('watch?v=', 'embed/', $property->video_url) }}"
                                    allowfullscreen></iframe>
                            @else
                                <video width="100%" height="auto" controls>
                                    <source src="{{ Storage::url($property->video_url) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Investment & Financial Details -->
                <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                    <h4 class="fw-bold text-blue mb-3">Investment Details</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Investment Strategy</span>
                                    <span
                                        class="fw-bold">{{ ucfirst(str_replace('_', ' ', $property->investment_type)) }}</span>
                                </li>
                                @if($property->current_value)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Current Value</span>
                                        <span class="fw-bold">£{{ number_format($property->current_value, 2) }}</span>
                                    </li>
                                @endif
                                @if($property->purchase_date)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Purchase Date</span>
                                        <span
                                            class="fw-bold">{{ \Carbon\Carbon::parse($property->purchase_date)->format('d M Y') }}</span>
                                    </li>
                                @endif
                                @if($property->investment_type == 'rental')
                                    @if($property->monthly_rent)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Est. Monthly Rent</span>
                                            <span class="fw-bold">£{{ number_format($property->monthly_rent, 2) }}</span>
                                        </li>
                                    @endif
                                    @if($property->yearly_rent)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Est. Yearly Rent</span>
                                            <span class="fw-bold">£{{ number_format($property->yearly_rent, 2) }}</span>
                                        </li>
                                    @endif
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Tenanted</span>
                                        <span class="fw-bold">{{ $property->is_currently_rented ? 'Yes' : 'No' }}</span>
                                    </li>
                                @elseif($property->investment_type == 'buy_to_sell')
                                    @if($property->sale_price)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Target Sale Price</span>
                                            <span class="fw-bold">£{{ number_format($property->sale_price, 2) }}</span>
                                        </li>
                                    @endif
                                    @if($property->sale_date)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Target Sale Date</span>
                                            <span
                                                class="fw-bold">{{ \Carbon\Carbon::parse($property->sale_date)->format('d M Y') }}</span>
                                        </li>
                                    @endif
                                @endif
                                @if($property->assignable_contract)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Assignable Contract</span>
                                        <span class="fw-bold">{{ ucfirst($property->assignable_contract) }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Tenure</span>
                                    <span class="fw-bold">{{ ucfirst($property->tenure_type) }}</span>
                                </li>
                                @if($property->tenure_type == 'leasehold')
                                    @if($property->share_of_freehold)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Share of Freehold</span>
                                            <span class="fw-bold">{{ ucfirst($property->share_of_freehold) }}</span>
                                        </li>
                                    @endif
                                    @if($property->lease_years_remaining)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Lease Remaining</span>
                                            <span class="fw-bold">{{ $property->lease_years_remaining }} Years</span>
                                        </li>
                                    @endif
                                    @if($property->service_charge)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Service Charge</span>
                                            <span class="fw-bold">£{{ number_format($property->service_charge, 2) }}</span>
                                        </li>
                                    @endif
                                    @if($property->ground_rent)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Ground Rent</span>
                                            <span class="fw-bold">£{{ number_format($property->ground_rent, 2) }}</span>
                                        </li>
                                    @endif
                                @endif
                                @if($property->is_cash_buy)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Cash Buy Required</span>
                                        <span class="fw-bold text-success">Yes</span>
                                    </li>
                                @endif
                                @if($property->exchange_deadline)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Exchange Deadline</span>
                                        <span
                                            class="fw-bold text-danger">{{ \Carbon\Carbon::parse($property->exchange_deadline)->format('d M Y') }}</span>
                                    </li>
                                @endif
                                @if($property->completion_deadline)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Completion Deadline</span>
                                        <span
                                            class="fw-bold text-danger">{{ \Carbon\Carbon::parse($property->completion_deadline)->format('d M Y') }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Market Value Analysis -->
                    @if($property->market_value_avg)
                        <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                            <h4 class="fw-bold text-blue mb-3">Market Value Analysis</h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 text-center">
                                        <small class="text-muted d-block">Market Value (Min)</small>
                                        <span
                                            class="h5 fw-bold text-dark">£{{ number_format($property->market_value_min, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 text-center border border-primary">
                                        <small class="text-muted d-block">Average Market Value</small>
                                        <span
                                            class="h5 fw-bold text-blue">£{{ number_format($property->market_value_avg, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 text-center">
                                        <small class="text-muted d-block">Market Value (Max)</small>
                                        <span
                                            class="h5 fw-bold text-dark">£{{ number_format($property->market_value_max, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            @php
                                $saving = (float) $property->market_value_avg - (float) $property->price;
                                $savingPercentage = $property->market_value_avg > 0 ? ($saving / (float) $property->market_value_avg) * 100 : 0;
                            @endphp
                            @if($saving > 0)
                                <div class="mt-3 p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold text-success"><i class="bi bi-graph-down-arrow me-2"></i>Instant
                                                Equity / Saving</span>
                                        </div>
                                        <div class="text-end">
                                            <span class="h5 fw-bold text-success mb-0">£{{ number_format($saving, 2) }}
                                                ({{ round($savingPercentage, 1) }}%)</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Mortgage / Financing Details -->
                    @if($property->financing_type == 'mortgage' || $property->loan_amount)
                        <div class="mt-4 pt-4 border-top">
                            <h5 class="fw-bold text-blue mb-3">Financing & Mortgage Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="text-muted">Financing Type</span>
                                            <span class="fw-bold">{{ ucfirst($property->financing_type) }}</span>
                                        </li>
                                        @if($property->lender_name)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="text-muted">Lender</span>
                                                <span class="fw-bold">{{ $property->lender_name }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        @if($property->loan_amount)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="text-muted">Loan Amount</span>
                                                <span class="fw-bold">£{{ number_format($property->loan_amount, 2) }}</span>
                                            </li>
                                        @endif
                                        @if($property->interest_rate)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="text-muted">Interest Rate</span>
                                                <span class="fw-bold">{{ $property->interest_rate }}%</span>
                                            </li>
                                        @endif
                                        @if($property->monthly_payment)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="text-muted">Monthly Payment</span>
                                                <span class="fw-bold">£{{ number_format($property->monthly_payment, 2) }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Associated Costs -->
                @if($property->costs->count() > 0)
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h4 class="fw-bold text-blue mb-3">Associated Costs</h4>
                        <ul class="list-group list-group-flush">
                            @foreach($property->costs as $cost)
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">{{ $cost->name }}</span>
                                    <span class="fw-bold text-dark">£{{ number_format($cost->amount, 2) }}</span>
                                </li>
                            @endforeach
                            <li
                                class="list-group-item d-flex justify-content-between px-0 bg-light border-top border-primary border-2 mt-2 p-2 rounded">
                                <span class="fw-bold text-primary">Total Additional Costs</span>
                                <span
                                    class="fw-bold text-primary">£{{ number_format($property->costs->sum('amount'), 2) }}</span>
                            </li>
                        </ul>
                    </div>
                @endif

                <!-- Compliance -->
                <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                    <h4 class="fw-bold text-blue mb-3">Compliance</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border-start border-danger border-4">
                                <h6 class="fw-bold d-flex align-items-center"><i class="bi bi-fire text-danger me-2"></i>Gas
                                    Safety</h6>
                                <p class="mb-1 small text-muted">Issue:
                                    {{ $property->gas_safety_issue_date ? $property->gas_safety_issue_date->format('d M Y') : 'N/A' }}
                                </p>
                                <p class="mb-0 small text-muted">Expiry:
                                    {{ $property->gas_safety_expiry_date ? $property->gas_safety_expiry_date->format('d M Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border-start border-warning border-4">
                                <h6 class="fw-bold d-flex align-items-center"><i
                                        class="bi bi-lightning-charge-fill text-warning me-2"></i>Electrical Safety (EICR)
                                </h6>
                                <p class="mb-1 small text-muted">Issue:
                                    {{ $property->electrical_issue_date ? $property->electrical_issue_date->format('d M Y') : 'N/A' }}
                                </p>
                                <p class="mb-0 small text-muted">Expiry:
                                    {{ $property->electrical_expiry_date ? $property->electrical_expiry_date->format('d M Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top overflow-hidden" style="top: 100px;">
                    <div class="card-body p-4">
                        <h3 class="fw-bold text-pink mb-4">
                            £{{ number_format($property->portal_sale_price ?? $property->price, 2) }}</h3>
                        <p class="text-muted small mt-n3 mb-4">Inclusive of platform fee</p>

                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="bi bi-house me-2"></i>Type</span>
                                <span class="fw-bold">{{ $property->propertyType->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="bi bi-tag me-2"></i>Category</span>
                                <span class="fw-bold">{{ $property->unitType->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="bi bi-arrows-move me-2"></i>Area</span>
                                <span class="fw-bold">{{ $property->area_sq_ft }} sq ft</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="bi bi-door-open me-2"></i>Bedrooms</span>
                                <span class="fw-bold">{{ $property->bedrooms }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="bi bi-droplet me-2"></i>Bathrooms</span>
                                <span class="fw-bold">{{ $property->bathrooms }}</span>
                            </li>
                        </ul>

                        <form action="{{ route('inquiry.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="property">
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="owner_id" value="{{ $property->user_id }}">
                            <input type="hidden" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                            <input type="hidden" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                            <input type="hidden" name="phone"
                                value="{{ Auth::check() && Auth::user()->phone ? Auth::user()->phone : 'N/A' }}">
                            <input type="hidden" name="source_page" value="{{ url()->current() }}">
                            <input type="hidden" name="comments"
                                value="Inquiry for Property: {{ $property->headline }} (ID: {{ $property->id }}) at {{ $property->location }}">

                            <button type="submit" class="btn btn-custom-pink w-100 py-3 mb-4 fw-bold">Enquire Now</button>
                        </form>

                        <div class="bg-light p-3 rounded-3 mb-4">
                            <h6 class="fw-bold text-blue mb-3">Investor Benefits</h6>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><i class="bi bi-check2 text-pink me-2"></i> Access Off market Deals</li>
                                <li class="mb-2"><i class="bi bi-check2 text-pink me-2"></i> Up to 35% Equity / BMV</li>
                                <li class="mb-2"><i class="bi bi-check2 text-pink me-2"></i> Distress Sales opportunities
                                </li>
                                <li class="mb-2"><i class="bi bi-check2 text-pink me-2"></i> Access to UK wide deals</li>
                                <li><i class="bi bi-check2 text-pink me-2"></i> Cash Buyer verification</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2">
                            <!-- Favorite Button -->
                            <form action="{{ route('property.favorite.toggle', $property->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn w-100 {{ $property->isFavoritedBy(auth()->user()) ? 'btn-danger' : 'btn-outline-secondary' }}">
                                    <i
                                        class="bi {{ $property->isFavoritedBy(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                                    {{ $property->isFavoritedBy(auth()->user()) ? 'Remove from Favorites' : 'Add to Favorites' }}
                                </button>
                            </form>

                            <!-- Offer Button -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#offerModal">
                                <i class="bi bi-tag-fill me-2"></i>Make an Offer
                            </button>

                            <!-- Message Button -->
                            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#messageModal">
                                <i class="bi bi-chat-dots-fill me-2"></i>Message Admin
                            </button>

                            <!-- Download Brochure Button -->
                            @if(auth()->check())
                                <a href="{{ route('available-properties.brochure', $property->id) }}"
                                    class="btn btn-custom-blue w-100 py-3 mt-2 fw-bold">
                                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Download Brochure
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offer Modal -->
    <div class="modal fade" id="offerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Make an Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('property.offer.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Your Offer Amount (£)</label>
                            <input type="number" name="offer_amount" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="3"
                                placeholder="Any strict conditions or comments..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Offer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('property.message.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" required
                                placeholder="Type your message here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .leading-relaxed {
            line-height: 1.8;
        }

        .hover-zoom {
            transition: transform 0.3s;
        }

        .hover-zoom:hover {
            transform: scale(1.05);
        }
    </style>

@endsection