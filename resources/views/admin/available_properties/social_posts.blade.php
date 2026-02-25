@extends('layouts.admin')

@section('title', 'Social Post Preview')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Social Post Preview</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.available-properties.index') }}">Properties</a>
                        </li>
                        <li class="breadcrumb-item active">Social Posts</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.available-properties.social-posts', ['id' => $property->id, 'refresh' => 1]) }}"
                    class="btn btn-warning text-white">
                    <i class="bi bi-arrow-clockwise me-1"></i>Regenerate Posts
                </a>
                <a href="{{ route('admin.available-properties.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-instagram me-2"></i>Instagram Carousel for: {{ $property->headline }}
                    </h5>
                </div>
                <div class="card-body">
                    @if($property->generated_posts)
                        <div class="row g-4">
                            @foreach($property->generated_posts as $index => $postPath)
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                        <div class="card-header bg-light py-2 text-center fw-bold">
                                            @if($index == 0)
                                                Cover Slide
                                            @elseif(strpos($postPath, 'contact.jpg') !== false)
                                                Contact Slide
                                            @else
                                                Gallery Slide {{ $index }}
                                            @endif
                                        </div>
                                        <img src="{{ asset($postPath) }}" class="img-fluid" alt="Slide">
                                        <div class="card-footer bg-white text-center">
                                            <a href="{{ asset($postPath) }}" download class="btn btn-sm btn-admin-pink">
                                                <i class="bi bi-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            No social posts generated yet. They are usually generated automatically in the background.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-admin-pink {
            background-color: #F95CA8;
            color: white;
            border: none;
        }

        .btn-admin-pink:hover {
            background-color: #e04a91;
            color: white;
        }
    </style>
@endpush