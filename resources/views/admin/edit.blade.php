@extends('layouts.admin')

@section('title', 'Edit Property')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Edit Sold Property</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Property</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-pencil-square me-2"></i>Update Property Details</h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.update', $property->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Location</label>
                            <input type="text" name="location" class="form-control"
                                value="{{ old('location', $property->location) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5"
                                required>{{ old('description', $property->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">BMV Percentage</label>
                                <div class="input-group">
                                    <input type="text" name="bmv_percentage" class="form-control"
                                        value="{{ old('bmv_percentage', $property->bmv_percentage) }}" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Property Image</label>
                                @if($property->image_url)
                                    <div class="mb-2">
                                        <img src="{{ Str::startsWith($property->image_url, 'http') ? $property->image_url : asset('storage/' . $property->image_url) }}"
                                            style="height: 100px; width: 150px; object-fit: cover;"
                                            class="rounded border shadow-sm">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image-input" class="form-control" accept="image/*">
                                <div id="image-preview" class="mt-3"></div>
                                <div class="form-text">Leave blank to keep current image</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light border px-4">Cancel</a>
                            <button type="submit" class="btn btn-admin-primary px-4">
                                <i class="bi bi-arrow-repeat me-2"></i>Update Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');

        document.getElementById('image-input').addEventListener('change', function (e) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<p class="small text-muted mb-1">New Selection Preview:</p><img src="${e.target.result}" class="img-fluid rounded shadow-sm" style="max-height: 200px;">`;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush