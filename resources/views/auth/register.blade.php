@extends('layouts.app')

@section('content')
    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="register-container shadow-lg">
                    <div class="row g-0">
                        <!-- Left Side: Decorative/Information -->
                        <div class="col-lg-5 d-none d-lg-flex register-hero"
                            style="background: linear-gradient(rgba(30, 64, 114, 0.9), rgba(30, 64, 114, 0.9)), url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;">
                            <div class="p-5 text-white w-100">
                                <h2 class="display-5 fw-bold mb-4">Join the Group</h2>
                                <p class="lead mb-5 opacity-75">Connect with the UK's leading property sourcing community
                                    and
                                    get access to exclusive deals.</p>

                                <div class="benefit-item mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="benefit-icon me-3">
                                            <i class="bi bi-shield-check"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Verified Deals</h5>
                                            <p class="small opacity-50 mb-0">Every property is vetted by our experts.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="benefit-item mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="benefit-icon me-3">
                                            <i class="bi bi-graph-up-arrow"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">High ROI</h5>
                                            <p class="small opacity-50 mb-0">Maximized returns for our investors.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="benefit-item mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="benefit-icon me-3">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Expert Support</h5>
                                            <p class="small opacity-50 mb-0">Personal guidance throughout your journey.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Form -->
                        <div class="col-lg-7 bg-white p-4 p-md-5">
                            <div class="text-center mb-5 d-lg-none">
                                <h2 class="fw-bold text-blue">Create an Account</h2>
                                <p class="text-muted small">Join Property Sourcing Group today</p>
                            </div>

                            <div class="mb-4 d-none d-lg-block">
                                <h3 class="fw-bold text-blue mb-1">Getting Started</h3>
                                <p class="text-muted small">Please fill in your details to create an account.</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm small py-2 mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('register.submit') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12 mb-2">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Join As</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-person-check icon"></i>
                                            <select name="role" id="role-select" class="form-select" required>
                                                <option value="user" {{ (old('role') ?? request('role')) == 'user' ? 'selected' : '' }}>Investor
                                                </option>
                                                <option value="agent" {{ (old('role') ?? request('role')) == 'agent' ? 'selected' : '' }}>Agent
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Full
                                            Name</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-person icon"></i>
                                            <input type="text" name="name" class="form-control" placeholder="John Doe"
                                                value="{{ old('name') }}" required autofocus>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Email
                                            Address</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-envelope icon"></i>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="john@example.com" value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Phone
                                            Number</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-telephone icon"></i>
                                            <input type="text" name="phone" class="form-control" placeholder="07123 456789"
                                                value="{{ old('phone') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Location (Search City/Area)</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-geo icon"></i>
                                            <input type="text" id="location-input" name="location" class="form-control" placeholder="Search UK location..." 
                                                value="{{ old('location') }}" required>
                                        </div>
                                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                                    </div>

                                    <div class="col-md-6 mb-2 investor-only">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Budget (£)</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-wallet icon"></i>
                                            <input type="number" name="budget" class="form-control" placeholder="e.g. 500000"
                                                value="{{ old('budget') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2 investor-only">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Property Types of Interest</label>
                                        <div class="row g-2 mt-1">
                                            @php
                                                $interests = [
                                                    'BMV' => 'BMV',
                                                    'HMO' => 'HMO',
                                                    'Development Land' => 'Development Land',
                                                    'Buy to Let' => 'Buy to Let',
                                                    'Commercial' => 'Commercial',
                                                    'Distressed Properties' => 'Distressed Properties',
                                                    'Rent to Rent' => 'Rent to Rent',
                                                    'SA' => 'SA (Serviced Accommodation)',
                                                    'Auction Properties' => 'Auction Properties',
                                                ];
                                            @endphp
                                            @foreach($interests as $key => $label)
                                                <div class="col-md-6">
                                                    <div class="form-check small text-muted">
                                                        <input class="form-check-input" type="checkbox" name="property_interests[]" 
                                                            value="{{ $key }}" id="interest_{{ $key }}" 
                                                            {{ is_array(old('property_interests')) && in_array($key, old('property_interests')) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="interest_{{ $key }}">{{ $label }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label
                                            class="form-label small fw-600 text-uppercase tracking-wider">Password</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-lock icon"></i>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="••••••••" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Confirm
                                            Password</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-lock-fill icon"></i>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="••••••••" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-custom-pink w-100 py-3 mb-4 rounded-3 fs-5">
                                    Create My Account <i class="bi bi-arrow-right ms-2"></i>
                                </button>

                                <div class="text-center">
                                    <p class="text-muted small">Already have an account?
                                        <a href="{{ route('login') }}" class="text-pink fw-bold text-decoration-none">Sign
                                            In Here</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI&libraries=places"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role-select');
            const investorFields = document.querySelectorAll('.investor-only');

            function toggleInvestorFields() {
                if (roleSelect.value === 'agent') {
                    investorFields.forEach(el => el.style.display = 'none');
                } else {
                    investorFields.forEach(el => el.style.display = 'block');
                }
            }

            roleSelect.addEventListener('change', toggleInvestorFields);
            toggleInvestorFields();

            const input = document.getElementById("location-input");
            const autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: { country: "gb" },
                fields: ["geometry"]
            });

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    document.getElementById("latitude").value = place.geometry.location.lat();
                    document.getElementById("longitude").value = place.geometry.location.lng();
                }
            });
        });
    </script>

    <style>
        .register-container {
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
        }

        .benefit-icon {
            width: 45px;
            height: 45px;
            background: rgba(249, 92, 168, 0.2);
            color: var(--primary-pink);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.25rem;
        }

        .benefit-item h5 {
            font-size: 1.1rem;
            color: #fff;
        }

        .input-group-modern {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-modern .icon {
            position: absolute;
            left: 15px;
            color: #adb5bd;
            font-size: 1.1rem;
            z-index: 5;
        }

        .input-group-modern .form-control,
        .input-group-modern .form-select {
            padding-left: 45px;
            height: 50px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .input-group-modern .form-control:focus,
        .input-group-modern .form-select:focus {
            background-color: #fff;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 4px rgba(249, 92, 168, 0.1);
        }

        .input-group-modern .form-control::placeholder {
            color: #ced4da;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        .fw-600 {
            font-weight: 600;
        }

        .register-hero {
            display: flex;
            align-items: center;
        }

        @media (max-width: 991.98px) {
            .register-container {
                border-radius: 15px;
            }
        }
    </style>
@endsection