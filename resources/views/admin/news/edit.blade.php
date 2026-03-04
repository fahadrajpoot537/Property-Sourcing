@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Edit Blog Post</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">Blogs</a></li>
                        <li class="breadcrumb-item active">Edit Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <!-- Content Section -->
                <div class="content-card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-file-earmark-text me-2"></i>Post Content</h5>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Post Title</label>
                            <input type="text" name="title" class="form-control form-control-lg"
                                value="{{ old('title', $news->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Short Excerpt</label>
                            <textarea name="excerpt" class="form-control"
                                rows="3">{{ old('excerpt', $news->excerpt) }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Post Content</label>
                            <textarea name="content" id="editor"
                                class="form-control">{{ old('content', $news->content) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SEO Section -->
                <div class="content-card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-search me-2"></i>SEO Optimization</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                value="{{ old('meta_title', $news->meta_title) }}" placeholder="SEO Title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"
                                placeholder="SEO Description...">{{ old('meta_description', $news->meta_description) }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                value="{{ old('meta_keywords', $news->meta_keywords) }}"
                                placeholder="property, sourcing...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Publishing Section -->
                <div class="content-card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-send me-2"></i>Publishing</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Author Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" name="author_name" class="form-control"
                                    value="{{ old('author_name', $news->author_name) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Publish Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" name="published_at" class="form-control"
                                    value="{{ old('published_at', $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-admin-primary py-3 fw-bold">
                                <i class="bi bi-arrow-repeat me-2"></i>Update Blog Post
                            </button>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-light border py-2">Cancel</a>
                        </div>
                    </div>
                </div>

                <!-- Media Section -->
                <div class="content-card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-blue"><i class="bi bi-image me-2"></i>Featured Image</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            @if($news->image_url)
                                <div class="mb-3 text-center">
                                    <img src="{{ asset('storage/' . $news->image_url) }}"
                                        class="rounded img-fluid border shadow-sm" style="max-height: 200px;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor', {
            height: 400
        });
    </script>
@endpush