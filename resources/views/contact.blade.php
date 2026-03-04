@extends('layouts.app')

@section('content')
    <!-- Hero/Contact Section -->
    <section class="py-5 bg-blue text-white overflow-hidden">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <!-- Image Side -->
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&q=80&w=800"
                            class="img-fluid rounded-4 shadow-lg" alt="Team Meeting">
                        <div
                            class="position-absolute bottom-0 start-0 m-4 bg-pink p-3 rounded-4 shadow-sm d-none d-md-block">
                            <p class="mb-0 fw-bold small text-white">UK Wide Property Experts</p>
                        </div>
                    </div>
                </div>

                <!-- Content Side -->
                <div class="col-lg-6">
                    <div class="ps-lg-5">
                        <div class="border-start border-4 border-pink ps-4 mb-4">
                            <h1 class="display-4 fw-black text-uppercase mb-0">Contact Us</h1>
                        </div>

                        <p class="fst-italic fs-5 text-pink-light mb-4 text-pink">Want to grow your portfolio with us?</p>

                        <div class="text-white-50 lh-lg mb-5">
                            <p>We're a friendly bunch, so don't be shy. Reach out today to see how we can help you achieve
                                your property ambitions and buy your next investment for Below Market Value.</p>
                            <p>We'll be back in touch real fast!</p>
                        </div>

                        <div class="contact-info-list d-grid gap-3 mb-5">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-pink-soft p-2 rounded-circle">
                                    <i class="bi bi-geo-alt-fill text-pink fs-4"></i>
                                </div>
                                <span class="fs-5 fw-bold">57 Hallsville Rd, London, United Kingdom, E16 1EE </span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-pink-soft p-2 rounded-circle">
                                    <i class="bi bi-telephone-fill text-pink fs-4"></i>
                                </div>
                                <span class="fs-5 fw-bold">0203 468 0480</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-pink-soft p-2 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <img src="{{ asset('ph.png') }}" alt="Phone" class="pink-icon"
                                        style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <span class="fs-5 fw-bold">+44 203 411 3603</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-pink-soft p-2 rounded-circle">
                                    <i class="bi bi-clock-fill text-pink fs-4"></i>
                                </div>
                                <span class="fs-5 fw-bold">Open 24/7</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-pink-soft p-2 rounded-circle">
                                    <i class="bi bi-envelope-fill text-pink fs-4"></i>
                                </div>
                                <span class="fs-5 fw-bold">info@propertysourcinggroup.co.uk</span>
                            </div>
                        </div>

                        <a href="#invest-form"
                            class="btn btn-custom-pink px-5 py-3 rounded-pill fw-bold text-uppercase fs-5">Invest today</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Icon Features Bar -->
    <section class="py-5 bg-blue border-top border-light border-opacity-10">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-graph-up-arrow text-pink fs-1"></i>
                        <p class="mb-0 fw-bold text-white text-start">Large discounts<br>on property</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-shield-check text-pink fs-1"></i>
                        <p class="mb-0 fw-bold text-white text-start">Completely<br>transparent</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-briefcase-fill text-pink fs-1"></i>
                        <p class="mb-0 fw-bold text-white text-start">Tailored investment<br>opportunities</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="bi bi-hand-thumbs-up-fill text-pink fs-1"></i>
                        <p class="mb-0 fw-bold text-white text-start">We'll handle<br>everything for you</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="p-0">
        <div class="ratio ratio-21x9">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.546416!2d0.0336!3d51.528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTEuNTI4JyBOLCAwLjAzMzYnIEU!5e0!3m2!1sen!2suk!4v1700000000000!5m2!1sen!2suk"
                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>

    <style>
        .fw-black {
            font-weight: 900;
        }

        .bg-pink-soft {
            background-color: rgba(249, 92, 168, 0.15);
        }

        .text-pink-light {
            color: #f9aecb;
        }
    </style>
@endsection