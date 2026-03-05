<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Property Sourcing Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <style>
        :root {
            --primary-blue: #1E4072;
            --primary-pink: #F95CA8;
            --sidebar-width: 280px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-blue) 0%, #152e54 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            background-color: white;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand img {
            max-height: 70px;
            width: auto;
        }

        .sidebar-brand h4 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section-title {
            padding: 20px 20px 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
        }

        .sidebar-nav a i {
            font-size: 1.2rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .sidebar-nav a:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: white;
            padding-left: 28px;
        }

        .sidebar-nav a.active {
            background-color: rgba(249, 92, 168, 0.15);
            color: white;
            border-left: 4px solid var(--primary-pink);
            font-weight: 600;
        }

        .sidebar-nav a.active i {
            color: var(--primary-pink);
        }

        /* Dropdown/Submenu styles */
        .sidebar-nav .dropdown-icon {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
            width: auto;
            margin-right: 0;
            margin-left: auto;
        }

        .sidebar-nav a[aria-expanded="true"] .dropdown-icon {
            transform: rotate(180deg);
        }

        .nav-submenu {
            background-color: rgba(0, 0, 0, 0.1);
            padding: 5px 0;
            display: flex;
            flex-direction: column;
        }

        .nav-submenu a {
            padding-left: 50px !important;
            font-size: 0.9rem;
        }

        .nav-submenu a:hover {
            padding-left: 55px !important;
        }

        /* Topbar */
        .admin-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .topbar-search {
            flex: 1;
            max-width: 400px;
        }

        .topbar-search input {
            border: 1px solid #e3e6f0;
            border-radius: 50px;
            padding: 10px 20px 10px 45px;
            width: 100%;
            transition: all 0.3s;
        }

        .topbar-search input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(30, 64, 114, 0.1);
        }

        .topbar-search i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f9fc;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            transition: all 0.3s;
            position: relative;
        }

        .topbar-btn:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        .topbar-btn .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.65rem;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            border-radius: 50px;
            background-color: #f8f9fc;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-dropdown:hover {
            background-color: #e3e6f0;
        }

        .user-dropdown::after {
            display: none !important;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-pink));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Main Content */
        .admin-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 30px;
            min-height: calc(100vh - var(--topbar-height));
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h2 {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .page-header .breadcrumb-item {
            font-size: 0.9rem;
        }

        .page-header .breadcrumb-item.active {
            color: var(--primary-pink);
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-pink);
            transition: all 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .stats-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stats-card.blue .icon {
            background: linear-gradient(135deg, #1E4072, #2a5a9e);
            color: white;
        }

        .stats-card.pink .icon {
            background: linear-gradient(135deg, #F95CA8, #ff7ec4);
            color: white;
        }

        .stats-card.success .icon {
            background: linear-gradient(135deg, #28a745, #5cb85c);
            color: white;
        }

        .stats-card.warning .icon {
            background: linear-gradient(135deg, #ffc107, #ffdb4d);
            color: white;
        }

        .stats-card h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .stats-card p {
            color: #6c757d;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .content-card .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content-card .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--primary-blue);
        }

        .content-card .card-body {
            padding: 0;
        }

        /* Tables */
        .admin-table {
            margin: 0;
        }

        .admin-table thead th {
            background-color: #f8f9fc;
            color: var(--primary-blue);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding: 18px 25px;
            border: none;
        }

        .admin-table tbody td {
            padding: 18px 25px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .admin-table tbody tr:hover {
            background-color: #f8f9fc;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Buttons */
        .btn-admin-primary {
            background: linear-gradient(135deg, var(--primary-blue), #2a5a9e);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-admin-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 64, 114, 0.3);
            color: white;
        }

        .btn-admin-pink {
            background: linear-gradient(135deg, var(--primary-pink), #ff7ec4);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-admin-pink:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 92, 168, 0.3);
            color: white;
        }

        .btn-admin-edit {
            background-color: #f8f9fc;
            color: var(--primary-blue);
            border: 1px solid #e3e6f0;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .btn-admin-edit:hover {
            background-color: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        .btn-admin-delete {
            background-color: #f8f9fc;
            color: #dc3545;
            border: 1px solid #e3e6f0;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .btn-admin-delete:hover {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        /* Badges */
        .badge-admin {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-topbar,
            .admin-content {
                margin-left: 0;
            }

            .admin-topbar {
                left: 0;
                padding: 0 15px;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                backdrop-filter: blur(2px);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .mobile-toggle {
                display: flex !important;
            }
        }

        .mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-blue);
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .mobile-toggle:hover {
            background-color: #f8f9fc;
        }

        /* User Dashboard Utilities */
        .text-blue {
            color: var(--primary-blue) !important;
        }

        .text-pink {
            color: var(--primary-pink) !important;
        }

        .bg-primary {
            background-color: var(--primary-blue) !important;
        }

        .text-blue {
            color: var(--primary-blue) !important;
        }

        .bg-gradient-blue {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #2a5298 100%);
        }

        .bg-soft-blue {
            background-color: rgba(30, 64, 114, 0.1);
        }

        .bg-success-soft {
            background-color: rgba(40, 167, 69, 0.1);
        }

        .text-cyan {
            color: #4CD7F6 !important;
        }

        .stats-card.blue {
            border-left: 4px solid #4e73df;
        }

        .stats-card.pink {
            border-left: 4px solid #f95ca8;
        }

        .stats-card.success {
            border-left: 4px solid #1cc88a;
        }

        .stats-card.warning {
            border-left: 4px solid #f6c23e;
        }

        .btn-white {
            background-color: white;
            border: 1px solid #e3e6f0;
            color: #4e73df;
        }

        .btn-white:hover {
            background-color: #f8f9fc;
            border-color: #d1d3e2;
        }

        .bg-blue {
            background-color: var(--primary-blue) !important;
            color: white !important;
        }

        .bg-pink {
            background-color: var(--primary-pink) !important;
            color: white !important;
        }

        .btn-outline-blue {
            border: 1px solid var(--primary-blue);
            color: var(--primary-blue);
            transition: all 0.3s;
        }

        .btn-outline-blue:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        .hover-lift {
            transition: transform 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('logo.png') }}" alt="PSG">
            <h4>Admin Panel</h4>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Main</div>
            <a href="{{ (auth()->user()->role === 'admin' || auth()->user()->role === 'agent') ? route('admin.dashboard') : route('user.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') || request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>{{ (auth()->user()->role === 'admin' || auth()->user()->role === 'agent') ? 'Dashboard' : 'My Dashboard' }}</span>
            </a>

            <!-- Admin & Agent Menu -->
            @if(in_array(auth()->user()->role, ['admin', 'agent']))
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Users Accounts</span>
                    </a>
                    @php $hasPortfolio = Route::has('admin.portfolio'); @endphp
                    @if ($hasPortfolio)
                        <a href="{{ route('admin.portfolio') }}"
                            class="{{ request()->routeIs('admin.portfolio') ? 'active' : '' }}">
                            <i class="bi bi-building-check"></i>
                            <span>Sold Portfolio</span>
                        </a>
                    @endif
                @endif

                @php
                    $isManagementActive = request()->routeIs('admin.services.*', 'admin.locations.*', 'admin.team.*', 'admin.news.*', 'admin.faq.*', 'admin.trustpilot-reviews.*', 'admin.work-steps.*', 'admin.property-offers.*', 'admin.inquiries.*', 'admin.messages.*', 'admin.investors.*') || (request()->routeIs('available-properties.index') && !request()->has('status'));
                @endphp
                <a class="{{ $isManagementActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#collapseManagement"
                    role="button" aria-expanded="{{ $isManagementActive ? 'true' : 'false' }}"
                    style="display: flex; align-items: center; padding: 14px 20px; color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: all 0.3s ease; position: relative; font-weight: 500;">
                    <i class="bi bi-gear"
                        style="font-size: 1.2rem; margin-right: 12px; width: 24px; text-align: center;"></i>
                    <span>Management</span>
                    <i class="bi bi-chevron-down ms-auto dropdown-icon"></i>
                </a>
                <div class="collapse {{ $isManagementActive ? 'show' : '' }}" id="collapseManagement">
                    <div class="nav-submenu">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.services.index') }}"
                                class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2"></i> <span>Services</span>
                            </a>
                            <a href="{{ route('admin.locations.index') }}"
                                class="{{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                                <i class="bi bi-geo-alt"></i> <span>Locations</span>
                            </a>
                            <a href="{{ route('admin.team.index') }}"
                                class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                                <i class="bi bi-people"></i> <span>Team Members</span>
                            </a>
                            <a href="{{ route('admin.news.index') }}"
                                class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                                <i class="bi bi-newspaper"></i> <span>News & Blog</span>
                            </a>
                            <a href="{{ route('admin.faq.index') }}"
                                class="{{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
                                <i class="bi bi-question-circle"></i> <span>FAQs</span>
                            </a>
                            <a href="{{ route('admin.trustpilot-reviews.index') }}"
                                class="{{ request()->routeIs('admin.trustpilot-reviews.*') ? 'active' : '' }}">
                                <i class="bi bi-star"></i> <span>Trustpilot Reviews</span>
                            </a>
                            <a href="{{ route('admin.work-steps.index') }}"
                                class="{{ request()->routeIs('admin.work-steps.*') ? 'active' : '' }}">
                                <i class="bi bi-list-check"></i> <span>How It Works</span>
                            </a>
                            <a href="{{ route('admin.property-offers.all') }}"
                                class="{{ request()->routeIs('admin.property-offers.all') ? 'active' : '' }}">
                                <i class="bi bi-currency-pound"></i> <span>Offers List</span>
                            </a>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.inquiries.index') }}"
                                class="{{ request()->routeIs('admin.inquiries.*') && !request()->has('type') ? 'active' : '' }}">
                                <i class="bi bi-envelope-fill"></i>
                                <span>General Inquiries</span>
                            </a>

                            <a href="{{ route('admin.inquiries.index', ['type' => 'property']) }}"
                                class="{{ request()->routeIs('admin.inquiries.*') && request()->get('type') == 'property' ? 'active' : '' }}">
                                <i class="bi bi-building-check"></i>
                                <span>Property Inquiries</span>
                            </a>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.messages.index') }}"
                                class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                                <i class="bi bi-chat-dots-fill"></i>
                                <span>Messages</span>
                            </a>
                        @endif

                        <a href="{{ route('admin.investors.index') }}"
                            class="{{ request()->routeIs('admin.investors.*') ? 'active' : '' }}">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Investor List</span>
                        </a>

                        <a href="{{ route('available-properties.index') }}"
                            class="{{ request()->routeIs('available-properties.index') && !request()->has('status') ? 'active' : '' }}">
                            <i class="bi bi-search"></i>
                            <span>Search Properties</span>
                        </a>
                    </div>
                </div>

                @php
                    $isPropertyMgmtActive = request()->routeIs('admin.available-properties.*');
                @endphp
                <a class="{{ $isPropertyMgmtActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                    href="#collapsePropertyMgmt" role="button"
                    aria-expanded="{{ $isPropertyMgmtActive ? 'true' : 'false' }}"
                    style="display: flex; align-items: center; padding: 14px 20px; color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: all 0.3s ease; position: relative; font-weight: 500;">
                    <i class="bi bi-building"
                        style="font-size: 1.2rem; margin-right: 12px; width: 24px; text-align: center;"></i>
                    <span>Property Management</span>
                    <i class="bi bi-chevron-down ms-auto dropdown-icon"></i>
                </a>
                <div class="collapse {{ $isPropertyMgmtActive ? 'show' : '' }}" id="collapsePropertyMgmt">
                    <div class="nav-submenu">
                        <a href="{{ route('admin.available-properties.index') }}"
                            class="{{ request()->routeIs('admin.available-properties.index') && !request()->has('status') ? 'active' : '' }}">
                            <i class="bi bi-building"></i>
                            <span>My Properties</span>
                        </a>
                        <a href="{{ route('admin.available-properties.create') }}"
                            class="{{ request()->routeIs('admin.available-properties.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle"></i>
                            <span>Add a Property</span>
                        </a>
                        <a href="{{ route('admin.available-properties.index', ['status' => 'draft']) }}"
                            class="{{ request()->get('status') == 'draft' ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>My Drafts</span>
                        </a>
                        <a href="{{ route('admin.available-properties.index', ['status' => 'published']) }}"
                            class="{{ request()->get('status') == 'published' ? 'active' : '' }}">
                            <i class="bi bi-broadcast"></i>
                            <span>Published Listings</span>
                        </a>
                        <a href="{{ route('admin.available-properties.index', ['status' => 'sold']) }}"
                            class="{{ request()->get('status') == 'sold' ? 'active' : '' }}">
                            <i class="bi bi-check-all"></i>
                            <span>Sold Listings</span>
                        </a>
                        <a href="{{ route('admin.available-properties.index', ['status' => 'under_offer']) }}"
                            class="{{ request()->get('status') == 'under_offer' ? 'active' : '' }}">
                            <i class="bi bi-hourglass-split"></i>
                            <span>Under Offer</span>
                        </a>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                    @php
                        $isFormSettingsActive = request()->routeIs('admin.property-types.*', 'admin.marketing-purposes.*', 'admin.unit-types.*', 'admin.features.*');
                    @endphp
                    <a class="{{ $isFormSettingsActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                        href="#collapseFormSettings" role="button"
                        aria-expanded="{{ $isFormSettingsActive ? 'true' : 'false' }}"
                        style="display: flex; align-items: center; padding: 14px 20px; color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: all 0.3s ease; position: relative; font-weight: 500;">
                        <i class="bi bi-ui-checks"
                            style="font-size: 1.2rem; margin-right: 12px; width: 24px; text-align: center;"></i>
                        <span>Form Settings</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-icon"></i>
                    </a>
                    <div class="collapse {{ $isFormSettingsActive ? 'show' : '' }}" id="collapseFormSettings">
                        <div class="nav-submenu">
                            <a href="{{ route('admin.property-types.index') }}"
                                class="{{ request()->routeIs('admin.property-types.*') ? 'active' : '' }}">
                                <i class="bi bi-house-door"></i> <span>Property Types</span>
                            </a>
                            <a href="{{ route('admin.marketing-purposes.index') }}"
                                class="{{ request()->routeIs('admin.marketing-purposes.*') ? 'active' : '' }}">
                                <i class="bi bi-tag"></i> <span>Marketing Purposes</span>
                            </a>
                            <a href="{{ route('admin.unit-types.index') }}"
                                class="{{ request()->routeIs('admin.unit-types.*') ? 'active' : '' }}">
                                <i class="bi bi-grid"></i> <span>Unit Types</span>
                            </a>
                            <a href="{{ route('admin.features.index') }}"
                                class="{{ request()->routeIs('admin.features.*') ? 'active' : '' }}">
                                <i class="bi bi-check-square"></i> <span>Features</span>
                            </a>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Investor / Regular User Menu -->
            @if(!in_array(auth()->user()->role, ['admin', 'agent']))
                @php
                    $isActivitiesActive = request()->routeIs('user.profile.*', 'user.offers.*', 'user.favorites.*', 'admin.messages.*', 'available-properties.index');
                @endphp
                <a class="{{ $isActivitiesActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#collapseActivities"
                    role="button" aria-expanded="{{ $isActivitiesActive ? 'true' : 'false' }}"
                    style="display: flex; align-items: center; padding: 14px 20px; color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: all 0.3s ease; position: relative; font-weight: 500;">
                    <i class="bi bi-person-lines-fill"
                        style="font-size: 1.2rem; margin-right: 12px; width: 24px; text-align: center;"></i>
                    <span>My Activities</span>
                    <i class="bi bi-chevron-down ms-auto dropdown-icon"></i>
                </a>
                <div class="collapse {{ $isActivitiesActive ? 'show' : '' }}" id="collapseActivities">
                    <div class="nav-submenu">
                        <a href="{{ route('user.profile.edit') }}"
                            class="{{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                            <i class="bi bi-person-gear"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ route('user.offers.index') }}"
                            class="{{ request()->routeIs('user.offers.*') ? 'active' : '' }}">
                            <i class="bi bi-currency-pound"></i>
                            <span>My Offers</span>
                        </a>
                        <a href="{{ route('user.favorites.index') }}"
                            class="{{ request()->routeIs('user.favorites.*') ? 'active' : '' }}">
                            <i class="bi bi-heart"></i>
                            <span>Favorites</span>
                        </a>
                        <!-- Messages Link for User -->
                        <a href="{{ route('admin.messages.index') }}"
                            class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                            <i class="bi bi-chat-dots"></i>
                            <span>Messages</span>
                        </a>
                        <a href="{{ route('available-properties.index') }}"
                            class="{{ request()->routeIs('available-properties.index') ? 'active' : '' }}">
                            <i class="bi bi-search"></i>
                            <span>Find Properties</span>
                        </a>
                    </div>
                </div>
            @endif

            <div class="nav-section-title">System</div>
            <a href="{{ route('home') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>View Website</span>
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mt-3">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </nav>
    </div>

    <!-- Topbar -->
    <div class="admin-topbar">
        <div class="mobile-toggle me-3" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </div>
        <div class="topbar-search position-relative">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control" placeholder="Search...">
        </div>

        <div class="topbar-actions">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.inquiries.index') }}" class="topbar-btn text-decoration-none">
                    <i class="bi bi-bell"></i>
                </a>
            @endif
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.messages.index') }}" class="topbar-btn text-decoration-none">
                    <i class="bi bi-envelope"></i>
                </a>
            @endif
            <div class="dropdown">
                <div class="user-dropdown dropdown-toggle" id="userMenu" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span class="fw-600 d-none d-md-inline">{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down small"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 mt-2" aria-labelledby="userMenu">
                    <li>
                        <a class="dropdown-item rounded p-2" href="{{ route('user.profile.edit') }}">
                            <i class="bi bi-person-circle me-2 text-primary"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item rounded p-2 text-danger" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggle && sidebar && overlay) {
                toggle.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });

                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>