@extends('layouts.admin')

@section('title', 'Add Service')

@section('content')
    <div class="container mt-5" style="max-width: 900px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Create New Service Page</h3>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <!-- Basic Info -->
            <div class="form-section">
                <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Service Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug (Optional)</label>
                        <input type="text" name="slug" class="form-control" placeholder="auto-generated">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Icon Class (Bootstrap Icons)</label>
                        <input type="text" name="icon" class="form-control" placeholder="bi-house">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hero Image URL</label>
                        <input type="url" name="hero_image_url" class="form-control" placeholder="https://...">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Short Description (Hero Text)</label>
                        <textarea name="short_description" class="form-control" rows="2" required></textarea>
                    </div>
                </div>
            </div>

            <!-- Author Info -->
            <div class="form-section">
                <h5 class="mb-3 border-bottom pb-2">Author Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Author Name</label>
                        <input type="text" name="author_name" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Author Image</label>
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
                    <!-- Sections will be added here -->
                </div>
            </div>

            <!-- FAQs -->
            <div class="form-section">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h5 class="mb-0">FAQs</h5>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addFaq()">+ Add FAQ</button>
                </div>
                <div id="faqs-container">
                    <!-- FAQs will be added here -->
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 mb-5">Create Service Page</button>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        let sectionCount = 0;
        let faqCount = 0;

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