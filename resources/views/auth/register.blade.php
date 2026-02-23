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

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">City</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-geo icon"></i>
                                            <input type="text" name="city" class="form-control" placeholder="London"
                                                value="{{ old('city') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Postal
                                            Address</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-house icon"></i>
                                            <input type="text" name="address" class="form-control"
                                                placeholder="123 Street Name" value="{{ old('address') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        <label
                                            class="form-label small fw-600 text-uppercase tracking-wider">Postcode</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-pin-map icon"></i>
                                            <input type="text" name="postcode" class="form-control" placeholder="SW1A 1AA"
                                                value="{{ old('postcode') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-7 mb-2" id="investment-section">
                                        <label class="form-label small fw-600 text-uppercase tracking-wider">Investment
                                            Interest</label>
                                        <div class="input-group-modern">
                                            <i class="bi bi-briefcase icon"></i>
                                            <select name="investment_type" id="investment_type" class="form-select">
                                                <option value="">Select Interest</option>
                                                <option value="buy_to_sell" {{ old('investment_type') == 'buy_to_sell' ? 'selected' : '' }}>Buy to Sell</option>
                                                <option value="rental" {{ old('investment_type') == 'rental' ? 'selected' : '' }}>Rental Property</option>
                                                <option value="bmv_deal" {{ old('investment_type') == 'bmv_deal' ? 'selected' : '' }}>BMV Deal</option>
                                                <option value="refurb_deal" {{ old('investment_type') == 'refurb_deal' ? 'selected' : '' }}>Refurb Deal</option>
                                                <option value="hmo" {{ old('investment_type') == 'hmo' ? 'selected' : '' }}>
                                                    HMO</option>
                                                <option value="btl" {{ old('investment_type') == 'btl' ? 'selected' : '' }}>
                                                    BTL (Buy to Let)</option>
                                                <option value="brr" {{ old('investment_type') == 'brr' ? 'selected' : '' }}>
                                                    BRR (Buy Refurb Refinance)</option>
                                                <option value="r2r" {{ old('investment_type') == 'r2r' ? 'selected' : '' }}>
                                                    R2R (Rent to Rent)</option>
                                                <option value="serviced_accommodation" {{ old('investment_type') == 'serviced_accommodation' ? 'selected' : '' }}>
                                                    Serviced Accommodation (SA)</option>
                                                <option value="Other" {{ old('investment_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role-select');
            const investmentSection = document.getElementById('investment-section');
            const investmentType = document.getElementById('investment_type');

            function toggleInvestmentField() {
                if (roleSelect.value === 'agent') {
                    investmentSection.style.display = 'none';
                    investmentType.removeAttribute('required');
                    investmentType.value = '';
                } else {
                    investmentSection.style.display = 'block';
                    investmentType.setAttribute('required', 'required');
                }
            }

            roleSelect.addEventListener('change', toggleInvestmentField);
            toggleInvestmentField(); // Initial state
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