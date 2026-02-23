@extends('layouts.app')

@section('content')
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0 rounded-0 text-center" role="alert">
            <div class="container">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Hero Section (Layout from Image) -->
    <section class="py-5 position-relative"
        style="background: linear-gradient(rgba(30, 64, 114, 0.9), rgba(30, 64, 114, 0.9)), url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'); background-size: cover; background-position: center; color: white; min-height: 500px;">
        <div class="container py-5">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-7 mb-5 mb-lg-0">


                    <!-- Simple Trustpilot Button -->
                    <div class="mb-4">
                        <a href="https://uk.trustpilot.com/review/propertysourcinggroup.co.uk" target="_blank"
                            class="text-decoration-none d-inline-block transition-hover">
                            <div class="bg-white px-3 py-1 d-flex align-items-center"
                                style="border: 1.5px solid #00b67a; border-radius: 2px;">
                                <span class="text-dark me-2" style="font-size: 14px;">Review us on</span>
                                <i class="bi bi-star-fill" style="color: #00b67a; font-size: 16px; margin-right: 4px;"></i>
                                <span class="text-dark fw-bold" style="font-size: 15px;">Trustpilot</span>
                            </div>
                        </a>
                    </div>
                    <h1 class="display-4 fw-bold mb-4">Property Deal Sourcing</h1>
                    <p class="lead opacity-75 mb-4">Investing in deals that aren't listed on Rightmove?</p>
                    <p class="mb-5 text-white">Join our exclusive property deal sourcing service today. We
                        help you find
                        below market value deals across the UK.</p>
                    <ul class="list-unstyled mb-5">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-pink me-3 fs-4"></i>
                            Up to 25% Below Market Value
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-pink me-3 fs-4"></i>
                            Exclusive Off-Market Deals
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-pink me-3 fs-4"></i>
                            Tailored Investment Opportunities (BTL, BRR & More)
                        </li>
                    </ul>
                </div>

                <!-- Right Form -->
                <div class="col-lg-5">
                    <div class="hero-form-container p-4 p-md-5 rounded-4"
                        style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px);">
                        <h3 class="fw-bold text-center mb-4">Invest in success</h3>
                        <p class="text-center small opacity-75 mb-4">Every month we have 10-15 deals available to our
                            members</p>
                        <form action="{{ route('inquiry.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="general">
                            <input type="hidden" name="source_page" value="Homepage Hero">

                            <div class="mb-3">
                                <input type="text" name="name"
                                    class="form-control bg-transparent text-white border-secondary" placeholder="Full Name*"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email"
                                    class="form-control bg-transparent text-white border-secondary"
                                    placeholder="Email Address*" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone"
                                    class="form-control bg-transparent text-white border-secondary"
                                    placeholder="Phone Number*" required>
                            </div>
                            <div class="mb-4">
                                <select name="ready_to_buy" class="form-select bg-transparent text-white border-secondary"
                                    required>
                                    <option value="" class="text-dark">When are you ready to buy?*</option>
                                    <option value="Immediately" class="text-dark">Immediately</option>
                                    <option value="1-3 Months" class="text-dark">Within 1-3 Months</option>
                                    <option value="3-6 Months" class="text-dark">Within 3-6 Months</option>
                                    <option value="Just Researching" class="text-dark">Just Researching</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-custom-pink w-100 py-3 fw-bold">Get Exclusive Deals
                                Today!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="py-4 border-bottom shadow-sm" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row text-center align-items-center">
                <div class="col-md-3">
                    <p class="mb-0 fw-bold text-dark opacity-50">THE NUMBERS SPEAK FOR THEMSELVES</p>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold mb-0 text-blue">100+</h2>
                    <p class="small text-muted mb-0">Properties Sold</p>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold mb-0 text-blue">25</h2>
                    <p class="small text-muted mb-0">Years of Experience</p>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold mb-0 text-blue">100's</h2>
                    <p class="small text-muted mb-0">Of Happy Investors</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profits Feature -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="display-5 fw-bold mb-4 text-blue">Unlock High-Yield Property Investments</h2>
                    <p class="lead text-muted mb-4">Secure your financial future with our exclusive property deals.</p>
                    <p class="mb-4 text-secondary">Our expert team sources high-return investment opportunities that are
                        designed to maximize your wealth. With a focus on transparency and reliability, we help you build a
                        profitable property portfolio.</p>
                    <p class="fw-bold text-blue">If you are looking for a secure investment with consistent returns, you are
                        in the right place!</p>
                </div>
                <div class="col-lg-6">
                    <div class="rounded-4 overflow-hidden shadow-lg border-5 border-blue bg-dark">
                        <video class="w-100 d-block" autoplay muted loop playsinline controls
                            poster="https://images.unsplash.com/photo-1560520653-9e0e4c89eb11?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80">
                            <source src="https://videos.pexels.com/video-files/3255275/3255275-hd_1920_1080_25fps.mp4"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trustpilot Reviews Section -->
    @if(isset($trustpilotReviews) && $trustpilotReviews->isNotEmpty())
        @php
            $averageRating = $trustpilotReviews->avg('rating_stars');
            $totalReviews = $trustpilotReviews->count();
        @endphp
        <section class="py-5 border-top border-bottom" style="background-color: #fafffc;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- Section Header -->
                        <div class="text-center mb-5">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold mb-3">
                                <i class="bi bi-globe me-1"></i> Trusted by Clients Worldwide
                            </span>
                            <h2 class="display-6 fw-bold text-dark mb-3">Don't just take our word for it.</h2>
                            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                                See what our gold-standard investors and property partners have to say about working with us.
                            </p>
                        </div>

                        <div
                            class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-4 bg-white p-4 rounded-4 shadow-sm border mb-5">
                            <!-- Trustpilot Rating Info -->



                            <!-- Simple Trustpilot Button -->
                            <a href="https://uk.trustpilot.com/review/propertysourcinggroup.co.uk" target="_blank"
                                class="text-decoration-none d-inline-block transition-hover">
                                <div class="bg-white px-4 py-2 d-flex align-items-center"
                                    style="border: 2px solid #00b67a; border-radius: 4px;">
                                    <span class="text-dark me-2" style="font-size: 15px;">Review us on</span>
                                    <i class="bi bi-star-fill" style="color: #00b67a; font-size: 20px; margin-right: 5px;"></i>
                                    <span class="text-dark fw-bold" style="font-size: 18px;">Trustpilot</span>
                                </div>
                            </a>
                        </div>

                        <!-- Enhanced Review Carousel -->

                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Investment Deals (Redesigned to match image) -->
    <section id="properties" class="py-5" style="background-color: #0b1c33;">
        <div class="container py-5">
            <div class="text-center text-white mb-5">
                <h2 class="display-5 fw-bold mb-3">Our Below Market Value Investment Deals</h2>
                <div class="mx-auto bg-pink mb-4" style="height: 3px; width: 60px;"></div>

                <p class="opacity-75 mx-auto mb-4" style="max-width: 900px;">
                    A quality investment is something that gives you returns from day one. If you can achieve a significant
                    discount from the market value, you insulate yourself against any change in the property market, and
                    you're in profit straight away.
                </p>
                <p class="opacity-75 mx-auto mb-4" style="max-width: 900px;">
                    We are in a unique position that allows us to provide our investors properties, <strong>below market
                        value</strong>, direct from vendor - you'll never find them on popular property portals like
                    Rightmove & Zoopla.
                </p>
                <p class="opacity-75 mx-auto mb-5" style="max-width: 900px;">
                    The discounts on offer to our <strong>qualified investors</strong> not only ensure profit in regards to
                    capital gains, but they typically offer <strong>fantastic yields</strong>.
                </p>

                <!-- Subheader Bar -->
                <div class="py-2 mb-4 fw-bold"
                    style="background-color: var(--primary-pink); color: white; font-style: italic;">
                    Examples of previously sold properties
                </div>
            </div>

            <div class="row g-4">
                @foreach ($properties->take(4) as $property)
                    <div class="col-lg-3 col-md-6">
                        <div
                            class="deal-card border-0 bg-transparent h-100 d-flex flex-column shadow-sm rounded-4 overflow-hidden">
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                <img src="{{ $property->image_url ? (Str::startsWith($property->image_url, 'http') ? $property->image_url : asset('storage/' . $property->image_url)) : 'https://images.unsplash.com/photo-1560184897-ae75f3a84ec3?auto=format&fit=crop&q=80&w=400' }}"
                                    class="w-100 h-100" style="object-fit: cover;" alt="{{ $property->location }}"
                                    loading="lazy">
                            </div>
                            <!-- Location Bar -->
                            <div class="py-2 text-center fw-bold" style="background-color: var(--primary-pink); color: white;">
                                {{ $property->location }}
                            </div>
                            <!-- Description Body -->
                            <div class="bg-white p-4 text-center flex-grow-1">
                                <p class="text-blue fw-bold small mb-2 text-uppercase">{{ $property->type ?? 'Investment' }}</p>
                                <p class="text-secondary small mb-0 line-clamp-3">
                                    {{ $property->description }}
                                </p>
                            </div>
                            <!-- BMV Badge Footer -->
                            <div class="bg-light py-2 text-center border-top">
                                <span class="fw-bold text-blue">{{ $property->bmv_percentage }}% BMV</span>
                                @if($property->yield)
                                    <span class="mx-2 text-muted">|</span>
                                    <span class="fw-bold text-pink">{{ $property->yield }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5 d-flex justify-content-center gap-3">
                <a href="{{ route('properties.index') }}" class="btn btn-outline-light px-5 py-3 rounded-pill fw-bold">View
                    Recent Sales</a>
                <a href="{{ route('become-investor') }}" class="btn btn-custom-pink px-5 py-3 rounded-pill fw-bold">Join Our
                    Investor List</a>
            </div>
        </div>
    </section>

    <!-- Who Are We -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4 text-blue">Who Are The Property Sourcing Group?</h2>
                    <p class="text-muted mb-4">We are property experts with over 10 years of experience in the industry. Our
                        aim is to help you find the best property deals in the UK.</p>
                    <p class="mb-4 text-secondary text-muted">Our team of experts will work with you to understand your
                        requirements and find the best property deals that match your investment strategy. Whether you are
                        looking for buy to let, BRR or HMO deals, we have the right property for you.</p>
                    <p class="fw-bold mb-0 text-blue">Our team will look at each individual property to see what kind of
                        deals it can yield and tell you exactly why you should buy the type of property you are looking for,
                        offering a personalized advice to you.</p>
                </div>
                <div class="col-lg-6">
                    <div class="rounded-4 overflow-hidden shadow" style="height: 400px;">
                        <img src="{{asset('img.jpg')}}" class="w-100 h-100" style="object-fit: cover;" alt="Team">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="py-5" style="background-color: #f4f6f9;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-blue">Our Services</h2>
                <div class="mx-auto bg-pink mb-3" style="height: 3px; width: 60px;"></div>
                <p class="text-muted">Explore how we help our investors succeed in property.</p>
            </div>

            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-lg-4 col-md-6">
                        <div
                            class="service-card p-0 bg-white rounded-4 overflow-hidden h-100 shadow-sm transition-hover border">
                            <img src="{{ $service->hero_image_url ? (Str::startsWith($service->hero_image_url, 'http') ? $service->hero_image_url : asset('storage/' . $service->hero_image_url)) : 'https://images.unsplash.com/photo-1560520663-84018e474345?auto=format&fit=crop&q=80&w=400' }}"
                                class="w-100" style="height: 220px; object-fit: cover;" alt="{{ $service->title }}"
                                loading="lazy">
                            <div class="p-4 text-center">
                                <h4 class="fw-bold mb-3 text-blue">{{ $service->title }}</h4>
                                <p class="text-secondary mb-4 small">
                                    {{ Str::limit($service->description, 100) }}
                                </p>
                                <a href="{{ route('service.show', $service->slug) }}"
                                    class="text-pink fw-bold text-decoration-none">See more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CEO Section -->
    <section class="py-5" style="background-color: var(--primary-blue); color: white;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="rounded-4 overflow-hidden shadow" style="height: 450px;">
                        <img src="{{asset('seller.jpg')}}" class="w-100 h-100" style="object-fit: cover;" alt="CEO">
                    </div>
                </div>
                <div class="col-lg-7">
                    <h2 class="display-5 fw-bold mb-4">WE'RE MORE THAN YOUR AVERAGE PROPERTY SELLER</h2>
                    <p class="opacity-75 mb-4">We believe in building long term relationships with our investors. We provide
                        a full service from finding the property to managing it for you. We take away the stress of property
                        investment so you can enjoy the returns.</p>
                    <p class="opacity-75">Our goal is to help you achieve financial freedom through property investment. Our
                        team of experts is always available to help you find the right deals and provide you with all the
                        support you need throughout your investment journey.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works / FAQ -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Left: How It Works Steps -->
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4 text-blue">HOW IT WORKS</h2>
                    <p class="text-muted lead mb-5">If you’re interested in joining our investor database, the process is
                        simple, quick, and completely hassle-free. By signing up, you’ll gain exclusive access to the latest
                        property opportunities, delivered directly to your inbox as soon as they become available. All you
                        need to do is provide a few basic details, and you’ll be among the first to explore high-potential
                        investments, stay updated with market trends, and make informed decisions with ease.</p>

                    <div class="work-steps-list">
                        @foreach($workSteps as $index => $step)
                            <div class="d-flex mb-4">
                                <div class="step-number me-4 bg-pink text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="min-width: 40px; height: 40px;">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h5 class="fw-bold text-blue mb-1 text-uppercase">{{ $step->title }}</h5>
                                    <p class="text-muted small mb-0">{!! $step->description !!}</p>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

                <!-- Right: FAQ Accordion -->
                <div class="col-lg-6">

                    <div class="accordion accordion-flush" id="faqAccordion">
                        @foreach($faqs as $index => $faq)
                            <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }} fw-bold text-blue"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="faq{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($faqs->count() == 0)
                            <div class="text-center py-4 border rounded-3">
                                <p class="text-muted mb-0">Frequently asked questions will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-5 bg-light border-top">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-4 text-blue">Why invest with us?</h2>
            <p class="text-muted mx-auto mb-5" style="max-width: 800px;">Since you and the property market are fast becoming
                a bigger company, The Property Sourcing Group has been in the Property Buying industry for years. Deal
                finder is our next platform specifically for property buyers and investors.</p>
            <a href="{{ route('become-investor') }}" class="btn btn-custom-pink px-5 py-3 rounded-pill fw-bold">JOIN THE
                LIST NOW</a>
        </div>
    </section>

    <style>
        .text-pink {
            color: var(--primary-pink);
        }

        .text-blue {
            color: var(--primary-blue);
        }

        .bg-pink {
            background-color: var(--primary-pink);
        }

        .bg-blue {
            background-color: var(--primary-blue);
        }

        .transition-hover {
            transition: all 0.3s;
        }

        .transition-hover:hover {
            transform: translateY(-10px);
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: var(--primary-pink);
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hero-form-container .form-control::placeholder {
            color: #ffffff !important;
        }

        .hero-form-container .form-control {
            color: white !important;
        }

        /* For IE */
        .hero-form-container .form-control:-ms-input-placeholder {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* For Edge */
        .hero-form-container .form-control::-ms-input-placeholder {
            color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>
@endsection