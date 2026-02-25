@extends('layouts.admin')

@section('title', 'Registered Users')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Registered Investors</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Investors</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stats-card blue">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Investors</p>
                        <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Pending Approval</p>
                        <h3 class="mb-0">{{ \App\Models\User::where('status', 0)->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stats-card success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Approved Investors</p>
                        <h3 class="mb-0">{{ \App\Models\User::where('status', 1)->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Users Table -->
    <div class="content-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Investor Accounts</h5>
            
            <!-- Filters -->
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search name or email..." value="{{ request('search') }}">
                </div>
                
                <select name="role" class="form-select form-select-sm" style="width: 130px;" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Investor</option>
                    <option value="agent" {{ request('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                
                <select name="status" class="form-select form-select-sm" style="width: 130px;" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Approved</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                </select>
                
                @if(request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Investor Details</th>
                            <th>Role</th>
                            <th>Contact</th>
                            <th>Investment Interest</th>
                            <th>Status</th>
                            <th>Joined Date</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; color: var(--primary-blue)">
                                            <i class="bi bi-person fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <div class="small text-muted">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'agent' ? 'bg-primary' : 'bg-secondary') }} text-capitalize">
                                        {{ $user->role === 'user' ? 'Investor' : $user->role }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->phone)
                                        <div class="small text-muted">
                                            <i class="bi bi-telephone me-2"></i>{{ $user->phone }}
                                        </div>
                                    @else
                                        <span class="text-muted small">No Phone</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->investment_type)
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                            {{ $user->investment_type }}
                                        </span>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i>Approved
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                            <i class="bi bi-hourglass-split me-1"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-center pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Manage
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            @if($user->status == 0)
                                                <li>
                                                    <form action="{{ route('admin.users.status', $user) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="dropdown-item py-2">
                                                            <i class="bi bi-check-lg text-success me-2"></i>Approve Account
                                                        </button>
                                                    </form>
                                                </li>
                                            @else
                                                <li>
                                                    <form action="{{ route('admin.users.status', $user) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="0">
                                                        <button type="submit" class="dropdown-item py-2">
                                                            <i class="bi bi-x-circle text-warning me-2"></i>Set to Pending
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            
                                            @if($user->role !== 'admin')
                                                <li><hr class="dropdown-divider opacity-10"></li>
                                                @if($user->role === 'user')
                                                    <li>
                                                        <form action="{{ route('admin.users.role', $user) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="role" value="agent">
                                                            <button type="submit" class="dropdown-item py-2">
                                                                <i class="bi bi-person-badge text-primary me-2"></i>Make Agent
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <form action="{{ route('admin.users.role', $user) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="role" value="user">
                                                            <button type="submit" class="dropdown-item py-2">
                                                                <i class="bi bi-person text-secondary me-2"></i>Make Investor
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            @endif
                                            
                                            @if($user->role !== 'admin')
                                                <li><hr class="dropdown-divider opacity-10"></li>
                                                <li>
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user account?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                                            <i class="bi bi-trash me-2"></i>Delete User
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                        No registered users found.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="p-4 border-top">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
