@extends('layouts.app')

@section('content')
    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="login-container shadow-lg">
                    <div class="row g-0">
                        <!-- Left Side: Decorative/Information -->
                        <div class="col-lg-5 d-none d-lg-flex login-hero" style="background: linear-gradient(rgba(30, 64, 114, 0.9), rgba(30, 64, 114, 0.9)), 
                                    url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); 
                                    background-size: cover; background-position: center;">
                            <div class="p-5 text-white w-100 mt-auto">
                                <h2 class="display-6 fw-bold mb-3">Welcome Back!</h2>
                                <p class="opacity-75 mb-4">Log in to your account to manage your property portfolio and
                                    track your investment opportunities.</p>

                                <div class="login-feature mb-3">
                                    <i class="bi bi-check2-circle text-pink me-2"></i>
                                    <span class="small opacity-75">Access Exclusive Deals</span>
                                </div>
                                <div class="login-feature mb-3">
                                    <i class="bi bi-check2-circle text-pink me-2"></i>
                                    <span class="small opacity-75">Track Inquiries</span>
                                </div>
                                <div class="login-feature mb-5">
                                    <i class="bi bi-check2-circle text-pink me-2"></i>
                                    <span class="small opacity-75">Personalized Dashboard</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Form -->
                        <div class="col-lg-7 bg-white p-4 p-md-5">
                            <div class="text-center mb-5">
                                <h2 class="fw-bold text-blue">Sign In</h2>
                                <p class="text-muted small">Please enter your credentials to access your account</p>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success border-0 shadow-sm small py-2 mb-4 text-center">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm small py-2 mb-4 text-center">
                                    @foreach ($errors->all() as $error)
                                        <div class="mb-0">{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{ route('login.submit') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label small fw-600 text-uppercase tracking-wider">Email
                                        Address</label>
                                    <div class="input-group-modern">
                                        <i class="bi bi-envelope icon"></i>
                                        <input type="email" name="email" class="form-control" placeholder="your@email.com"
                                            value="{{ old('email') }}" required autofocus>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <label
                                            class="form-label small fw-600 text-uppercase tracking-wider">Password</label>
                                        <a href="{{ route('password.request') }}"
                                            class="text-pink small text-decoration-none fw-bold">Forgot?</a>
                                    </div>
                                    <div class="input-group-modern">
                                        <i class="bi bi-lock icon"></i>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="••••••••" required>
                                        <i class="bi bi-eye-slash toggle-password" data-target="password"></i>
                                    </div>
                                </div>

                                <div class="mb-4 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input custom-check" type="checkbox" name="remember"
                                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label small text-muted ms-1" for="remember">
                                            Keep me signed in
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-custom-pink w-100 py-3 mb-4 rounded-3 fs-5">
                                    Sign In <i class="bi bi-box-arrow-in-right ms-2"></i>
                                </button>

                                <div class="text-center">
                                    <p class="text-muted small">Don't have an account yet?
                                        <a href="{{ route('register') }}"
                                            class="text-pink fw-bold text-decoration-none">Create Account</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password Toggle Logic
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.remove('bi-eye-slash');
                        this.classList.add('bi-eye');
                    } else {
                        input.type = 'password';
                        this.classList.remove('bi-eye');
                        this.classList.add('bi-eye-slash');
                    }
                });
            });
        });
    </script>

    <style>
        .login-container {
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            min-height: 550px;
        }

        .login-hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .input-group-modern {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-modern .icon {
            position: absolute;
            left: 15px;
            color: #adb5bd;
            font-size: 1.1rem;
            z-index: 5;
        }

        .input-group-modern .form-control {
            padding-left: 45px;
            padding-right: 45px;
            height: 50px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .input-group-modern .toggle-password {
            position: absolute;
            right: 15px;
            color: #adb5bd;
            cursor: pointer;
            z-index: 5;
            transition: color 0.3s ease;
        }

        .input-group-modern .toggle-password:hover {
            color: var(--primary-pink);
        }

        .input-group-modern .form-control:focus {
            background-color: #fff;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 4px rgba(249, 92, 168, 0.1);
        }

        .custom-check:checked {
            background-color: var(--primary-pink);
            border-color: var(--primary-pink);
        }

        .fw-600 {
            font-weight: 600;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        @media (max-width: 991.98px) {
            .login-container {
                border-radius: 15px;
                min-height: auto;
            }
        }
    </style>
@endsection