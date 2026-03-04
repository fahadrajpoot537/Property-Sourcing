@extends('layouts.admin')

@section('title', 'Edit Team Member')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold">Edit Team Member</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.team.index') }}">Meet The Team</a></li>
                    <li class="breadcrumb-item active">Edit Member</li>
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
                <div class="d-flex align-items-center mb-4">
                    @if($member->image_url)
                        <img src="{{ asset('storage/' . $member->image_url) }}" class="rounded-circle shadow-sm me-3" width="70" height="70" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" width="70" height="70">
                            <i class="bi bi-person text-muted fs-2"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $member->name }}</h4>
                        <span class="text-muted">{{ $member->role }}</span>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger shadow-sm border-0">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.team.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $member->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Role / Title</label>
                            <input type="text" name="role" class="form-control" value="{{ old('role', $member->role) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Team Category</label>
                            <select name="category" class="form-select" required>
                                @foreach(['Leadership Team', 'Investment Team', 'Vendor Team', 'Marketing Team'] as $cat)
                                    <option value="{{ $cat }}" {{ (old('category', $member->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $member->sort_order) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Update Profile Image</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-image"></i></span>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <small class="text-muted">Recommended: Square image (800x800px). Leave empty to keep current.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">LinkedIn URL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-linkedin text-primary"></i></span>
                                <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $member->linkedin_url) }}" placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small text-uppercase">Short Bio</label>
                            <textarea name="bio" class="form-control" rows="5" placeholder="Write a brief professional biography...">{{ old('bio', $member->bio) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-5 pt-4 border-top d-flex justify-content-end">
                        <button type="submit" class="btn btn-admin-pink px-5 py-2 fw-bold">
                            <i class="bi bi-check-circle-fill me-2"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection