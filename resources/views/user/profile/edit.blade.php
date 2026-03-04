@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 fw-bold text-blue">Edit Profile</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <h5 class="fw-bold text-muted mb-3">Basic Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            value="{{ old('phone_number', $user->phone_number ?? $user->phone) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold text-muted mb-3">Address Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="address_line1" class="form-label">Address Line 1</label>
                                        <input type="text" class="form-control" id="address_line1" name="address_line1"
                                            value="{{ old('address_line1', $user->address_line1 ?? $user->address) }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="address_line2" class="form-label">Address Line 2 (Optional)</label>
                                        <input type="text" class="form-control" id="address_line2" name="address_line2"
                                            value="{{ old('address_line2', $user->address_line2) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="{{ old('city', $user->city) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="postcode" class="form-label">Postcode</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode"
                                            value="{{ old('postcode', $user->postcode) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control" id="country" name="country"
                                            value="{{ old('country', $user->country) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold text-muted mb-3">Company Information (Optional)</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            value="{{ old('company_name', $user->company_name) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_registration" class="form-label">Company Registration
                                            No.</label>
                                        <input type="text" class="form-control" id="company_registration"
                                            name="company_registration"
                                            value="{{ old('company_registration', $user->company_registration) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold text-muted mb-3">Investment Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="budget" class="form-label">Budget (£)</label>
                                        <input type="number" class="form-control" id="budget" name="budget"
                                            value="{{ old('budget', $user->budget) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Property Types of Interest</label>
                                        <div class="row g-2">
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
                                                $userInterests = explode(', ', $user->property_interests ?? '');
                                            @endphp
                                            @foreach($interests as $key => $label)
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check small text-muted">
                                                        <input class="form-check-input" type="checkbox" name="property_interests[]" 
                                                            value="{{ $key }}" id="interest_{{ $key }}" 
                                                            {{ in_array($key, $userInterests) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="interest_{{ $key }}">{{ $label }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold text-muted mb-3">About Me</h5>
                                <textarea class="form-control" id="about_me" name="about_me"
                                    rows="4">{{ old('about_me', $user->about_me) }}</textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom-pink fw-bold py-2">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection