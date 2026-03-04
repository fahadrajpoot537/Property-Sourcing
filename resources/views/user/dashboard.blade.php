@extends('layouts.admin')

@section('title', 'My Dashboard')

@section('content')
    <div class="container py-5">
        <div class="row mb-5 align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold text-blue">Welcome, {{ $user->name }} to your Investor Dashboard!</h1>
                <p class="text-muted lead">Manage your property investment journey from your personal dashboard.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('available-properties.index') }}" class="btn btn-custom-pink fw-bold px-4 py-2">
                    <i class="bi bi-search me-2"></i>Find Properties
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row g-4 mb-5">
            <!-- My Offers -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-blue text-white overflow-hidden position-relative">
                    <div class="card-body p-4 position-relative z-1">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <i class="bi bi-tag-fill fs-3 text-cyan"></i>
                            <span class="badge bg-light text-blue rounded-pill px-3">Active</span>
                        </div>
                        <h2 class="display-4 fw-bold mb-1">{{ $offersCount }}</h2>
                        <p class="mb-0 opacity-75">My Offers</p>
                        <a href="{{ route('user.offers.index') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <!-- Favorite Properties -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden position-relative">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <i class="bi bi-heart-fill fs-3 text-pink"></i>
                        </div>
                        <h2 class="display-4 fw-bold mb-1 text-blue">{{ $favoritesCount }}</h2>
                        <p class="text-muted mb-0">Favorite Properties</p>
                        <a href="{{ route('user.favorites.index') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <!-- Unread Messages -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden position-relative">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <i class="bi bi-chat-dots-fill fs-3 text-dark"></i>
                            @if($unreadMessagesCount > 0)
                                <span class="badge bg-danger rounded-pill px-3">{{ $unreadMessagesCount }} New</span>
                            @endif
                        </div>
                        <h2 class="display-4 fw-bold mb-1 text-blue">{{ $unreadMessagesCount }}</h2>
                        <p class="text-muted mb-0">Unread Messages</p>
                        <a href="{{ route('admin.messages.index') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <!-- Investment Credits -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden position-relative">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <i class="bi bi-trophy-fill fs-3 text-warning"></i>
                        </div>
                        <h2 class="display-4 fw-bold mb-1 text-blue">{{ $user->investment_credits ?? 0 }}</h2>
                        <p class="text-muted mb-0">Investment Credits</p>
                        <a href="{{ route('user.credits.index') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Menu Grid -->
        <h4 class="fw-bold text-blue mb-4">Quick Actions</h4>
        <div class="row g-4">
            <!-- Edit Profile -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('user.profile.edit') }}"
                    class="card text-decoration-none h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-person-gear fs-4 text-primary"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Edit Profile</h5>
                        <p class="text-muted small mb-0">Update your details</p>
                    </div>
                </a>
            </div>

            <!-- My Offers -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('user.offers.index') }}"
                    class="card text-decoration-none h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-currency-pound fs-4 text-success"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">My Offers</h5>
                        <p class="text-muted small mb-0">Track your bids</p>
                    </div>
                </a>
            </div>

            <!-- My Messages -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.messages.index') }}"
                    class="card text-decoration-none h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-envelope fs-4 text-info"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Messages</h5>
                        <p class="text-muted small mb-0">Chat with agents</p>
                    </div>
                </a>
            </div>

            <!-- Favorites -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('user.favorites.index') }}"
                    class="card text-decoration-none h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-heart fs-4 text-danger"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Favorites</h5>
                        <p class="text-muted small mb-0">Saved properties</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection