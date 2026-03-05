@extends('layouts.admin')

@section('title', 'Investor Profile')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Investor: {{ $investor->name }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.investors.index') }}">Investors</a></li>
                        <li class="breadcrumb-item active">View Profile</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.investors.edit', $investor->id) }}" class="btn btn-admin-blue">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                </a>
                <a href="{{ route('admin.investors.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="content-card mb-4 text-center p-4">
                <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                    {{ substr($investor->name, 0, 1) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $investor->name }}</h4>
                <p class="text-muted small mb-3">Added on {{ $investor->created_at->format('d M Y') }}</p>
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $investor->email }}" class="btn btn-outline-blue btn-sm">
                        <i class="bi bi-envelope me-2"></i>Email Investor
                    </a>
                    <a href="tel:{{ $investor->phone }}" class="btn btn-outline-blue btn-sm">
                        <i class="bi bi-phone me-2"></i>Call Now
                    </a>
                </div>
            </div>

            <div class="content-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-pink"></i>Basic Information</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <small class="text-muted d-block">Email</small>
                        <span class="fw-600">{{ $investor->email ?? 'N/A' }}</span>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block">Phone</small>
                        <span class="fw-600">{{ $investor->phone ?? 'N/A' }}</span>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block">Budget Range</small>
                        <span class="fw-600 text-pink">
                            @if($investor->min_budget || $investor->max_budget)
                                £{{ number_format($investor->min_budget ?? 0) }} -
                                £{{ number_format($investor->max_budget ?? 0) }}
                            @else
                                £{{ number_format((float) preg_replace('/[^0-9.]/', '', $investor->budget)) }}
                            @endif
                        </span>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block">Location / Area</small>
                        <span class="fw-600">{{ $investor->location ?? 'Any' }}</span>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block">Bedrooms & Bathrooms</small>
                        <span class="fw-600">
                            Beds: {{ $investor->min_bedrooms ?? 'Any' }} - {{ $investor->max_bedrooms ?? 'Any' }} |
                            Baths: {{ $investor->min_bathrooms ?? 'Any' }} - {{ $investor->max_bathrooms ?? 'Any' }}
                        </span>
                    </li>
                    @if(auth()->user()->role === 'admin')
                        <li>
                            <small class="text-muted d-block">Managed By</small>
                            <span class="fw-600 text-pink">{{ $investor->agent->name ?? 'System' }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="content-card p-4 mb-4">
                <h6 class="fw-bold mb-4 border-bottom pb-2">Investment Preferences</h6>
                <div class="mb-4">
                    <div class="small text-muted mb-2">Investment Strategies</div>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @forelse($investor->deals_of_interest ?? [] as $deal)
                            <span class="badge bg-blue px-3 py-2 fs-6 rounded-pill">
                                <i class="bi bi-graph-up-arrow me-2"></i>{{ $deal }}
                            </span>
                        @empty
                            <span class="text-muted small">No strategies selected</span>
                        @endforelse
                    </div>

                    <div class="small text-muted mb-2">Property Types</div>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($investor->property_types ?? [] as $type)
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6 rounded-pill">
                                <i class="bi bi-house-door me-2"></i>{{ $type }}
                            </span>
                        @empty
                            <span class="text-muted small">No property types selected</span>
                        @endforelse
                    </div>
                </div>

                <h6 class="fw-bold mb-3 border-bottom pb-2">Internal Notes</h6>
                <div class="bg-light p-3 rounded mb-5">
                    {!! nl2br(e($investor->notes ?? 'No additional notes provided.')) !!}
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                    <h6 class="fw-bold mb-0">Matching Properties</h6>
                    <div class="d-flex align-items-center gap-3">
                            @if($matchedProperties->count() > 0)
                                <div class="form-check small">
                                    <input class="form-check-input" type="checkbox" id="selectAllMatches">
                                    <label class="form-check-label text-muted" for="selectAllMatches">Select All</label>
                                </div>
                                <button id="sendSelectedBtn" class="btn btn-admin-pink btn-sm d-none">
                                    <i class="bi bi-envelope-check me-1"></i>Send <span id="selectedCount">0</span> Selected
                                </button>
                            @endif
                            <span class="badge bg-success rounded-pill">{{ $matchedProperties->count() }} Matches Found</span>
                        </div>
                    </div>

                    @if($matchedProperties->count() > 0)
                        <div class="row g-4">
                            @foreach($matchedProperties as $property)
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-sm border-0 overflow-hidden position-relative">
                                        <div class="position-absolute top-0 start-0 p-2 z-3">
                                            <div class="form-check">
                                                <input class="form-check-input property-checkbox shadow" type="checkbox" value="{{ $property->id }}" style="width: 20px; height: 20px; cursor: pointer;">
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <img src="{{ Str::startsWith($property->thumbnail, 'http') ? $property->thumbnail : asset('storage/' . $property->thumbnail) }}"
                                                class="card-img-top" style="height: 180px; object-fit: cover;"
                                                alt="{{ $property->headline }}">
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <span class="badge bg-pink text-white">£{{ number_format($property->price) }}</span>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <h6 class="fw-bold text-truncate mb-1">{{ $property->headline }}</h6>
                                            <p class="text-muted small mb-2"><i
                                                    class="bi bi-geo-alt me-1"></i>{{ Str::limit($property->location, 30) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span
                                                    class="badge bg-light text-dark border small">{{ $property->investment_type }}</span>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('available-properties.show', $property->id) }}"
                                                        class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                    <button class="btn btn-sm btn-success"
                                                        onclick="sendSingleProperty('{{ $property->id }}')"><i
                                                            class="bi bi-envelope"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 bg-light rounded">
                            <i class="bi bi-house-dash fs-1 text-muted opacity-25"></i>
                            <p class="text-muted mt-2">No properties currently match this investor's criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Multi-Select Email Modal -->
        <div class="modal fade" id="multiSendModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="multiSendForm" action="{{ route('admin.available-properties.send-bulk-email') }}" method="POST">
                    @csrf
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-blue text-white">
                            <h5 class="modal-title"><i class="bi bi-envelope-paper me-2"></i>Send Property Deals</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" name="custom_emails" value="{{ $investor->email }}">
                            <div id="selectedPropsContainer"></div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Sending to:</label>
                                <input type="text" class="form-control bg-light" value="{{ $investor->email }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Message (Optional):</label>
                                <textarea name="message" class="form-control" rows="3"
                                    placeholder="Hello, I thought you might be interested in these matched deals..."></textarea>
                            </div>

                            <div class="small text-muted mb-3">
                                <i class="bi bi-info-circle me-1"></i> Sending <span class="selected-count-modal fw-bold">0</span> matched properties.
                            </div>

                            <div class="d-grid">
                                <button type="submit" id="btnSubmitMulti" class="btn btn-admin-pink py-2">
                                    <span class="btn-text">Send Deals Now</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const selectAll = document.getElementById('selectAllMatches');
                    const checkboxes = document.querySelectorAll('.property-checkbox');
                    const sendBtn = document.getElementById('sendSelectedBtn');
                    const selectCountSpan = document.getElementById('selectedCount');
                    const investorEmail = "{{ $investor->email }}";

                    function updateUI() {
                        const checked = document.querySelectorAll('.property-checkbox:checked').length;
                        if (sendBtn) {
                            if (checked > 0) {
                                sendBtn.classList.remove('d-none');
                                selectCountSpan.textContent = checked;
                            } else {
                                sendBtn.classList.add('d-none');
                            }
                        }
                    }

                    if (selectAll) {
                        selectAll.addEventListener('change', function() {
                            checkboxes.forEach(cb => cb.checked = this.checked);
                            updateUI();
                        });
                    }

                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', updateUI);
                    });

                    // Single send button handler
                    window.sendSingleProperty = function(id) {
                        if (!investorEmail) {
                            Swal.fire('Error', 'This investor has no email address.', 'error');
                            return;
                        }
                        // Clear other checkboxes and select only this one
                        checkboxes.forEach(cb => cb.checked = false);
                        const target = Array.from(checkboxes).find(cb => cb.value == id);
                        if (target) target.checked = true;
                        updateUI();
                        openModal();
                    };

                    function openModal() {
                        const checkedIds = Array.from(document.querySelectorAll('.property-checkbox:checked')).map(cb => cb.value);
                        const container = document.getElementById('selectedPropsContainer');
                        container.innerHTML = '';
                        checkedIds.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'property_ids[]';
                            input.value = id;
                            container.appendChild(input);
                        });
                        document.querySelector('.selected-count-modal').textContent = checkedIds.length;
                        new bootstrap.Modal(document.getElementById('multiSendModal')).show();
                    }

                    if (sendBtn) {
                        sendBtn.addEventListener('click', openModal);
                    }

                    // AJAX Form Submission
                    const multiForm = document.getElementById('multiSendForm');
                    multiForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const btn = document.getElementById('btnSubmitMulti');
                        const btnText = btn.querySelector('.btn-text');
                        const loader = btn.querySelector('.spinner-border');

                        // Disable UI
                        btn.disabled = true;
                        btnText.textContent = 'Sending...';
                        loader.classList.remove('d-none');

                        fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: new FormData(this)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                bootstrap.Modal.getInstance(document.getElementById('multiSendModal')).hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sent!',
                                    text: data.message,
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                                // Reset selection
                                checkboxes.forEach(cb => cb.checked = false);
                                if (selectAll) selectAll.checked = false;
                                updateUI();
                            } else {
                                Swal.fire('Failed', data.message || 'Something went wrong', 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Error', 'Failed to connect to server', 'error');
                        })
                        .finally(() => {
                            btn.disabled = false;
                            btnText.textContent = 'Send Deals Now';
                            loader.classList.add('d-none');
                        });
                    });
                });
            </script>
        @endpush
@endsection