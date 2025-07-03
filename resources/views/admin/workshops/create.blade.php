@extends('admin.layouts.app')

@section('title', 'Add New Workshop')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .image-preview {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .image-preview-item {
        position: relative;
        width: 150px;
        height: 150px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        width: 25px;
        height: 25px;
        text-align: center;
        line-height: 25px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Workshop</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshops.index') }}">Workshops</a></li>
        <li class="breadcrumb-item active">Add New</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Workshop Information
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.workshops.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name_en" class="form-label">English Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en') }}" required>
                                    @error('name_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name_ar" class="form-label">Arabic Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar') }}" dir="rtl" required>
                                    @error('name_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="description_en" class="form-label">English Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="4" required>{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="description_ar" class="form-label">Arabic Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" rows="4" dir="rtl" required>{{ old('description_ar') }}</textarea>
                            @error('description_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="target_age_group" class="form-label">Target Age Group <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('target_age_group') is-invalid @enderror" id="target_age_group" name="target_age_group" value="{{ old('target_age_group') }}" required>
                            @error('target_age_group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Example: "5-7 years", "8-12 years", "Adults", "All ages"</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="skills_developed" class="form-label">Skills Developed</label>
                            <input type="text" class="form-control @error('skills_developed') is-invalid @enderror" id="skills_developed" name="skills_developed" value="{{ old('skills_developed') }}">
                            @error('skills_developed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Comma-separated list of skills (e.g., "Creativity, Problem-solving, Teamwork")</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-images me-1"></i>
                                Workshop Image
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="image_path" class="form-label">Main Image</label>
                                            <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image" accept="image/*">
                                            @error('image_path')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">This will be the primary image shown for the workshop.</small>
                                            <div id="main-image-preview-container" class="mt-2 d-none">
                                                <div class="d-flex align-items-center mb-2">
                                                    <button type="button" id="remove_image_btn" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                                        <i class="fas fa-trash me-1"></i> Remove image
                                                    </button>
                                                </div>
                                                <img id="main-image-preview" src="#" alt="Main image preview" class="img-thumbnail" style="max-height: 150px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-cog me-1"></i>
                                Workshop Settings
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                    <small class="form-text text-muted d-block">Inactive workshops won't be visible to users.</small>
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured Workshop</label>
                                    <small class="form-text text-muted d-block">Featured workshops may be highlighted on the homepage.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.workshops.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Workshop</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Image Removal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmModalBody">
                Are you sure you want to remove this image?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmRemoveBtn">Remove</button>
            </div>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="resultModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap modals
        const confirmModalEl = document.getElementById('confirmModal');
        const resultModalEl = document.getElementById('resultModal');
        
        if (!confirmModalEl || !resultModalEl) {
            console.error('Modal elements not found');
            return;
        }
        
        const confirmModal = new bootstrap.Modal(confirmModalEl);
        const resultModal = new bootstrap.Modal(resultModalEl);
        
        // Main image preview
        const mainImageInput = document.getElementById('image_path');
        const mainImagePreview = document.getElementById('main-image-preview');
        const mainImagePreviewContainer = document.getElementById('main-image-preview-container');
        const removeMainImageBtn = document.getElementById('remove_image_btn');

        if (mainImageInput) {
            mainImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        mainImagePreview.src = e.target.result;
                        mainImagePreviewContainer.classList.remove('d-none');
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Remove image functionality
        if (removeMainImageBtn) {
            removeMainImageBtn.addEventListener('click', function() {
                // Show the confirmation modal
                confirmModal.show();
            });
        }
        
        // Handle confirm button click
        document.getElementById('confirmRemoveBtn').addEventListener('click', function() {
            confirmModal.hide();
            
            // Clear the file input
            mainImageInput.value = '';
            
            // Hide the preview
            mainImagePreviewContainer.classList.add('d-none');
            
            // Show success message in result modal
            document.getElementById('resultModalLabel').textContent = 'Success';
            document.getElementById('resultModalBody').textContent = 'Image removed successfully';
            document.getElementById('resultModalBody').className = 'modal-body text-success';
            resultModal.show();
        });
    });
</script>
@endsection