@extends('admin.layouts.app')

@section('title', 'Add New Workshop')

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

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="target_age_group" class="form-label">Target Age Group <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('target_age_group') is-invalid @enderror" id="target_age_group" name="target_age_group" value="{{ old('target_age_group') }}" placeholder="e.g. 5-8 years" required>
                            @error('target_age_group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
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

                <div class="form-group mb-4">
                    <label for="description_ar" class="form-label">Arabic Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" rows="4" dir="rtl" required>{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="images" class="form-label">Workshop Images</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                    <small class="form-text text-muted">You can upload multiple images. The first image will be set as the main image.</small>
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="image-preview-container mt-2 mb-4" id="imagePreviewContainer">
                    <div class="row" id="imagePreview"></div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.workshops.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Workshop</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            
            if (this.files) {
                Array.from(this.files).forEach((file, index) => {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-2';
                        
                        const card = document.createElement('div');
                        card.className = 'card h-100';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'card-img-top';
                        img.style.height = '150px';
                        img.style.objectFit = 'cover';
                        
                        const cardBody = document.createElement('div');
                        cardBody.className = 'card-body p-2';
                        
                        const cardText = document.createElement('p');
                        cardText.className = 'card-text small text-center mb-0';
                        cardText.textContent = index === 0 ? 'Main Image' : `Image ${index + 1}`;
                        
                        cardBody.appendChild(cardText);
                        card.appendChild(img);
                        card.appendChild(cardBody);
                        col.appendChild(card);
                        imagePreview.appendChild(col);
                    };
                    
                    reader.readAsDataURL(file);
                });
            }
        });
    });
</script>
@endsection