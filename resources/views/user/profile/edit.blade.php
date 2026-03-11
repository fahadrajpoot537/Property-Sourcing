@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --accent-color: #4cc9f0;
            --card-border-radius: 24px;
            --input-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
        }

        .profile-header-card {
            border: none;
            border-radius: var(--card-border-radius);
            background: var(--primary-gradient);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.15);
        }

        .profile-header-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .profile-avatar-container {
            position: relative;
            display: inline-block;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 40px;
            object-fit: cover;
            border: 6px solid rgba(255, 255, 255, 0.2);
            padding: 4px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .upload-btn {
            position: absolute;
            bottom: -10px;
            right: -10px;
            background: #fff;
            color: #4361ee;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .upload-btn:hover {
            transform: scale(1.1) rotate(5deg);
            color: #3a0ca3;
        }

        .glass-card {
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .nav-pills-custom .nav-link {
            color: #64748b;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px 20px;
            transition: all 0.3s ease;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-pills-custom .nav-link i {
            font-size: 1.2rem;
            opacity: 0.7;
        }

        .nav-pills-custom .nav-link.active {
            background: #eff6ff;
            color: #4361ee;
        }

        .nav-pills-custom .nav-link.active i {
            opacity: 1;
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border-radius: 14px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            background-color: var(--input-bg);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #4361ee;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .interest-pill {
            display: none;
        }

        .interest-label {
            display: block;
            padding: 10px 16px;
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 100%;
            text-align: center;
        }

        .interest-pill:checked + .interest-label {
            background: #eff6ff;
            border-color: #4361ee;
            color: #4361ee;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.1);
        }

        .btn-save {
            padding: 14px 32px;
            border-radius: 16px;
            font-weight: 700;
            background: var(--primary-gradient);
            border: none;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.2);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(67, 97, 238, 0.3);
        }

        .info-badge {
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            backdrop-filter: blur(4px);
        }

    </style>

    <div class="container py-4">
        <!-- Header -->
        <div class="card profile-header-card p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-auto">
                    <div class="profile-avatar-container">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('admin/assets/img/avatars/1.png') }}" 
                             id="header_preview" class="profile-avatar">
                        <label for="profile_picture" class="upload-btn">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <h2 class="text-white fw-bold mb-0">{{ $user->name }}</h2>
                        <span class="info-badge fw-bold">{{ strtoupper($user->role) }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-3 text-white border-top border-white border-opacity-25 pt-3">
                        <div class="d-flex align-items-center gap-2 opacity-90 small">
                            <i class="bi bi-envelope"></i> {{ $user->email }}
                        </div>
                        @if($user->phone_number || $user->phone)
                            <div class="d-flex align-items-center gap-2 opacity-90 small">
                                <i class="bi bi-telephone"></i> {{ $user->phone_number ?? $user->phone }}
                            </div>
                        @endif
                        <div class="d-flex align-items-center gap-2 opacity-90 small">
                            <i class="bi bi-calendar-check"></i> Member since {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 py-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                    <div class="fw-bold">{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="file" name="profile_picture" id="profile_picture" class="d-none" onchange="previewImage(this)">

            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3">
                    <div class="glass-card p-3 sticky-top" style="top: 20px;">
                        <nav class="nav flex-column nav-pills-custom" id="profile-tabs" role="tablist">
                            <a class="nav-link active shadow-sm" id="basic-tab" data-bs-toggle="pill" href="#basic-info" role="tab">
                                <i class="bi bi-person-circle"></i> Basic Info
                            </a>
                            <a class="nav-link shadow-sm" id="address-tab" data-bs-toggle="pill" href="#address-info" role="tab">
                                <i class="bi bi-geo-alt"></i> Address
                            </a>
                            <a class="nav-link shadow-sm" id="investment-tab" data-bs-toggle="pill" href="#investment-info" role="tab">
                                <i class="bi bi-currency-pound"></i> Investment
                            </a>
                            <a class="nav-link shadow-sm" id="company-tab" data-bs-toggle="pill" href="#company-info" role="tab">
                                <i class="bi bi-building"></i> Company
                            </a>
                            <a class="nav-link shadow-sm" id="bio-tab" data-bs-toggle="pill" href="#bio-info" role="tab">
                                <i class="bi bi-journal-text"></i> Personal Bio
                            </a>
                        </nav>
                        <hr class="text-muted opacity-25">
                        <div class="d-grid px-2">
                            <button type="submit" class="btn btn-save">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="tab-content glass-card p-4 p-md-5" id="profile-tabsContent">

                        <!-- Basic Info -->
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                            <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <span class="p-2 bg-primary bg-opacity-10 text-primary rounded-3"><i class="bi bi-person"></i></span>
                                Personal Details
                            </h4>
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Full Display Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $user->name) }}" required placeholder="Enter your full name">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone_number" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" 
                                           value="{{ old('phone_number', $user->phone_number ?? $user->phone) }}" placeholder="+44 123 456789">
                                </div>
                            </div>
                        </div>

                        <!-- Address Info -->
                        <div class="tab-pane fade" id="address-info" role="tabpanel">
                            <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <span class="p-2 bg-success bg-opacity-10 text-success rounded-3"><i class="bi bi-geo-alt"></i></span>
                                Where you're located
                            </h4>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="address_line1" class="form-label">Primary Address Line</label>
                                    <input type="text" class="form-control" id="address_line1" name="address_line1" 
                                           value="{{ old('address_line1', $user->address_line1 ?? $user->address) }}">
                                </div>
                                <div class="col-12">
                                    <label for="address_line2" class="form-label">Secondary Line (Optional)</label>
                                    <input type="text" class="form-control" id="address_line2" name="address_line2" 
                                           value="{{ old('address_line2', $user->address_line2) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" 
                                           value="{{ old('city', $user->city) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="postcode" class="form-label">Post Code</label>
                                    <input type="text" class="form-control" id="postcode" name="postcode" 
                                           value="{{ old('postcode', $user->postcode) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country" 
                                           value="{{ old('country', $user->country) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Investment Info -->
                        <div class="tab-pane fade" id="investment-info" role="tabpanel">
                            <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <span class="p-2 bg-warning bg-opacity-10 text-warning rounded-3"><i class="bi bi-cash-stack"></i></span>
                                Investment Profile
                            </h4>
                            <div class="row g-4 mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4 border border-warning-subtle">
                                        <div>
                                            <h6 class="fw-bold mb-1">Cash Buyer Status</h6>
                                            <p class="text-muted small mb-0">Toggle this if you are a verified cash buyer</p>
                                        </div>
                                        <div class="form-check form-switch fs-4">
                                            <input class="form-check-input" type="checkbox" name="is_cash_buy" id="is_cash_buy" value="1" 
                                                   {{ old('is_cash_buy', $user->is_cash_buy) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="min_budget" class="form-label">Minimum Budget (£)</label>
                                    <input type="number" class="form-control" id="min_budget" name="min_budget" 
                                           value="{{ old('min_budget', $user->min_budget) }}" placeholder="e.g. 50000">
                                </div>
                                <div class="col-md-6">
                                    <label for="max_budget" class="form-label">Maximum Budget (£)</label>
                                    <input type="number" class="form-control" id="max_budget" name="max_budget" 
                                           value="{{ old('max_budget', $user->max_budget) }}" placeholder="e.g. 1000000">
                                </div>
                            </div>

                            <label class="form-label mb-3">Property Interests</label>
                            <div class="row g-3">
                                @php
                                    $interests = [
                                        'BMV' => 'Below Market Value',
                                        'HMO' => 'Houses in Multiple Occupation',
                                        'Land' => 'Development Land',
                                        'BTL' => 'Buy to Let',
                                        'Commercial' => 'Commercial',
                                        'Distressed' => 'Distressed Sale',
                                        'R2R' => 'Rent to Rent',
                                        'SA' => 'Serviced Accom.',
                                        'Auction' => 'Auction Properties',
                                    ];
                                    $userInterests = explode(', ', $user->property_interests ?? '');
                                @endphp
                                @foreach($interests as $key => $label)
                                    <div class="col-md-4">
                                        <input type="checkbox" name="property_interests[]" value="{{ $key }}" 
                                               id="interest_{{ $key }}" class="interest-pill"
                                               {{ in_array($key, $userInterests) ? 'checked' : '' }}>
                                        <label class="interest-label" for="interest_{{ $key }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Company Info -->
                        <div class="tab-pane fade" id="company-info" role="tabpanel">
                            <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <span class="p-2 bg-info bg-opacity-10 text-info rounded-3"><i class="bi bi-briefcase"></i></span>
                                Corporate Information
                            </h4>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="company_name" class="form-label">Registered Business Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" 
                                           value="{{ old('company_name', $user->company_name) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="company_registration" class="form-label">Registration Number</label>
                                    <input type="text" class="form-control" id="company_registration" name="company_registration" 
                                           value="{{ old('company_registration', $user->company_registration) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Bio Info -->
                        <div class="tab-pane fade" id="bio-info" role="tabpanel">
                            <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <span class="p-2 bg-secondary bg-opacity-10 text-secondary rounded-3"><i class="bi bi-pencil-square"></i></span>
                                Profile Bio
                            </h4>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="about_me" class="form-label">About your background</label>
                                    <textarea class="form-control" id="about_me" name="about_me" rows="8" 
                                              placeholder="Tell agents about your investment journey...">{{ old('about_me', $user->about_me) }}</textarea>
                                    <div class="mt-2 text-muted small"><i class="bi bi-info-circle me-1"></i> This information helps agents find the best properties for you.</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Update both previews if they exist
                    if(document.getElementById('header_preview')) {
                        document.getElementById('header_preview').src = e.target.result;
                    }
                    if(document.getElementById('profile_preview')) {
                        document.getElementById('profile_preview').src = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Auto switch to first tab with errors if validation fails (optional enhancement)
        document.addEventListener('DOMContentLoaded', function() {
            var firstError = document.querySelector('.is-invalid');
            if (firstError) {
                var tabId = firstError.closest('.tab-pane').id;
                var tabTrigger = new bootstrap.Tab(document.querySelector('a[href="#' + tabId + '"]'));
                tabTrigger.show();
            }
        });
    </script>
@endsection