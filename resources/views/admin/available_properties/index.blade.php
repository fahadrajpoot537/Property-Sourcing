@extends('layouts.admin')

@section('title', 'Manage Available Properties')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Manage Available Properties</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Available Properties</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <button type="button" id="btnSendBulkEmail" class="btn btn-admin-blue" style="display: none;">
                    <i class="bi bi-envelope-paper me-2"></i>Send Selected via Email
                </button>
                <a href="{{ route('admin.available-properties.create') }}" class="btn btn-admin-pink">
                    <i class="bi bi-plus-lg me-2"></i>Add New Available Property
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card blue">
                <div class="icon">
                    <i class="bi bi-building"></i>
                </div>
                <h3>{{ $properties->total() }}</h3>
                <p>Total Available</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card pink">
                <div class="icon">
                    <i class="bi bi-tag"></i>
                </div>
                <h3>{{ $properties->where('marketing_purpose_id', '!=', null)->count() }}</h3>
                <p>Categorized</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header Buttons -->
    <div class="row g-3 mb-4 align-items-center">
        <div class="col">
            <h5 class="mb-0 text-dark fw-bold"><i
                    class="bi bi-list-ul me-2"></i>{{ request('status') ? ucfirst(request('status')) : 'All' }} Available
                Properties</h5>
            <span class="text-muted small">Showing {{ $properties->firstItem() ?? 0 }} - {{ $properties->lastItem() ?? 0 }}
                of {{ $properties->total() }} properties</span>
        </div>
        <div class="col-auto d-flex gap-2">
            <button type="button" class="btn btn-light border btn-sm px-3" data-bs-toggle="modal"
                data-bs-target="#propertyFilterModal">
                <i class="bi bi-sliders me-2"></i>Search & Filter
                @php $activeFilters = count(array_filter(request()->only(['search', 'property_type', 'purpose', 'min_price', 'max_price']))); @endphp
                @if($activeFilters > 0)
                    <span class="badge bg-primary ms-1">{{ $activeFilters }}</span>
                @endif
            </button>
            <button type="button" id="btnSendBulkEmail" class="btn btn-admin-blue btn-sm px-3" style="display: none;">
                <i class="bi bi-envelope me-2"></i>Email Selected
            </button>
            <a href="{{ route('admin.available-properties.index', ['status' => request('status')]) }}"
                class="btn btn-outline-secondary btn-sm px-3 {{ $activeFilters > 0 ? '' : 'd-none' }}"
                title="Reset Filters">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
            </a>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="content-card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0" style="font-size: 0.82rem;">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4" style="width: 40px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllProperties">
                            </div>
                        </th>
                        <th style="width: 70px;">Media</th>
                        <th>Property Details</th>
                        @if(auth()->user()->role === 'admin')
                            <th>Listing By</th>
                        @endif
                        <th>Type/Purpose</th>
                        <th style="width: 130px;">Value</th>
                        <th>Status</th>
                        <th style="width: 140px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @foreach($properties as $property)
                        <tr>
                            <td class="ps-4">
                                <div class="form-check">
                                    <input class="form-check-input property-checkbox" type="checkbox"
                                        value="{{ $property->id }}">
                                </div>
                            </td>
                            <td>
                                @if($property->thumbnail)
                                    <img src="{{ Storage::url($property->thumbnail) }}" alt="Property" class="rounded shadow-sm"
                                        style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #eee;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center border"
                                        style="width: 50px; height: 50px;">
                                        <i class="bi bi-house text-muted fs-5"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ Str::limit($property->headline, 40) }}</div>
                                <div class="text-muted small"><i
                                        class="bi bi-geo-alt-fill me-1 text-danger opacity-75"></i>{{ Str::limit($property->location, 35) }}
                                </div>
                            </td>
                            @if(auth()->user()->role === 'admin')
                                <td>
                                    <div class="fw-600 text-blue small">{{ $property->owner->name ?? 'Admin' }}</div>
                                    <div class="text-muted tiny">{{ strtoupper($property->owner->role ?? 'Staff') }}</div>
                                </td>
                            @endif
                            <td>
                                <div class="mb-1">
                                    <span
                                        class="badge bg-info-subtle text-info border border-info-subtle rounded-pill font-weight-normal px-2 tiny">{{ $property->marketingPurpose->name ?? 'Unset' }}</span>
                                </div>
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill font-weight-normal px-2 tiny">{{ $property->propertyType->name ?? 'Unset' }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-pink">£{{ number_format($property->price, 0) }}</div>
                                @if($property->psg_fees > 0)
                                    <div class="tiny text-muted" style="font-size: 0.65rem;">+
                                        £{{ number_format($property->psg_fees, 0) }}</div>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.available-properties.update-status', $property->id) }}"
                                    method="POST" class="status-form">
                                    @csrf
                                    <select name="status"
                                        class="form-select form-select-sm fw-600 status-select text-dark shadow-none border-0 bg-light-subtle"
                                        style="min-width: 125px; font-size: 0.75rem; padding: 0.25rem 0.5rem;"
                                        onchange="this.form.submit()">
                                        @if(auth()->user()->role === 'admin')
                                            <option value="pending" {{ $property->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="approved" {{ $property->status == 'approved' ? 'selected' : '' }}>Approved
                                            </option>
                                            <option value="under offer" {{ $property->status == 'under offer' ? 'selected' : '' }}>
                                                Under Offer</option>
                                            <option value="disapproved" {{ $property->status == 'disapproved' ? 'selected' : '' }}>
                                                Disapproved</option>
                                            <option value="sold out" {{ $property->status == 'sold out' ? 'selected' : '' }}>Sold Out
                                            </option>
                                            <option value="draft" {{ $property->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                        @else
                                            <option value="pending" {{ $property->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="under offer" {{ $property->status == 'under offer' ? 'selected' : '' }}>
                                                Under Offer</option>
                                            <option value="sold out" {{ $property->status == 'sold out' ? 'selected' : '' }}>Sold Out
                                            </option>
                                            <option value="draft" {{ $property->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                            @if(!in_array($property->status, ['pending', 'sold out', 'under offer', 'draft']))
                                                <option value="{{ $property->status }}" selected disabled>
                                                    {{ ucfirst($property->status) }}</option>
                                            @endif
                                        @endif
                                    </select>
                                </form>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('available-properties.show', $property->id) }}"
                                        class="btn btn-sm btn-light border-0" title="View" target="_blank">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.available-properties.edit', $property->id) }}"
                                        class="btn btn-sm btn-light border-0" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-light border-0 text-warning btn-notify-agents"
                                        title="Notify" data-property-id="{{ $property->id }}"
                                        data-property-headline="{{ $property->headline }}">
                                        <i class="bi bi-megaphone"></i>
                                    </button>
                                    <a href="{{ route('admin.available-properties.insta-post', $property->id) }}"
                                        class="btn btn-sm btn-light border-0 text-danger" title="Insta Post" target="_blank">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.property-offers.index', $property->id) }}"
                                            class="btn btn-sm btn-light border-0" title="Offers">
                                            <i class="bi bi-currency-pound"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.available-properties.destroy', $property->id) }}"
                                        method="POST" class="d-inline" onsubmit="return confirm('Delete this property?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border-0 text-danger" title="Delete">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if($properties->count() == 0)
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-3">No available properties found.</p>
                                <a href="{{ route('admin.available-properties.create') }}" class="btn btn-admin-pink">
                                    <i class="bi bi-plus-lg me-2"></i>Add First Property
                                </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="mt-4">
            {{ $properties->links('pagination::bootstrap-5') }}
        </div>
    @endif
    <!-- Send Email Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-blue text-white">
                    <h5 class="modal-title"><i class="bi bi-envelope-paper me-2"></i>Send Property Deals</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="bulkEmailForm" action="{{ route('admin.available-properties.send-bulk-email') }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-600">Recipients:</label>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="emailAllAgents"
                                    name="send_to_all_agents" value="1">
                                <label class="form-check-label" for="emailAllAgents">All Agents</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="showSelectAgents">
                                <label class="form-check-label" for="showSelectAgents">Specific Agents</label>
                            </div>

                            <div id="selectAgentsDiv"
                                style="display: none; max-height: 150px; overflow-y: auto; margin-left: 25px; margin-bottom: 10px;">
                                @foreach($otherAgents as $agent)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input agent-email-checkbox" type="checkbox" name="agent_ids[]"
                                            value="{{ $agent->id }}" id="bulk_agent_{{ $agent->id }}">
                                        <label class="form-check-label small" for="bulk_agent_{{ $agent->id }}">
                                            {{ $agent->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <label class="form-label small fw-bold">Custom Email(s) (comma separated)</label>
                                <textarea name="custom_emails" id="customEmails" class="form-control" rows="2"
                                    placeholder="investor1@example.com, investor2@example.com"></textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Message (Optional)</label>
                            <textarea id="emailMessage" class="form-control" rows="3"
                                placeholder="Hello, check out these exclusive property deals..."></textarea>
                        </div>

                        <div id="emailPropertiesCount" class="small text-muted mb-3">
                            Sending <span id="selectedCountDisplay">0</span> selected properties.
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="btnSubmitEmail" class="btn btn-admin-pink py-2">
                                <span id="btnText">Send Deals Now</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm ms-2"
                                    style="display: none;"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Agent Notification Modal -->
    <div class="modal fade" id="notifyAgentsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-white text-start">
                    <h5 class="modal-title"><i class="bi bi-megaphone-fill me-2"></i>Notify Agents</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="notifyAgentsForm" method="POST">
                    @csrf
                    <div class="modal-body p-4 text-start">
                        <p class="small text-muted mb-3" id="notifyPropertyHeadline">Property: </p>
                        <label class="form-label fw-600 mb-2">Select Agents to Notify:</label>

                        <div class="mb-3 text-start">
                            <div class="form-check mb-2 pb-2 border-bottom">
                                <input class="form-check-input" type="checkbox" id="selectAllAgents">
                                <label class="form-check-label fw-bold" for="selectAllAgents">Select All Agents</label>
                            </div>
                            <div style="max-height: 250px; overflow-y: auto;">
                                @forelse($otherAgents as $agent)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input agent-checkbox" type="checkbox" name="agent_ids[]"
                                            value="{{ $agent->id }}" id="agent_{{ $agent->id }}">
                                        <label class="form-check-label" for="agent_{{ $agent->id }}">
                                            {{ $agent->name }} <span class="small text-muted">({{ $agent->email }})</span>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-center py-3 text-muted">No other agents found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-white px-4">Send Notifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Filter Modal -->
    <div class="modal fade" id="propertyFilterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('admin.available-properties.index') }}" method="GET">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold" id="filterModalLabel">Search & Filter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <!-- Keyword Search -->
                        <div class="mb-4">
                            <label class="form-label small fw-600 text-muted">Keyword Search</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-0"
                                    placeholder="Headline, area, or ID..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Property Type -->
                            <div class="col-6">
                                <label class="form-label small fw-600 text-muted">Property Type</label>
                                <select name="property_type"
                                    class="form-select form-select-sm bg-light border-0 shadow-none">
                                    <option value="">Any Type</option>
                                    @foreach($propertyTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('property_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Marketing Purpose -->
                            <div class="col-6">
                                <label class="form-label small fw-600 text-muted">Purpose</label>
                                <select name="purpose" class="form-select form-select-sm bg-light border-0 shadow-none">
                                    <option value="">Any Purpose</option>
                                    @foreach($marketingPurposes as $purpose)
                                        <option value="{{ $purpose->id }}" {{ request('purpose') == $purpose->id ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label small fw-600 text-muted">Price Range (£)</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="number" name="min_price"
                                    class="form-control form-control-sm bg-light border-0 text-center" placeholder="Min"
                                    value="{{ request('min_price') }}">
                                <span class="text-muted small">to</span>
                                <input type="number" name="max_price"
                                    class="form-control form-control-sm bg-light border-0 text-center" placeholder="Max"
                                    value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-4">
                        <a href="{{ route('admin.available-properties.index', ['status' => request('status')]) }}"
                            class="btn btn-link link-secondary text-decoration-none small">Clear All</a>
                        <button type="submit" class="btn btn-primary px-4 btn-sm rounded-pill">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAllProperties');
            const bulkBtn = document.getElementById('btnSendBulkEmail');
            const emailModalElem = document.getElementById('emailModal');
            let emailModalInstance = null;
            if (emailModalElem && typeof bootstrap !== 'undefined') emailModalInstance = new bootstrap.Modal(emailModalElem);

            const bulkEmailForm = document.getElementById('bulkEmailForm');
            const btnSubmitEmail = document.getElementById('btnSubmitEmail');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const selectedCountDisplay = document.getElementById('selectedCountDisplay');

            function updateBulkBtn() {
                const checkboxes = document.querySelectorAll('.property-checkbox:checked');
                const checkedCount = checkboxes.length;
                if (bulkBtn) bulkBtn.style.display = checkedCount > 0 ? 'inline-block' : 'none';
                if (selectedCountDisplay) selectedCountDisplay.textContent = checkedCount;
            }

            // Notify Agents Modal Logic
            const notifyBtns = document.querySelectorAll('.btn-notify-agents');
            const notifyModalElem = document.getElementById('notifyAgentsModal');
            let notifyModalInstance = null;
            if (notifyModalElem && typeof bootstrap !== 'undefined') notifyModalInstance = new bootstrap.Modal(notifyModalElem);

            const notifyForm = document.getElementById('notifyAgentsForm');
            const selectAllAgents = document.getElementById('selectAllAgents');
            const agentCheckboxes = document.querySelectorAll('.agent-checkbox');

            notifyBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const propId = this.dataset.propertyId;
                    const headline = this.dataset.propertyHeadline;

                    document.getElementById('notifyPropertyHeadline').textContent = 'Property: ' + headline;
                    notifyForm.action = `/admin/available-properties/${propId}/notify-agents`;

                    if (notifyModalInstance) notifyModalInstance.show();
                });
            });

            if (selectAllAgents) {
                selectAllAgents.addEventListener('change', function () {
                    agentCheckboxes.forEach(cb => cb.checked = this.checked);
                });
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    const checkboxes = document.querySelectorAll('.property-checkbox');
                    checkboxes.forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                    updateBulkBtn();
                });
            }

            // Using event delegation for checkboxes
            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('property-checkbox')) {
                    updateBulkBtn();

                    // Update checkAll state
                    if (selectAll) {
                        const allCheckboxes = document.querySelectorAll('.property-checkbox');
                        const allChecked = document.querySelectorAll('.property-checkbox:checked');
                        selectAll.checked = allCheckboxes.length === allChecked.length;
                    }
                }
            });

            if (bulkBtn) {
                bulkBtn.addEventListener('click', function () {
                    updateBulkBtn();
                    if (emailModalInstance) emailModalInstance.show();
                });
            }

            if (bulkEmailForm) {
                // Toggle Specific Agents
                const showSelectAgents = document.getElementById('showSelectAgents');
                const selectAgentsDiv = document.getElementById('selectAgentsDiv');
                if (showSelectAgents) {
                    showSelectAgents.addEventListener('change', function () {
                        selectAgentsDiv.style.display = this.checked ? 'block' : 'none';
                    });
                }

                bulkEmailForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    // Add property IDs from the main table checkboxes
                    const propertyIds = Array.from(document.querySelectorAll('.property-checkbox:checked')).map(cb => cb.value);
                    propertyIds.forEach(id => formData.append('property_ids[]', id));

                    if (propertyIds.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Properties Selected',
                            text: 'Please select at least one property from the list.'
                        });
                        return;
                    }

                    // Disable UI
                    btnSubmitEmail.disabled = true;
                    btnText.textContent = 'Sending...';
                    btnLoader.style.display = 'inline-block';

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                        .then(response => {
                            if (!response.ok) throw response;
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                if (emailModalInstance) emailModalInstance.hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: data.message,
                                    timer: 3000
                                });
                                bulkEmailForm.reset();
                                if (selectAgentsDiv) selectAgentsDiv.style.display = 'none';
                                document.querySelectorAll('.property-checkbox').forEach(cb => cb.checked = false);
                                if (selectAll) selectAll.checked = false;
                                updateBulkBtn();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: data.message
                                });
                            }
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to send emails. Please check the logs.'
                            });
                        })
                        .finally(() => {
                            // Re-enable UI
                            btnSubmitEmail.disabled = false;
                            btnText.textContent = 'Send Deals Now';
                            btnLoader.style.display = 'none';
                        });
                });
            }
        });
    </script>
@endsection