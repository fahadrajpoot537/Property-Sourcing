@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>User Profile</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <form action="{{ route('admin.users.status', $user) }}" method="POST" class="d-inline-block">
                    @csrf
                    <input type="hidden" name="status" value="{{ $user->status == 1 ? 0 : 1 }}">
                    <button type="submit" class="btn {{ $user->status == 1 ? 'btn-warning' : 'btn-success' }}">
                        <i class="bi {{ $user->status == 1 ? 'bi-x-circle' : 'bi-check-circle' }} me-2"></i>
                        {{ $user->status == 1 ? 'Suspend User' : 'Approve User' }}
                    </button>
                </form>
                @if($user->role !== 'admin')
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-block ms-2"
                        onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-2"></i>Delete User
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Profile Info -->
        <div class="col-lg-4">
            <!-- Main Profile Card -->
            <div class="card shadow-sm border-0 mb-4 rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4 border-bottom-0">
                    <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center mb-3 shadow"
                        style="width: 80px; height: 80px; font-size: 2.5rem;">
                        <i class="bi bi-person"></i>
                    </div>
                    <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <span
                            class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'agent' ? 'bg-info text-dark' : 'bg-light text-primary') }} text-capitalize px-3 py-1 rounded-pill">
                            <i
                                class="bi {{ $user->role === 'admin' ? 'bi-shield-lock' : ($user->role === 'agent' ? 'bi-briefcase' : 'bi-person') }} me-1"></i>
                            {{ $user->role === 'user' ? 'Investor' : $user->role }}
                        </span>
                        @if($user->status == 1)
                            <span class="badge bg-success px-3 py-1 rounded-pill"><i class="bi bi-check-circle me-1"></i>
                                Active</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill"><i
                                    class="bi bi-hourglass-split me-1"></i> Pending</span>
                        @endif
                    </div>
                    <p class="mb-0 text-white-50 small">Joined {{ $user->created_at->format('F d, Y') }}</p>
                </div>

                <div class="card-body p-0">
                    <ul class="list-group list-group-flush border-top-0">
                        <li class="list-group-item px-4 py-3 d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-primary"><i class="bi bi-envelope"></i></div>
                            <div>
                                <span class="d-block text-muted small fw-semibold text-uppercase">Email Address</span>
                                <a href="mailto:{{ $user->email }}"
                                    class="text-decoration-none text-dark fw-medium">{{ $user->email }}</a>
                            </div>
                        </li>
                        <li class="list-group-item px-4 py-3 d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-primary"><i class="bi bi-telephone"></i></div>
                            <div>
                                <span class="d-block text-muted small fw-semibold text-uppercase">Phone Number</span>
                                @if($user->phone || $user->phone_number)
                                    <a href="tel:{{ $user->phone ?? $user->phone_number }}"
                                        class="text-decoration-none text-dark fw-medium">{{ $user->phone ?? $user->phone_number }}</a>
                                @else
                                    <span class="text-muted fw-medium font-monospace">Not Provided</span>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item px-4 py-3 d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-primary"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <span class="d-block text-muted small fw-semibold text-uppercase">Location / Address</span>
                                @if($user->address || $user->address_line1 || $user->city)
                                    <div class="text-dark fw-medium">
                                        {{ $user->address_line1 ?? $user->address }}<br>
                                        @if($user->address_line2) {{ $user->address_line2 }}<br> @endif
                                        {{ implode(', ', array_filter([$user->city, $user->postcode, $user->country])) }}
                                    </div>
                                @else
                                    <span class="text-muted fw-medium font-monospace">Not Provided</span>
                                @endif
                            </div>
                        </li>
                        @if($user->company_name || $user->company_registration_number)
                    <li class="list-group-item px-4 py-3 d-flex align-items-center">
                        <div class="bg-light rounded p-2 me-3 text-primary"><i class="bi bi-building"></i></div>
                        <div>
                            <span class="d-block text-muted small fw-semibold text-uppercase">Company</span>
                            <span class="text-dark fw-medium">{{ $user->company_name ?? 'Company Name N/A' }}</span>
                            @if($user->company_registration || $user->company_registration_number)
                                <span class="d-block text-muted small mt-1">Reg: {{ $user->company_registration ?? $user->company_registration_number }}</span>
                            @endif
                            @if($user->company_address)
                                <span class="d-block text-muted small mt-1">{{ $user->company_address }}, {{ $user->company_town }}, {{ $user->company_postcode }}</span>
                            @endif
                        </div>
                    </li>
                    @endif
                    </ul>
                </div>
            </div>

            <!-- Investment Profile (if investor) -->
            @if($user->role === 'user' || $user->investment_type)
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Investment Profile</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 border-bottom pb-3">
                            <span class="d-block text-muted small fw-semibold text-uppercase mb-1">Investment Interests</span>
                            @if($user->property_interests)
                                @foreach(explode(',', $user->property_interests) as $interest)
                                    <span class="badge bg-light text-dark border me-1 mb-1 px-2 py-1">{{ trim($interest) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted small italic">No specific interests recorded.</span>
                            @endif
                        </div>

                        <div class="mb-3 border-bottom pb-3">
                            <span class="d-block text-muted small fw-semibold text-uppercase mb-1">Investment Type</span>
                            @if($user->investment_type)
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">{{ $user->investment_type }}</span>
                            @else
                                <span class="text-muted small italic">Not specified</span>
                            @endif
                        </div>

                        <div class="mb-3 border-bottom pb-3">
                            <span class="d-block text-muted small fw-semibold text-uppercase mb-1">Max Budget Range</span>
                            @if($user->min_budget || $user->max_budget)
                                <h5 class="text-success mb-0 fw-bold">£{{ number_format($user->min_budget, 0) }} -
                                    £{{ number_format($user->max_budget, 0) }}</h5>
                            @elseif($user->budget)
                                <h5 class="text-success mb-0 fw-bold">Up to £{{ number_format($user->budget, 0) }}</h5>
                            @else
                                <span class="text-muted small italic">Not specified</span>
                            @endif
                        </div>

                        <div>
                            <span class="d-block text-muted small fw-semibold text-uppercase mb-1">Verified Cash Buyer</span>
                            @if($user->is_cash_buy)
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-cash-coin me-1"></i> Yes,
                                    Verified</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2 rounded-pill"><i class="bi bi-dash-circle me-1"></i>
                                    No</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Activity & Related Data -->
        <div class="col-lg-8">

            <!-- About Section -->
            @if($user->about_me)
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill text-primary me-2"></i>About User</h6>
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-0 text-muted">{{ $user->about_me }}</p>
                    </div>
                </div>
            @endif

            <ul class="nav nav-tabs nav-tabs-custom mb-4 border-bottom-0" id="userTabs" role="tablist">
                @if($user->role === 'agent')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active bg-white border-0 shadow-sm rounded-top-3 px-4 py-3 fw-medium"
                            id="properties-tab" data-bs-toggle="tab" data-bs-target="#properties" type="button" role="tab">
                            <i class="bi bi-houses me-2"></i>Listed Properties <span
                                class="badge bg-secondary ms-2 rounded-pill">{{ $user->properties->count() }}</span>
                        </button>
                    </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link {{ $user->role !== 'agent' ? 'active' : '' }} bg-white border-0 shadow-sm rounded-top-3 px-4 py-3 fw-medium"
                        id="offers-tab" data-bs-toggle="tab" data-bs-target="#offers" type="button" role="tab">
                        <i class="bi bi-tags me-2"></i>Offers Made <span
                            class="badge bg-secondary ms-2 rounded-pill">{{ $user->offers->count() }}</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content border-0 bg-transparent p-0" id="userTabsContent">

                <!-- Agent Properties Tab -->
                @if($user->role === 'agent')
                    <div class="tab-pane fade show active" id="properties" role="tabpanel" tabindex="0">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                            <div class="card-body p-0">
                                @if($user->properties->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="bg-light text-muted small text-uppercase">
                                                <tr>
                                                    <th class="ps-4">Property</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Date Listed</th>
                                                    <th class="text-end pe-4">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user->properties as $property)
                                                    <tr>
                                                        <td class="ps-4">
                                                            <div class="d-flex align-items-center">
                                                                @if($property->thumbnail)
                                                                    <img src="{{ asset('storage/' . $property->thumbnail) }}"
                                                                        class="rounded me-3 object-fit-cover" width="48" height="48"
                                                                        alt="Img">
                                                                @else
                                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                                                                        style="width: 48px; height: 48px;">
                                                                        <i class="bi bi-house text-muted"></i>
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <a href="{{ route('admin.available-properties.show', $property->id) }}"
                                                                        class="text-decoration-none text-dark fw-bold">{{ Str::limit($property->headline, 30) }}</a>
                                                                    <div class="small text-muted"><i
                                                                            class="bi bi-geo-alt me-1"></i>{{ Str::limit($property->location, 30) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fw-medium">
                                                            £{{ number_format($property->portal_sale_price ?? $property->price, 2) }}
                                                        </td>
                                                        <td>
                                                            @if($property->status === 'approved')
                                                                <span class="badge bg-success-subtle text-success">Approved</span>
                                                            @elseif($property->status === 'pending')
                                                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-secondary-subtle text-secondary text-capitalize">{{ $property->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="small text-muted">{{ $property->created_at->format('d M, Y') }}</td>
                                                        <td class="text-end pe-4">
                                                            <a href="{{ route('admin.available-properties.show', $property->id) }}"
                                                                class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="bi bi-houses fs-1 text-muted opacity-25 d-block mb-3"></i>
                                        <h5 class="text-muted">No Properties Listed</h5>
                                        <p class="text-muted small">This agent hasn't listed any properties yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Offers Tab -->
                <div class="tab-pane fade {{ $user->role !== 'agent' ? 'show active' : '' }}" id="offers" role="tabpanel"
                    tabindex="0">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            @if($user->offers->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light text-muted small text-uppercase">
                                            <tr>
                                                <th class="ps-4">Property</th>
                                                <th>Offer Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th class="text-end pe-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->offers as $offer)
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            @if($offer->property && $offer->property->thumbnail)
                                                                <img src="{{ asset('storage/' . $offer->property->thumbnail) }}"
                                                                    class="rounded me-3 object-fit-cover" width="40" height="40"
                                                                    alt="Img">
                                                            @else
                                                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="bi bi-house text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="fw-bold text-dark">
                                                                    {{ $offer->property ? Str::limit($offer->property->headline, 30) : 'Deleted Property' }}
                                                                </div>
                                                                @if($offer->property)
                                                                    <a href="{{ route('admin.available-properties.show', $offer->property->id) }}"
                                                                        class="small text-primary text-decoration-none">View Property <i
                                                                            class="bi bi-arrow-right-short"></i></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-success">£{{ number_format($offer->offer_amount, 2) }}
                                                    </td>
                                                    <td>
                                                        @if($offer->status === 'accepted')
                                                            <span class="badge bg-success-subtle text-success">Accepted</span>
                                                        @elseif($offer->status === 'rejected')
                                                            <span class="badge bg-danger-subtle text-danger">Rejected</span>
                                                        @else
                                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td class="small text-muted">{{ $offer->created_at->format('d M, Y') }}</td>
                                                    <td class="text-end pe-4">
                                                        @if($offer->property)
                                                            <a href="{{ route('admin.property-offers.index', $offer->property->id) }}"
                                                                class="btn btn-sm btn-light border" title="View Property Offers">
                                                                <i class="bi bi-card-list"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-tags fs-1 text-muted opacity-25 d-block mb-3"></i>
                                    <h5 class="text-muted">No Offers Made</h5>
                                    <p class="text-muted small">This user hasn't made any offers on properties yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .nav-tabs-custom .nav-link {
            color: #6c757d;
            background: transparent;
            transition: all 0.2s ease-in-out;
        }

        .nav-tabs-custom .nav-link:hover {
            color: var(--bs-primary);
            background-color: rgba(255, 255, 255, 0.5) !important;
        }

        .nav-tabs-custom .nav-link.active {
            color: var(--bs-primary);
            background-color: #fff !important;
            border-bottom: 3px solid var(--bs-primary) !important;
        }

        .list-group-item {
            border-color: rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection