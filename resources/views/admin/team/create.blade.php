@extends('layouts.admin')

@section('title', 'Add Team Member')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold">Add New Team Member</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.team.index') }}">Meet The Team</a></li>
                    <li class="breadcrumb-item active">Add Member</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="content-card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                @if($errors->any())
                    <div class="alert alert-danger shadow-sm border-0">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Role / Title</label>
                            <input type="text" name="role" class="form-control" value="{{ old('role') }}" placeholder="e.g. CEO or Director" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Team Category</label>
                            <select name="category" class="form-select" required>
                                <option value="Leadership Team" {{ old('category') == 'Leadership Team' ? 'selected' : '' }}>Leadership Team</option>
                                <option value="Investment Team" {{ old('category') == 'Investment Team' ? 'selected' : '' }}>Investment Team</option>
                                <option value="Vendor Team" {{ old('category') == 'Vendor Team' ? 'selected' : '' }}>Vendor Team</option>
                                <option value="Marketing Team" {{ old('category') == 'Marketing Team' ? 'selected' : '' }}>Marketing Team</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Profile Image</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-image"></i></span>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <small class="text-muted">Recommended: Square image (800x800px)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">LinkedIn URL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-linkedin text-primary"></i></span>
                                <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small text-uppercase">Short Bio</label>
                            <textarea name="bio" class="form-control" rows="5" placeholder="Write a brief professional biography...">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-5 pt-4 border-top d-flex justify-content-end">
                        <button type="submit" class="btn btn-admin-pink px-5 py-2 fw-bold">
                            <i class="bi bi-person-check-fill me-2"></i> Save Member Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection