@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
    <div class="container mt-5" style="max-width: 900px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Edit Service: {{ $service->title }}</h3>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div class="form-section">
                <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Service Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $service->title }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ $service->slug }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Icon Class</label>
                        <input type="text" name="icon" class="form-control" value="{{ $service->icon }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hero Image</label>
                        @if($service->hero_image_url)
                            <div class="mb-2"><img src="{{ asset('storage/' . $service->hero_image_url) }}" height="50">
                            </div>
                        @endif
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="2"
                            required>{{ $service->short_description }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Author Info -->
            <div class="form-section">
                <h5 class="mb-3 border-bottom pb-2">Author Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Author Name</label>
                        <input type="text" name="author_name" class="form-control" value="{{ $service->author_name }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Author Image</label>
                        @if($service->author_image_url)
                            <div class="mb-2"><img src="{{ asset('storage/' . $service->author_image_url) }}" height="50">
                            </div>
                        @endif
                        <input type="file" name="author_image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- Content Builder -->
            <div class="form-section">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h5 class="mb-0">Content Sections</h5>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addSection()">+ Add Section</button>
                </div>
                <div id="sections-container">
                    @foreach($service->sections as $index => $section)
                        <div class="block-item" id="section-{{ $index }}">
                            <button type="button" class="btn btn-sm btn-danger remove-btn"
                                onclick="removeElement('section-{{ $index }}')">X</button>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Layout Type</label>
                                    <select name="sections[{{ $index }}][type]" class="form-select">
                                        <option value="text_block" {{ $section->type == 'text_block' ? 'selected' : '' }}>Text
                                            Only</option>
                                        <option value="image_left" {{ $section->type == 'image_left' ? 'selected' : '' }}>
                                            Image Left / Text Right</option>
                                        <option value="image_right" {{ $section->type == 'image_right' ? 'selected' : '' }}>
                                            Text Left / Image Right</option>
                                        <option value="full_width_image" {{ $section->type == 'full_width_image' ? 'selected' : '' }}>Full Width Image</option>
                                    </select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Heading</label>
                                    <input type="text" name="sections[{{ $index }}][heading]" class="form-control"
                                        value="{{ $section->heading }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Content</label>
                                    <textarea name="sections[{{ $index }}][content]" class="form-control"
                                        rows="4">{{ $section->content }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Image</label>
                                    @if($section->image_url)
                                        <div class="mb-2"><img src="{{ asset('storage/' . $section->image_url) }}" height="50">
                                        </div>
                                    @endif
                                    <input type="file" name="sections[{{ $index }}][image]" class="form-control"
                                        accept="image/*">
                                    <input type="hidden" name="sections[{{ $index }}][image_url]"
                                        value="{{ $section->image_url }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- FAQs -->
            <div class="form-section">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h5 class="mb-0">FAQs</h5>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addFaq()">+ Add FAQ</button>
                </div>
                <div id="faqs-container">
                    @foreach($service->faqs as $index => $faq)
                        <div class="block-item" id="faq-{{ $index }}">
                            <button type="button" class="btn btn-sm btn-danger remove-btn"
                                onclick="removeElement('faq-{{ $index }}')">X</button>
                            <div class="mb-2">
                                <label class="form-label fw-bold">Question</label>
                                <input type="text" name="faqs[{{ $index }}][question]" class="form-control"
                                    value="{{ $faq->question }}" required>
                            </div>
                            <div>
                                <label class="form-label">Answer</label>
                                <textarea name="faqs[{{ $index }}][answer]" class="form-control" rows="2"
                                    required>{{ $faq->answer }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 mb-5">Update Service Page</button>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        // Start count higher than existing items to avoid ID conflicts
        let sectionCount = {{ $service->sections->count() + 10 }};
        let faqCount = {{ $service->faqs->count() + 10 }};

        // Initialize CKEditor for existing sections
        @foreach($service->sections as $index => $section)
            CKEDITOR.replace('sections[{{ $index }}][content]');
        @endforeach

            function addSection() {
                const container = document.getElementById('sections-container');
                const html = `
                        <div class="block-item" id="section-${sectionCount}">
                            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeElement('section-${sectionCount}')">X</button>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Layout Type</label>
                                    <select name="sections[${sectionCount}][type]" class="form-select">
                                        <option value="text_block">Text Only</option>
                                        <option value="image_left">Image Left / Text Right</option>
                                        <option value="image_right">Text Left / Image Right</option>
                                        <option value="full_width_image">Full Width Image</option>
                                    </select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Heading (Optional)</label>
                                    <input type="text" name="sections[${sectionCount}][heading]" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Content / Text</label>
                                    <textarea name="sections[${sectionCount}][content]" id="editor-${sectionCount}" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Upload Image</label>
                                    <input type="file" name="sections[${sectionCount}][image]" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>
                    `;
                container.insertAdjacentHTML('beforeend', html);
                CKEDITOR.replace(`editor-${sectionCount}`);
                sectionCount++;
            }

        function addFaq() {
            const container = document.getElementById('faqs-container');
            const html = `
                        <div class="block-item" id="faq-${faqCount}">
                            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeElement('faq-${faqCount}')">X</button>
                            <div class="mb-2">
                                <label class="form-label fw-bold">Question</label>
                                <input type="text" name="faqs[${faqCount}][question]" class="form-control" required>
                            </div>
                            <div>
                                <label class="form-label">Answer</label>
                                <textarea name="faqs[${faqCount}][answer]" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>
                    `;
            container.insertAdjacentHTML('beforeend', html);
            faqCount++;
        }

        function removeElement(id) {
            document.getElementById(id).remove();
        }
    </script>
@endsection