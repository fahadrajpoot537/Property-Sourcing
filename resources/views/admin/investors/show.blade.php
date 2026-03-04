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
                <h6 class="fw-bold mb-4 border-bottom pb-2">Property Interests</h6>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @forelse(explode(', ', $investor->property_interests) as $interest)
                        @if(!empty($interest))
                            <span class="badge bg-blue px-3 py-2 fs-6 rounded-pill"><i
                                    class="bi bi-tag-fill me-2"></i>{{ $interest }}</span>
                        @endif
                    @empty
                        <p class="text-muted mb-0">No specific property interests recorded.</p>
                    @endforelse
                </div>

                <h6 class="fw-bold mb-3 border-bottom pb-2">Internal Notes</h6>
                <div class="bg-light p-3 rounded mb-5">
                    {!! nl2br(e($investor->notes ?? 'No additional notes provided.')) !!}
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                    <h6 class="fw-bold mb-0">Matching Properties</h6>
                    <span class="badge bg-success rounded-pill">{{ $matchedProperties->count() }} Matches Found</span>
                </div>

                @if($matchedProperties->count() > 0)
                    <div class="row g-4">
                        @foreach($matchedProperties as $property)
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                    <div class="position-relative">
                                        <img src="{{ Str::startsWith($property->thumbnail, 'http') ? $property->thumbnail : asset('storage/' . $property->thumbnail) }}" 
                                             class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $property->headline }}">
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <span class="badge bg-pink text-white">£{{ number_format($property->price) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold text-truncate mb-1">{{ $property->headline }}</h6>
                                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($property->location, 30) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-dark border small">{{ $property->investment_type }}</span>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('available-properties.show', $property->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                <button class="btn btn-sm btn-success" onclick="sendPropertyEmail('{{ $property->id }}', '{{ $investor->email }}')"><i class="bi bi-envelope"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 bg-light rounded">
                        <i class="bi bi-房屋-dash fs-1 text-muted opacity-25"></i>
                        <p class="text-muted mt-2">No properties currently match this investor's criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="sendPropertyModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="emailForm" action="{{ route('admin.available-properties.send-bulk-email') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-h5 fw-bold">Send Property to Investor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="small text-muted mb-4">You are about to send this property details to the investor via email.</p>
                        <input type="hidden" name="property_ids[]" id="modal_property_id">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">To:</label>
                            <input type="text" name="custom_emails" id="modal_email" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Message (Optional):</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Hello, I thought you might be interested in this deal..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-admin-blue">Send Email</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function sendPropertyEmail(propertyId, email) {
        if(!email || email === '') {
            alert('This investor does not have an email address.');
            return;
        }
        document.getElementById('modal_property_id').value = propertyId;
        document.getElementById('modal_email').value = email;
        var myModal = new bootstrap.Modal(document.getElementById('sendPropertyModal'));
        myModal.show();
    }
    </script>
@endsection