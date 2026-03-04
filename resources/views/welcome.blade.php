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

    <!-- Hero Section : Benefits of Joining Us -->
    <section class="hero-premium-v3 position-relative overflow-hidden d-flex align-items-center">
        <!-- Cinematic Background Architecture -->
        <div class="hero-bg-layer position-absolute top-0 start-0 w-100 h-100">
            <div class="mesh-glow"></div>
            <div class="carbon-overlay"></div>
            <div class="glow-sphere sphere-1"></div>
            <div class="glow-sphere sphere-2"></div>
            <div class="house-silhouette"></div>
        </div>

        <div class="container position-relative py-4 py-lg-0" style="z-index: 10;">
            <!-- Centered Header -->
            <div class="text-center mb-5 reveal-content">
                <!-- Trustpilot Integration -->
                <div class="mb-4">
                    <a href="https://uk.trustpilot.com/review/propertysourcinggroup.co.uk" target="_blank"
                        class="text-decoration-none d-inline-block transition-hover-glow">
                        <div class="bg-white px-3 py-1 d-flex align-items-center"
                            style="border: 1.5px solid #00b67a; border-radius: 4px; box-shadow: 0 4px 15px rgba(0, 182, 122, 0.1);">
                            <span class="text-dark me-2 fw-medium" style="font-size: 13px;">Review us on</span>
                            <i class="bi bi-star-fill" style="color: #00b67a; font-size: 14px; margin-right: 4px;"></i>
                            <span class="text-dark fw-bold" style="font-size: 14px;">Trustpilot</span>
                        </div>
                    </a>
                </div>

                <div class="elite-badge d-inline-flex align-items-center rounded-pill mb-4">
                    <span class="pulse-icon me-2"></span>
                    <span class="text-pink fw-bold text-uppercase ls-3" style="font-size: 0.65rem;">UK's Elite Sourcing
                        Portal</span>
                </div>
                <h1 class="display-3 fw-bold text-white mb-3 main-heading">
                    Property Portal for <br><span class="text-gradient-custom">Agents and Investors</span>
                </h1>
                <p class="lead text-white opacity-75 mx-auto fw-light"
                    style="line-height: 1.6; font-size: 1.15rem; max-width: 850px;">
                    An Exclusive Property Sourcing platform with property deals designed to bring together agents offering
                    Off market deals and investment opportunities all in one place.
                </p>


            </div>

            <div class="row g-4 align-items-stretch">
                <!-- Investor Strategic Card (Left) -->
                <div class="col-lg-6">
                    <div class="hyper-glass-card investor-border h-100 p-4 p-xl-5 d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-orb bg-cyan-alpha">
                                    <i class="bi bi-graph-up-arrow fs-3 text-cyan"></i>
                                </div>
                                <h3 class="h4 fw-bold text-white mb-0">INVESTOR BENEFITS</h3>
                            </div>
                            <div class="action-glyph"><i class="bi bi-arrow-up-right"></i></div>
                        </div>
                        <p class="text-cyan small fw-bold opacity-75 mb-3">Access Investor Deals</p>
                        <div class="perk-tags mb-4">
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-cyan me-2"></i> Access Off market Deals
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-cyan me-2"></i> Up to 35% below Market Value deals
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-cyan me-2"></i> Distress Sales opportunities
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-cyan me-2"></i> Access to a whole range of deals Uk wide
                            </div>
                            <div class="d-flex align-items-center text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-cyan me-2"></i> Get verified as a Cash Buyer to access
                                more Inventory
                            </div>
                        </div>
                        <a href="{{ route('register', ['role' => 'user']) }}"
                            class="btn btn-cyan-premium-v3 w-100 py-3 rounded-pill fw-bold mt-auto">
                            ACCESS INVESTOR PORTAL <i class="bi bi-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Agent Strategic Card (Right) -->
                <div class="col-lg-6">
                    <div class="hyper-glass-card agent-border h-100 p-4 p-xl-5 d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-orb bg-pink-alpha">
                                    <i class="bi bi-lightning-charge-fill fs-3 text-pink"></i>
                                </div>
                                <h3 class="h4 fw-bold text-white mb-0">AGENT BENEFITS</h3>
                            </div>
                            <div class="action-glyph"><i class="bi bi-arrow-up-right"></i></div>
                        </div>
                        <p class="text-pink small fw-bold opacity-75 mb-3">Maximize Your Revenue</p>
                        <div class="perk-tags mb-4">
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-pink me-2"></i> Create unlimited listings
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-pink me-2"></i> Access listings nationwide from Our
                                network Partners
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-pink me-2"></i> Create white label Brochures for
                                Marketing at one click
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-pink me-2"></i> Create Instagram and Face book posts with
                                1 click
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-pink me-2"></i> Access to Vetted cash Buyers
                            </div>
                            <div class="d-flex align-items-center mb-2 text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-pink me-2"></i> Access filtered search
                            </div>
                            <div class="d-flex align-items-center text-white opacity-75 small">
                                <i class="bi bi-check2-circle text-pink me-2"></i> Only pay a sourcing fee on lead closing
                            </div>
                        </div>
                        <a href="{{ route('register', ['role' => 'agent']) }}"
                            class="btn btn-pink-premium-v3 w-100 py-3 rounded-pill fw-bold mt-auto">
                            ACCESS AGENT PORTAL <i class="bi bi-lightning-fill ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <a href="https://facebook.com/profile.php?id=61587416069479" target="_blank"
                    class="btn btn-custom-blue text-nowrap px-5 py-3 rounded-pill fw-bold transition-hover-glow"
                    style="background: white; color: var(--primary-blue); border: none; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
                    Join Our Group
                </a>
            </div>
        </div>


        <style>
            .hero-premium-v3 {
                background: #0a192f;
                min-height: 85vh;
                padding: 80px 0;
            }

            .mesh-glow {
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at 0% 0%, rgba(30, 64, 114, 0.4) 0%, transparent 50%),
                    radial-gradient(circle at 100% 100%, rgba(231, 31, 107, 0.08) 0%, transparent 50%);
            }

            .carbon-overlay {
                position: absolute;
                inset: 0;
                background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
                opacity: 0.12;
            }

            .glow-sphere {
                position: absolute;
                border-radius: 50%;
                filter: blur(140px);
                opacity: 0.2;
            }

            .sphere-1 {
                width: 500px;
                height: 500px;
                background: #1e4072;
                top: -10%;
                right: 5%;
            }

            .sphere-2 {
                width: 350px;
                height: 350px;
                background: #E71F6B;
                bottom: 5%;
                left: 0%;
            }

            .house-silhouette {
                position: absolute;
                inset: 0;
                background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
                opacity: 0.08;
                mix-blend-mode: overlay;
            }

            .elite-badge {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.08);
                padding: 5px 15px;
                backdrop-filter: blur(10px);
            }

            .pulse-icon {
                width: 7px;
                height: 7px;
                background: #E71F6B;
                border-radius: 50%;
                display: inline-block;
                animation: pulse-ring 1.5s infinite;
            }

            @keyframes pulse-ring {
                0% {
                    transform: scale(0.8);
                    box-shadow: 0 0 0 0 rgba(231, 31, 107, 0.7);
                }

                70% {
                    transform: scale(1);
                    box-shadow: 0 0 0 10px rgba(231, 31, 107, 0);
                }

                100% {
                    transform: scale(0.8);
                }
            }

            .ls-3 {
                letter-spacing: 3px;
            }

            .main-heading {
                font-weight: 800;
                letter-spacing: -3px;
                line-height: 1.05;
            }

            .text-gradient-custom {
                background: linear-gradient(to right, #E71F6B, #FF71A4);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .metric-pill {
                font-size: 0.85rem;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.85);
                background: rgba(255, 255, 255, 0.03);
                padding: 8px 20px;
                border-radius: 50px;
                border: 1px solid rgba(255, 255, 255, 0.05);
            }

            .hyper-glass-card {
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(255, 255, 255, 0.06);
                border-radius: 32px;
                backdrop-filter: blur(30px);
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .hyper-glass-card:hover {
                transform: translateY(-12px) scale(1.015);
                background: rgba(255, 255, 255, 0.05);
                border-color: rgba(255, 255, 255, 0.15);
                box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            }

            .investor-border:hover {
                border-color: rgba(76, 215, 246, 0.4);
            }

            .agent-border:hover {
                border-color: rgba(231, 31, 107, 0.4);
            }

            .icon-orb {
                width: 54px;
                height: 54px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(5px);
            }

            .bg-cyan-alpha {
                background: rgba(76, 215, 246, 0.1);
                border: 1px solid rgba(76, 215, 246, 0.2);
            }

            .bg-pink-alpha {
                background: rgba(231, 31, 107, 0.1);
                border: 1px solid rgba(231, 31, 107, 0.2);
            }

            .action-glyph {
                color: rgba(255, 255, 255, 0.15);
                font-size: 1.4rem;
            }

            .perk-tags {
                display: flex;
                gap: 6px;
                flex-wrap: wrap;
            }

            .tag {
                font-size: 0.65rem;
                color: rgba(255, 255, 255, 0.5);
                padding: 4px 12px;
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.04);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }

            .btn-cyan-premium-v3 {
                background: #4CD7F6;
                color: #0a192f;
                border: none;
                transition: 0.4s;
            }

            .btn-cyan-premium-v3:hover {
                background: #fff;
                transform: scale(1.03);
                box-shadow: 0 15px 35px rgba(76, 215, 246, 0.4);
            }

            .btn-pink-premium-v3 {
                background: #E71F6B;
                color: white;
                border: none;
                transition: 0.4s;
            }

            .btn-pink-premium-v3:hover {
                background: #ff488e;
                transform: scale(1.03);
                box-shadow: 0 15px 35px rgba(231, 31, 107, 0.4);
            }

            .transition-hover-glow {
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .transition-hover-glow:hover {
                transform: translateY(-3px) scale(1.02);
                box-shadow: 0 15px 35px rgba(255, 255, 255, 0.2);
                opacity: 0.95;
            }

            @media (max-width: 991px) {
                .hero-premium-v3 {
                    padding: 40px 0;
                    min-height: auto;
                }

                .main-heading {
                    font-size: 3rem;
                    letter-spacing: -1.5px;
                }

                .metric-pill {
                    display: none;
                }
            }
        </style>
    </section>

    <!-- Stats Bar -->
    <div class="py-4 py-lg-5 border-bottom shadow-sm" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row text-center g-3 g-md-4 align-items-center">
                <div class="col-lg-3 col-12">
                    <h5 class="mb-2 mb-lg-0 fw-bold text-blue opacity-75 text-uppercase tracking-wider"
                        style="font-size: 0.9rem;">The Numbers Speak For Themselves</h5>
                </div>
                <div class="col-lg-3 col-4">
                    <div class="p-2 p-md-3">
                        <h2 class="display-4 fw-bold mb-0 text-pink">100+</h2>
                        <p class="small fw-medium text-blue mb-0">Sold</p>
                    </div>
                </div>
                <div class="col-lg-3 col-4">
                    <div class="p-2 p-md-3">
                        <h2 class="display-4 fw-bold mb-0 text-pink">25</h2>
                        <p class="small fw-medium text-blue mb-0">Years XP</p>
                    </div>
                </div>
                <div class="col-lg-3 col-4">
                    <div class="p-2 p-md-3">
                        <h2 class="display-4 fw-bold mb-0 text-pink">100s</h2>
                        <p class="small fw-medium text-blue mb-0">Happy</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Conversion Section (Old Hero Content) -->
    <section class="py-5 position-relative overflow-hidden" style="background-color: #fcfdfe;">
        <div class="container py-5">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <div class="pe-lg-5">
                        <span
                            class="badge bg-blue text-white px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm text-uppercase tracking-widest"
                            style="font-size: 0.75rem;">Premium Sourcing</span>
                        <h2 class="display-4 fw-bold text-blue mb-4">Property Deal Sourcing</h2>
                        <p class="lead text-muted mb-4">Investing in deals that aren't listed on Rightmove?</p>
                        <p class="mb-4 text-secondary">Join our exclusive property deal sourcing service today. We help you
                            find below market value deals across the UK.</p>

                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-patch-check-fill text-pink me-2"></i>
                                    <span class="fw-bold text-blue small">25% Below Market Value</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-patch-check-fill text-pink me-2"></i>
                                    <span class="fw-bold text-blue small">Exclusive Off-Market Deals</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-patch-check-fill text-pink me-2"></i>
                                    <span class="fw-bold text-blue small">Tailored Opportunities (BTL, BRR & More)</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('register') }}?role=agent"
                                class="btn btn-outline-blue px-4 py-2 rounded-pill fw-bold">Agent Signup</a>
                            <a href="{{ route('register') }}?role=user"
                                class="btn btn-custom-pink px-4 py-2 rounded-pill fw-bold">Investor Signup</a>
                        </div>
                    </div>
                </div>

                <!-- Right Form -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5" style="background: white;">
                        <h3 class="fw-bold text-blue text-center mb-3">Invest in success</h3>
                        <p class="text-center small text-muted mb-4">Every month we have 10-15 deals available to our
                            members</p>
                        <form action="{{ route('inquiry.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="general">
                            <input type="hidden" name="source_page" value="Homepage Lower Conversion">

                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Full Name*" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email Address*" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number*" required>
                            </div>
                            <div class="mb-4">
                                <select name="ready_to_buy" class="form-select" required>
                                    <option value="">When are you ready to buy?*</option>
                                    <option value="Immediately">Immediately</option>
                                    <option value="1-3 Months">Within 1-3 Months</option>
                                    <option value="3-6 Months">Within 3-6 Months</option>
                                    <option value="Just Researching">Just Researching</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-custom-pink w-100 py-3 fw-bold shadow-sm">Get Exclusive
                                Deals Today!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
                            class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 gap-md-4 bg-white p-4 rounded-4 shadow-sm border mb-5">
                            <!-- Trustpilot Rating Info -->
                            <!-- Simple Trustpilot Button -->
                            <a href="https://uk.trustpilot.com/review/propertysourcinggroup.co.uk" target="_blank"
                                class="text-decoration-none d-inline-block transition-hover w-100 w-md-auto text-center">
                                <div class="bg-white px-4 py-2 d-flex align-items-center justify-content-center"
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

            <div class="text-center mt-5 d-flex flex-column flex-md-row justify-content-center gap-3">
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
                    <div class="rounded-4 overflow-hidden shadow-sm mt-4 mt-lg-0" style="height: auto; min-height: 300px;">
                        <img src="{{asset('img.jpg')}}" class="w-100 h-100" style="object-fit: cover; border-radius: 1rem;"
                            alt="Team">
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
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="rounded-4 overflow-hidden shadow-sm" style="height: auto; min-height: 350px;">
                        <img src="{{asset('seller.jpg')}}" class="w-100 h-100"
                            style="object-fit: cover; border-radius: 1rem;" alt="CEO">
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