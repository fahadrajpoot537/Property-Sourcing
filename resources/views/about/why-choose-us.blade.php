@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="position-relative py-5 bg-blue text-white overflow-hidden" style="min-height: 450px;">
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=1920'); background-size: cover; background-position: center; opacity: 0.3;">
        </div>
        <div class="container position-relative z-1 py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="ps-4 border-start border-4 border-pink">
                        <h1 class="display-3 fw-bold mb-4">WHY CHOOSE US</h1>
                        <p class="lead opacity-90 fs-4 mb-4">
                            We like to think we're the simple choice when it comes to property investment.
                        </p>
                        <h3 class="fw-bold mb-5">Start your property portfolio today</h3>
                        <a href="{{ route('home') }}#contact"
                            class="btn btn-custom-pink px-5 py-3 rounded-pill fw-bold text-uppercase">Invest Today</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <!-- Decorative shape -->
                    <div class="bg-pink p-5 rounded-4 shadow-lg text-center" style="transform: rotate(5deg);">
                        <i class="bi bi-award text-white display-1"></i>
                        <h4 class="text-white fw-bold mt-3">UK'S LEADING SOURCE</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Grid Overlay -->
    <section class="py-4 bg-light shadow-sm position-relative" style="margin-top: -50px; z-index: 10;">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-center p-3">
                        <i class="bi bi-tags-fill text-pink fs-3 me-3"></i>
                        <span class="fw-bold text-blue">Large discounts on property</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-center p-3">
                        <i class="bi bi-shield-check text-pink fs-3 me-3"></i>
                        <span class="fw-bold text-blue">Completely transparent</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-center p-3">
                        <i class="bi bi-graph-up-arrow text-pink fs-3 me-3"></i>
                        <span class="fw-bold text-blue">Tailored opportunities</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-center p-3">
                        <i class="bi bi-check-all text-pink fs-3 me-3"></i>
                        <span class="fw-bold text-blue">We handle everything</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Why Section -->
    <section class="py-5 bg-white mt-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="display-6 fw-bold text-blue mb-4">WE'RE THAT INVESTMENT DECISION YOU WON'T REGRET</h2>
                    <p class="text-secondary lh-lg mb-4">
                        When your foundations are built on industry knowledge and experience, you can't help but be a
                        self-confident company.
                    </p>
                    <p class="text-secondary lh-lg mb-5">
                        Here at TPSG, we're headed up by a roster of industry experts who've got in excess of 50 years first
                        hand experience in doing BMV property deals, as well as packaging them up for investors.
                    </p>

                    <div class="accordion" id="whyAccordion">
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold text-blue" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#desc1">
                                    Discount Property (BMV)
                                </button>
                            </h2>
                            <div id="desc1" class="accordion-collapse collapse show" data-bs-parent="#whyAccordion">
                                <div class="accordion-body text-secondary">
                                    We specialize in finding properties significantly below market value, giving you instant
                                    equity from day one.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold text-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#desc2">
                                    Honest & Transparent
                                </button>
                            </h2>
                            <div id="desc2" class="accordion-collapse collapse" data-bs-parent="#whyAccordion">
                                <div class="accordion-body text-secondary">
                                    No hidden fees, no smoke and mirrors. Every detail of the deal is shared with you
                                    upfront.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold text-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#desc3">
                                    We Handle Everything
                                </button>
                            </h2>
                            <div id="desc3" class="accordion-collapse collapse" data-bs-parent="#whyAccordion">
                                <div class="accordion-body text-secondary">
                                    From sourcing to legal assistance and property management, we provide a complete
                                    end-to-end service.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800"
                            class="img-fluid rounded-4 shadow-lg" alt="Team meeting">
                        <div class="position-absolute bottom-0 start-0 bg-blue p-4 rounded-3 text-white shadow"
                            style="transform: translate(-10%, 20%);">
                            <h3 class="fw-bold mb-0">50+ Years</h3>
                            <p class="small mb-0">Combined Experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Numbers Section -->
    <section class="py-5 bg-light">
        <div class="container py-5 text-center text-md-start">
            <h2 class="display-6 fw-bold text-blue mb-5">THE NUMBERS SPEAK FOR THEMSELVES</h2>
            <div class="row g-5 text-center">
                <div class="col-md-4">
                    <div class="stat-item">
                        <h2 class="display-3 fw-bold text-blue mb-2">100+</h2>
                        <p class="text-secondary fw-bold text-uppercase">Properties Sold</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <h2 class="display-3 fw-bold text-blue mb-2">20</h2>
                        <p class="text-secondary fw-bold text-uppercase">Years of Experience</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <h2 class="display-3 fw-bold text-blue mb-2">100's</h2>
                        <p class="text-secondary fw-bold text-uppercase">Of happy investors</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="bg-blue text-white rounded-5 p-5 shadow-lg overflow-hidden position-relative">
                <div class="row align-items-center position-relative z-1">
                    <div class="col-lg-8">
                        <h2 class="display-5 fw-bold mb-3">Want to find out more?</h2>
                        <p class="lead opacity-75 mb-0">Our expert team is ready to help you build your dream property
                            portfolio.</p>
                    </div>
                    <div class="col-lg-4 text-center mt-4 mt-lg-0">
                        <a href="{{ route('home') }}#contact"
                            class="btn btn-custom-pink px-5 py-3 rounded-pill fw-bold text-uppercase">Contact Us Today</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection