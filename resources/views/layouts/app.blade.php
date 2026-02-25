<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Property Sourcing Group - UK's Leading Deal Sourcing Agents</title>

    <!-- Resource Hints for Performance -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://images.unsplash.com">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta name="google-site-verification" content="k_mil_w23PfACiQ0DlWn6XUopC6IWpvztJxspA4hUUs" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #1E4072;
            /* Dark Blue from header */
            --primary-pink: #F95CA8;
            /* Pink from text/bar */
            --accent-cyan: #4CD7F6;
            /* Cyan from 'Group' */
            --dark-text: #0b1c33;
            --light-bg: #FFFFFF;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            background-color: #f4f6f9;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Utilities */
        .text-blue {
            color: var(--primary-blue) !important;
        }

        .text-pink {
            color: var(--primary-pink) !important;
        }

        .text-cyan {
            color: var(--accent-cyan) !important;
        }

        .bg-blue {
            background-color: var(--primary-blue) !important;
        }

        .bg-pink {
            background-color: var(--primary-pink) !important;
        }

        .bg-cyan {
            background-color: var(--accent-cyan) !important;
        }

        /* Buttons */
        .btn-custom-pink {
            background-color: var(--primary-pink);
            color: white;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(249, 92, 168, 0.3);
        }

        .btn-primary {
            background-color: #08c3e1;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #08c3e1;
            color: white;
            border: none;
        }

        .btn-outline-primary:hover {
            background-color: #08c3e1;
            color: white;
            border: none;
        }

        .btn-custom-pink:hover {
            background-color: #d14088;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(249, 92, 168, 0.4);
        }

        .btn-custom-blue {
            background-color: var(--primary-blue);
            color: white;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(30, 64, 114, 0.3);
        }

        .btn-custom-blue:hover {
            background-color: #152d50;
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-blue {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-blue:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        /* Navbar & Header */
        .main-header {
            background-color: white;
            padding: 15px 0;
            position: relative;
            border-bottom: 1px solid #eee;
        }

        .custom-navbar {
            background-color: #08c3e1;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 0;
            z-index: 1030;
        }

        .custom-navbar .nav-link {
            color: white !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.95rem;
            padding: 15px 20px !important;
            transition: all 0.3s;
        }

        .custom-navbar .nav-link:hover {
            color: var(--primary-pink) !important;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 10px;
            min-width: 220px;
            margin-top: 15px;
            /* Offset for cleaner look */
        }

        .dropdown-item {
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 0.95rem;
            color: var(--primary-blue);
            transition: all 0.2s;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: rgba(249, 92, 168, 0.1);
            color: var(--primary-pink);
            transform: translateX(5px);
        }

        .top-pink-bar {
            background-color: var(--primary-pink);
            color: white;
            text-align: center;
            font-weight: 700;
            padding: 8px 0;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .btn-event {
            background-color: #1E4072;
            color: white;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(249, 92, 168, 0.3);
        }

        .btn-event:hover {
            background-color: #152e54;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 114, 0.3);
        }

        /* Logo Styling */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            font-size: 2.5rem;
            color: white;
            line-height: 1;
        }

        .logo-text {
            line-height: 1;
            display: flex;
            flex-direction: column;
        }

        .logo-line-1 {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 0.9;
        }

        .logo-line-2 {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 0.9;
            text-align: right;
            /* Aligns Group to right as per roughly design */
        }

        .header-socials a {
            font-size: 1.3rem;
            margin-left: 15px;
            transition: transform 0.3s;
            display: inline-block;
        }

        .header-socials a:hover {
            transform: scale(1.2);
        }

        .social-facebook {
            color: #1877F2 !important;
        }

        .social-instagram {
            color: #E4405F !important;
        }

        .social-whatsapp {
            color: #25D366 !important;
        }

        /* Hero */
        .hero-section {
            background-color: var(--light-bg);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
            background-image: linear-gradient(135deg, rgba(230, 240, 255, 1) 0%, rgba(255, 255, 255, 1) 100%);
        }

        .hero-bg-img {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            object-fit: cover;
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
            opacity: 0.9;
            z-index: 0;
        }

        @media (max-width: 991px) {
            .hero-bg-img {
                width: 100%;
                opacity: 0.1;
                clip-path: none;
            }
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero-form-card {
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(30, 64, 114, 0.15);
        }

        .form-control,
        .form-select {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #e1e5eb;
            background-color: #f8f9fa;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(249, 92, 168, 0.2);
            border-color: var(--primary-pink);
            background-color: white;
        }

        .check-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            color: var(--primary-blue);
            font-weight: 500;
        }

        .check-icon {
            color: var(--primary-pink);
            font-size: 1.5rem;
            margin-right: 12px;
        }

        /* Stats Bar */
        .stats-bar {
            background-color: var(--primary-blue);
            color: white;
            padding: 50px 0;
            position: relative;
            z-index: 20;
        }

        .stats-title {
            color: var(--accent-cyan);
            font-weight: 700;
            font-size: 1.25rem;
            border-right: 2px solid rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .stats-title {
                border-right: none;
                border-bottom: 2px solid rgba(255, 255, 255, 0.2);
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }

        /* Cards */
        .deal-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #eee;
        }

        .deal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(30, 64, 114, 0.1);
        }

        .deal-img-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .deal-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .deal-card:hover .deal-img-wrapper img {
            transform: scale(1.1);
        }

        .bmv-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--primary-pink);
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .deal-body {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .service-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            height: 100%;
            border-bottom: 4px solid transparent;
        }

        .service-card:hover {
            transform: translateY(-5px);
            border-bottom: 4px solid var(--primary-pink);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* How It Works */
        .step-item {
            background: white;
            padding: 20px 25px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            border-left: 5px solid var(--primary-blue);
            cursor: pointer;
            transition: all 0.3s;
        }

        .step-item:hover {
            border-left-color: var(--primary-pink);
            transform: translateX(10px);
        }

        .step-icon {
            transition: transform 0.3s;
        }

        .step-item:hover .step-icon {
            transform: rotate(90deg);
            color: var(--primary-pink) !important;
        }

        /* Footer */
        footer {
            background-color: white;
            color: var(--dark-text);
            padding-top: 70px;
            padding-bottom: 30px;
            border-top: 1px solid #eee;
        }

        footer h5 {
            color: var(--primary-blue);
            letter-spacing: 1px;
            font-weight: 700;
        }

        footer a {
            color: var(--dark-text);
            opacity: 0.8;
            text-decoration: none;
            transition: all 0.3s;
        }

        footer a:hover {
            color: var(--primary-pink);
            padding-left: 5px;
            opacity: 1;
        }

        .social-icon {
            width: 38px;
            height: 38px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s;
            border: 1px solid #eee;
        }

        .social-icon:hover {
            background: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        /* Floating Buttons */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            background-color: #128c7e;
            color: white;
        }

        .tawk-to-btn {
            position: fixed;
            bottom: 110px;
            right: 45px;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 50%;
            /* Circle */
            padding: 15px;
            z-index: 1000;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pink-icon {
            filter: brightness(0) saturate(100%) invert(55%) sepia(77%) saturate(3800%) hue-rotate(305deg) brightness(102%) contrast(101%);
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Top Header Section (Dark Blue) -->
    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo Area -->
                <div class="col-md-4 col-12 text-center text-md-start mb-3 mb-md-0">
                    <a href="{{ route('home') }}"
                        class="logo-container justify-content-center justify-content-md-start">
                        <img src="{{ asset('logo.png') }}" alt="Property Sourcing Group"
                            style="max-height: 85px; width: auto; object-fit: contain; image-rendering: -webkit-optimize-contrast;">
                    </a>
                </div>

                <!-- Contact & Socials Area -->
                <div
                    class="col-md-8 col-12 d-flex flex-column flex-md-row justify-content-end align-items-center gap-4">
                    <!-- Contact Info Stacked -->
                    <div class="d-flex flex-column gap-1">
                        <!-- Phone -->
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone-fill me-2 text-pink small"></i>
                            <a href="tel:0203 468 0480" class="fw-bold text-blue text-decoration-none small">0203 468
                                0480</a>
                        </div>

                        <!-- Email -->
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope-fill me-2 text-pink small"></i>
                            <a href="mailto:info@propertysourcinggroup.co.uk"
                                class="fw-bold text-blue text-decoration-none small">info@propertysourcinggroup.co.uk</a>
                        </div>
                    </div>

                    <!-- Social Icons -->
                    <div class="header-socials d-flex">
                        <a href="https://facebook.com/profile.php?id=61587416069479" target="_blank"
                            class="social-facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/propertysourcinggroup" target="_blank"
                            class="social-instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://wa.me/+442034680480" target="_blank" class="social-whatsapp"><i
                                class="bi bi-whatsapp"></i></a>
                    </div>

                    <!-- CTA -->
                    <div
                        class="d-flex flex-nowrap gap-2 ms-md-2 mt-3 mt-md-0 justify-content-center justify-content-md-end">
                        <a href="{{ route('become-investor') }}" class="btn btn-custom-pink text-nowrap px-3">Invest
                            Now</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
        <div class="container">
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            About
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('how-it-works') }}">How It Works</a></li>
                            <li><a class="dropdown-item" href="{{ route('why-choose-us') }}">Why Choose Us</a></li>
                            <li><a class="dropdown-item" href="{{ route('meet-the-team') }}">Meet The Team</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($navServices as $service)
                                <li><a class="dropdown-item"
                                        href="{{ route('service.show', $service->slug) }}">{{ $service->title }}</a></li>
                            @endforeach
                            @if($navServices->count() == 0)
                                <li><a class="dropdown-item" href="#">No Services Available</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('locations.index') }}">Locations</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('available-properties.index') }}">Properties</a></li>
                    @endauth
                    <li class="nav-item"><a class="nav-link" href="{{ route('news.index') }}">News</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('contact') }}" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Contact Us
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a class="dropdown-item" href="{{ route('faq') }}">FAQ</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
    </nav>

    <!-- Pink Info Bar -->
    <div class="top-pink-bar">
        UK's Leading Property Deal Sourcing Group
    </div>

    <div class="container">


        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 col-md-6">
                    <img src="{{ asset('logo.png') }}" alt="Property Sourcing Group" class="mb-4"
                        style="max-height: 75px; width: auto; object-fit: contain; image-rendering: -webkit-optimize-contrast;"
                        loading="lazy">
                    <p class="text-black opacity-75 small mb-4">
                        We connect investors with high-yield UK property deals. Making property investment
                        accessible, profitable, and stress-free.
                    </p>
                    <div class="d-flex">
                        <a href="https://facebook.com/profile.php?id=61587416069479" target="_blank"
                            class="social-icon social-facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/propertysourcinggroup" target="_blank"
                            class="social-icon social-instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://wa.me/+442034680480" class="social-icon social-whatsapp"><i
                                class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-4">Services</h5>
                    <ul class="list-unstyled small space-y-2 footer-services-list">
                        @foreach($navServices as $service)
                            <li style="margin-top:10px"><a
                                    href="{{ route('service.show', $service->slug) }}">{{ $service->title }}</a></li>
                        @endforeach
                        <li style="margin-top:10px"><a href="https://propertysalesdirect.co.uk/">Looking To Sell
                                Property Fast</a></li>
                        <li style="margin-top:10px"><a href="{{ route('register', ['role' => 'agent']) }}">Agent
                                Registration</a></li>
                        <li style="margin-top:10px"><a href="{{ route('register', ['role' => 'user']) }}">Investor
                                Registration</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-4">Contact Us</h5>
                    <ul class="list-unstyled text-black opacity-75 small">
                        <li class="d-flex mb-3"><i class="bi bi-geo-alt text-pink me-3"></i> 5-7 High Street London
                            United Kingdom. E
                            13 0AD</li>
                        <li class="d-flex mb-3 align-items-center">
                            <i class="bi bi-telephone text-pink me-3"></i>
                            <a href="tel:0203 468 0480" class="text-black text-decoration-none">0203 468 0480</a>
                        </li>
                        <li class="d-flex mb-3 align-items-center">
                            <img src="{{ asset('ph.png') }}" alt="Phone" class="me-3 pink-icon"
                                style="width:18px; height:18px; object-fit:contain;">
                            <a href="tel:+442034113603" class="text-black text-decoration-none">+44 203 411 3603</a>
                        </li>
                        <li class="d-flex mb-3"><i class="bi bi-envelope text-pink me-3"></i>
                            info@propertysourcinggroup.co.uk</li>
                    </ul>
                </div>
            </div>

            <div class="text-center pt-4 border-top mt-5 small text-muted">
                &copy; {{ date('Y') }} Property Sourcing Group. All Rights Reserved. Designed By <a
                    href="https://mediajunkie.co.uk" target="_blank">Media Junkie</a>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/+442034680480" class="whatsapp-float" target="_blank">
        <i class="bi bi-whatsapp"></i>
    </a>



    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>