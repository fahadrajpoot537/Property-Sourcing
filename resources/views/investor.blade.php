@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 position-relative text-white"
        style="background: linear-gradient(rgba(30, 64, 114, 0.9), rgba(30, 64, 114, 0.9)), url('https://images.unsplash.com/photo-1554224155-1696413575b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'); background-size: cover; background-position: center; min-height: 400px;">
        <div class="container py-5 text-center">
            <h1 class="display-3 fw-bold mb-4">JOIN OUR PROPERTY INVESTOR'S DATABASE</h1>
            <p class="lead mb-0 mx-auto" style="max-width: 800px;">Joining our property database is a MUST for any
                eagle-eyed investor. Why? Because it means we’ll keep you posted on all our latest investment deals.
                Membership is FREE and comes with no obligation, so there’s no reason not to get started!</p>
        </div>
    </section>

    <!-- Main Content & Form -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Left Content: Benefits -->
                <div class="col-lg-7">
                    <h2 class="fw-bold text-blue mb-4">Build Your Property Portfolio Today!</h2>
                    <p class="text-muted mb-5">We offer a wide range of investment opportunities tailored to your needs.
                        From BMV properties to high-yield student lets, we have it all.</p>

                    <div class="row g-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill text-pink me-3 fs-4"></i>
                                <h5 class="fw-bold mb-0">High Yield (%)</h5>
                            </div>
                            <p class="text-muted small">Maximized returns through careful property selection.</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill text-pink me-3 fs-4"></i>
                                <h5 class="fw-bold mb-0">Completely Transparent</h5>
                            </div>
                            <p class="text-muted small">No hidden fees, just clear property data.</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill text-pink me-3 fs-4"></i>
                                <h5 class="fw-bold mb-0">Dedicated Contact</h5>
                            </div>
                            <p class="text-muted small">A personal account manager for your journey.</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill text-pink me-3 fs-4"></i>
                                <h5 class="fw-bold mb-0">Significant Discounts</h5>
                            </div>
                            <p class="text-muted small">Exclusive BMV deals you won't find anywhere else.</p>
                        </div>
                    </div>

                    <hr class="my-5 opacity-10">

                    <h4 class="fw-bold text-blue mb-4">The types of deals we source:</h4>
                    <ul class="list-unstyled row gy-3">
                        <li class="col-md-6 d-flex align-items-center"><i
                                class="bi bi-arrow-right-short text-pink fs-4 me-2"></i> BMV Property</li>
                        <li class="col-md-6 d-flex align-items-center"><i
                                class="bi bi-arrow-right-short text-pink fs-4 me-2"></i> Buy To Let</li>
                        <li class="col-md-6 d-flex align-items-center"><i
                                class="bi bi-arrow-right-short text-pink fs-4 me-2"></i> Property To Renovate</li>
                        <li class="col-md-6 d-flex align-items-center"><i
                                class="bi bi-arrow-right-short text-pink fs-4 me-2"></i> Student Property</li>
                        <li class="col-md-12 d-flex align-items-center"><i
                                class="bi bi-arrow-right-short text-pink fs-4 me-2"></i> Commercial Property Investment</li>
                    </ul>
                </div>

                <!-- Right Content: Form -->
                <div class="col-lg-5">
                    <div class="bg-blue p-4 p-md-5 rounded-4 text-white shadow-lg sticky-top"
                        style="top: 100px; z-index: 999;">
                        <h3 class="fw-bold text-center mb-4">Sign Up For DEALS</h3>
                        <p class="text-center small opacity-75 mb-4">Complete the form below to receive exclusive property
                            investment opportunities directly to your inbox.</p>

                        <form action="{{ route('inquiry.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="investor">
                            <input type="hidden" name="source_page" value="Become Property Investor Page">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white-50">FULL NAME*</label>
                                <input type="text" name="name"
                                    class="form-control bg-transparent text-white border-white-50 investor-form-input"
                                    placeholder="Your Full Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white-50">EMAIL ADDRESS*</label>
                                <input type="email" name="email"
                                    class="form-control bg-transparent text-white border-white-50 investor-form-input"
                                    placeholder="Your Email Address" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white-50">PHONE NUMBER*</label>
                                <input type="tel" name="phone"
                                    class="form-control bg-transparent text-white border-white-50 investor-form-input"
                                    placeholder="Your Phone Number" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white-50">WHEN ARE YOU READY TO BUY?*</label>
                                <select name="ready_to_buy"
                                    class="form-select bg-transparent text-white border-white-50 investor-form-input appearance-none"
                                    required>
                                    <option value="" class="text-dark">Please Select</option>
                                    <option value="Immediately" class="text-dark">Immediately</option>
                                    <option value="1-3 Months" class="text-dark">Within 1-3 Months</option>
                                    <option value="3-6 Months" class="text-dark">Within 3-6 Months</option>
                                    <option value="Just Researching" class="text-dark">Just Researching</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white-50">ARE YOU A CASH BUYER?*</label>
                                <select name="is_cash_buyer"
                                    class="form-select bg-transparent text-white border-white-50 investor-form-input appearance-none"
                                    required>
                                    <option value="" class="text-dark">Please Select</option>
                                    <option value="Yes" class="text-dark">Yes</option>
                                    <option value="No" class="text-dark">No</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white-50">WHAT IS YOUR BUDGET?*</label>
                                <input type="text" name="budget"
                                    class="form-control bg-transparent text-white border-white-50 investor-form-input"
                                    placeholder="e.g. £100,000 - £200,000" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-white-50">WHAT TYPE OF INVESTMENTS ARE YOU
                                    INTERESTED IN?*</label>
                                <select name="investment_type"
                                    class="form-select bg-transparent text-white border-white-50 investor-form-input appearance-none"
                                    required>
                                    <option value="" class="text-dark">Please Select</option>
                                    <option value="Buy to let" class="text-dark">Buy to let</option>
                                    <option value="Professional HMO" class="text-dark">Professional HMO</option>
                                    <option value="Social Housing" class="text-dark">Social Housing</option>
                                    <option value="Other" class="text-dark">Other</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-custom-pink w-100 py-3 fw-bold fs-5">JOIN THE LIST
                                NOW!</button>
                        </form>
                        <p class="text-center mt-3 smaller opacity-50 mb-0">By clicking join you agree to our privacy
                            policy.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .investor-form-input::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        .investor-form-input:focus {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: var(--primary-pink) !important;
            box-shadow: none !important;
            color: white !important;
        }

        .appearance-none {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
    </style>
@endsection