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

    <!-- Properties Table -->
    <div class="content-card">
        <div class="card-header">
            <h5><i class="bi bi-list-ul me-2"></i>All Available Properties</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllProperties">
                                </div>
                            </th>
                            <th style="width: 80px;">Thumbnail</th>
                            <th>Headline & Location</th>
                            @if(auth()->user()->role === 'admin')
                                <th>Posted By</th>
                            @endif
                            <th>Purpose</th>
                            <th>Type</th>
                            <th style="width: 120px;">Price</th>
                            <th>Status</th>
                            <th style="width: 150px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $property)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input property-checkbox" type="checkbox"
                                            value="{{ $property->id }}">
                                    </div>
                                </td>
                                <td>
                                    @if($property->thumbnail)
                                        <img src="{{ Storage::url($property->thumbnail) }}" alt="Property" class="rounded"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/60" alt="No Image" class="rounded"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $property->headline }}</div>
                                    <small class="text-muted"><i
                                            class="bi bi-geo-alt me-1"></i>{{ $property->location }}</small>
                                </td>
                                @if(auth()->user()->role === 'admin')
                                    <td>
                                        <div class="fw-600 text-blue">{{ $property->owner->name ?? 'Admin' }}</div>
                                        <small class="text-muted text-uppercase"
                                            style="font-size: 10px;">{{ $property->owner->role ?? 'Staff' }}</small>
                                    </td>
                                @endif
                                <td>
                                    <span
                                        class="badge badge-admin bg-info">{{ $property->marketingPurpose->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-admin bg-primary">{{ $property->propertyType->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="fw-600 text-pink">£{{ number_format($property->price, 2) }}</div>
                                </td>
                                <td>
                                    <form action="{{ route('admin.available-properties.update-status', $property->id) }}"
                                        method="POST" class="status-form">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm fw-600 status-select text-dark"
                                            style="min-width: 120px; background-color: #fff; border-color: #dee2e6;"
                                            onchange="this.form.submit()">
                                            @if(auth()->user()->role === 'admin')
                                                <option value="pending" {{ $property->status == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="approved" {{ $property->status == 'approved' ? 'selected' : '' }}>
                                                    Approved</option>
                                                <option value="under offer" {{ $property->status == 'under offer' ? 'selected' : '' }}>Under Offer</option>
                                                <option value="disapproved" {{ $property->status == 'disapproved' ? 'selected' : '' }}>Disapproved</option>
                                                <option value="sold out" {{ $property->status == 'sold out' ? 'selected' : '' }}>Sold
                                                    Out</option>
                                            @else
                                                <option value="pending" {{ $property->status == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="under offer" {{ $property->status == 'under offer' ? 'selected' : '' }}>Under Offer</option>
                                                <option value="sold out" {{ $property->status == 'sold out' ? 'selected' : '' }}>Sold
                                                    Out</option>
                                                @if(!in_array($property->status, ['pending', 'sold out', 'under offer']))
                                                    <option value="{{ $property->status }}" selected disabled>
                                                        {{ ucfirst($property->status) }}
                                                    </option>
                                                @endif
                                            @endif
                                        </select>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('available-properties.show', $property->id) }}"
                                            class="btn btn-sm btn-admin-edit" title="View" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.available-properties.edit', $property->id) }}"
                                            class="btn btn-sm btn-admin-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-warning text-white btn-notify-agents"
                                            title="Share with Agents" data-property-id="{{ $property->id }}"
                                            data-property-headline="{{ $property->headline }}">
                                            <i class="bi bi-megaphone-fill"></i>
                                        </button>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('admin.property-offers.index', $property->id) }}"
                                                class="btn btn-sm btn-info text-white" title="View Offers">
                                                <i class="bi bi-tag-fill"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.available-properties.destroy', $property->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this property?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-admin-delete" title="Delete">
                                                <i class="bi bi-trash"></i>
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
                    <form id="bulkEmailForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-600">Recipients:</label>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="emailAllAgents" name="send_to_all_agents" value="1">
                                <label class="form-check-label" for="emailAllAgents">All Agents</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="showSelectAgents">
                                <label class="form-check-label" for="showSelectAgents">Specific Agents</label>
                            </div>

                            <div id="selectAgentsDiv" style="display: none; max-height: 150px; overflow-y: auto; margin-left: 25px; margin-bottom: 10px;">
                                @foreach($otherAgents as $agent)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input agent-email-checkbox" type="checkbox" name="agent_ids[]" value="{{ $agent->id }}" id="bulk_agent_{{ $agent->id }}">
                                        <label class="form-check-label small" for="bulk_agent_{{ $agent->id }}">
                                            {{ $agent->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <label class="form-label small fw-bold">Custom Email(s) (comma separated)</label>
                                <textarea name="custom_emails" id="customEmails" class="form-control" rows="2" placeholder="investor1@example.com, investor2@example.com"></textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Message (Optional)</label>
                            <textarea id="emailMessage" class="form-control" rows="3" placeholder="Hello, check out these exclusive property deals..."></textarea>
                        </div>

                        <div id="emailPropertiesCount" class="small text-muted mb-3">
                            Sending <span id="selectedCountDisplay">0</span> selected properties.
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="btnSubmitEmail" class="btn btn-admin-pink py-2">
                                <span id="btnText">Send Deals Now</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
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
                if(showSelectAgents) {
                    showSelectAgents.addEventListener('change', function() {
                        selectAgentsDiv.style.display = this.checked ? 'block' : 'none';
                    });
                }

                bulkEmailForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const propertyIds = Array.from(document.querySelectorAll('.property-checkbox:checked')).map(cb => cb.value);
                    const agentIds = Array.from(document.querySelectorAll('.agent-email-checkbox:checked')).map(cb => cb.value);
                    const allAgents = document.getElementById('emailAllAgents').checked;
                    const customEmails = document.getElementById('customEmails').value;
                    const message = document.getElementById('emailMessage').value;

                    if (propertyIds.length === 0) {
                        alert('Please select at least one property.');
                        return;
                    }

                    if (!allAgents && agentIds.length === 0 && customEmails.trim() === '') {
                        alert('Please select at least one recipient.');
                        return;
                    }

                    // Disable UI
                    btnSubmitEmail.disabled = true;
                    btnText.textContent = 'Sending...';
                    btnLoader.style.display = 'inline-block';

                    fetch('{{ route("admin.available-properties.send-bulk-email") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            property_ids: propertyIds,
                            agent_ids: agentIds,
                            send_to_all_agents: allAgents,
                            custom_emails: customEmails,
                            message: message
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                if (emailModalInstance) emailModalInstance.hide();
                                bulkEmailForm.reset();
                                if(selectAgentsDiv) selectAgentsDiv.style.display = 'none';
                                document.querySelectorAll('.property-checkbox').forEach(cb => cb.checked = false);
                                if (selectAll) selectAll.checked = false;
                                updateBulkBtn();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while sending the email.');
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