@extends('layouts.app')

@section('content')
    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header border-0 pt-4 text-center"
                        style="background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-pink) 100%);">
                        <h2 class="fw-bold text-white">Reset Password</h2>
                        <p class="text-white-50 small">Enter your email address and we'll send you a link to reset your
                            password.</p>
                    </div>
                    <div class="card-body p-4 p-md-5 pt-2">
                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm small mb-4"
                                style="background-color: rgba(76, 215, 246, 0.15); color: #1E4072;">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm small mb-4"
                                style="background-color: rgba(249, 92, 168, 0.15); color: #1E4072;">
                                @foreach ($errors->all() as $error)
                                    <div class="mb-0">{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label small fw-600 tracking-wider" style="color: #1E4072;">Email
                                    Address</label>
                                <div class="input-group-modern">
                                    <i class="bi bi-envelope icon"></i>
                                    <input type="email" name="email" class="form-control" placeholder="your@email.com"
                                        value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-custom-pink w-100 py-3 mb-3 rounded-3 fw-bold">
                                Send Reset Link <i class="bi bi-send ms-2"></i>
                            </button>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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
            height: 50px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .input-group-modern .form-control:focus {
            background-color: #fff;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 4px rgba(249, 92, 168, 0.2);
        }

        .fw-600 {
            font-weight: 600;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }
    </style>
@endsection