@extends('admin.layouts.app')

@section('title', 'Edit Workshop Event')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .image-preview {
        max-height: 200px;
        max-width: 100%;
        margin-top: 10px;
        border-radius: 5px;
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px;
        border: 1px solid #ced4da;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .required-label::after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Workshop Event</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">Workshop Events</a></li>
        <li class="breadcrumb-item active">Edit: {{ $workshop->title }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Workshop Event
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

            <form action="{{ route('admin.workshop-events.update', $workshop) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label required-label">Event Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $workshop->title) }}" required>
                            <small class="text-muted">Enter a descriptive title for this workshop event.</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="workshop_id" class="form-label">Workshop Template (Optional)</label>
                            <select class="form-select select2" id="workshop_id" name="workshop_id">
                                <option value="">None (Standalone Event)</option>
                                @foreach($workshopTemplates as $template)
                                    <option value="{{ $template->id }}" {{ old('workshop_id', $workshop->workshop_id) == $template->id ? 'selected' : '' }}>
                                        {{ $template->name_en }} ({{ $template->target_age_group }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Link this event to a workshop template/category (optional).</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label required-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="6" required>{{ old('description', $workshop->description) }}</textarea>
                            <small class="text-muted">Provide a detailed description of the workshop event.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="event_date" class="form-label required-label">Event Date & Time</label>
                                    <input type="text" class="form-control" id="event_date" name="event_date" value="{{ old('event_date', $workshop->event_date->format('Y-m-d H:i')) }}" required>
                                    <small class="text-muted">Select the date and time when this event will take place.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="duration_minutes" class="form-label required-label">Duration (minutes)</label>
                                    <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $workshop->duration_minutes) }}" min="1" required>
                                    <small class="text-muted">How long will this workshop last? (in minutes)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="max_attendees" class="form-label required-label">Maximum Attendees</label>
                                    <input type="number" class="form-control" id="max_attendees" name="max_attendees" value="{{ old('max_attendees', $workshop->max_attendees) }}" min="1" required>
                                    <small class="text-muted">Maximum number of participants allowed.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="price_jod" class="form-label required-label">Price (JOD)</label>
                                    <input type="number" class="form-control" id="price_jod" name="price_jod" value="{{ old('price_jod', $workshop->price_jod) }}" step="0.01" min="0" required>
                                    <small class="text-muted">Event price in Jordanian Dinars. Use 0 for free events.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="location" class="form-label required-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $workshop->location) }}" required>
                            <small class="text-muted">Where will this workshop take place?</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="age_group" class="form-label required-label">Age Group</label>
                            <input type="text" class="form-control" id="age_group" name="age_group" value="{{ old('age_group', $workshop->age_group) }}" required>
                            <small class="text-muted">Example: "5-7 years", "8-12 years", "Adults", "All ages"</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-cog me-1"></i>
                                Event Settings
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="is_open_for_registration" name="is_open_for_registration" value="1" {{ $workshop->is_open_for_registration ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_open_for_registration">
                                        Open for Registration
                                    </label>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image_path" class="form-label">Main Image</label>
                                            <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path" accept="image/*">
                                            @error('image_path')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if($workshop->image_path)
                                                <div class="mt-2" id="main-image-preview-container">
                                                    <img src="{{ asset('storage/' . $workshop->image_path) }}" class="img-thumbnail" style="max-height: 150px;" alt="Main image preview" id="main-image-preview">
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" id="remove_main_image" name="remove_main_image" value="1">
                                                        <label class="form-check-label" for="remove_main_image">
                                                            Remove main image
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                            <small class="form-text text-muted">This will be the primary image shown for the event.</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="featured_image_path" class="form-label">Featured Image</label>
                                            <input type="file" class="form-control @error('featured_image_path') is-invalid @enderror" id="featured_image_path" name="featured_image_path" accept="image/*">
                                            @error('featured_image_path')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if($workshop->featured_image_path)
                                                <div class="mt-2" id="featured-image-preview-container">
                                                    <img src="{{ asset('storage/' . $workshop->featured_image_path) }}" class="img-thumbnail" style="max-height: 150px;" alt="Featured image preview" id="featured-image-preview">
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" id="remove_featured_image" name="remove_featured_image" value="1">
                                                        <label class="form-check-label" for="remove_featured_image">
                                                            Remove featured image
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                            <small class="form-text text-muted">This image will be used for featured sections or promotions.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="gallery_images" class="form-label">Gallery Images</label>
                                    <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror" id="gallery_images" name="gallery_images[]" multiple accept="image/*">
                                    @error('gallery_images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($workshop->gallery_images && count($workshop->gallery_images) > 0)
                                        <div class="mt-3">
                                            <label class="form-label">Current Gallery Images</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($workshop->gallery_images as $index => $image)
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover;" alt="Gallery image {{ $index + 1 }}">
                                                        <div class="form-check mt-1">
                                                            <input class="form-check-input" type="checkbox" id="remove_gallery_image_{{ $index }}" name="remove_gallery_images[]" value="{{ $index }}">
                                                            <label class="form-check-label" for="remove_gallery_image_{{ $index }}">
                                                                Remove
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    <small class="form-text text-muted">You can upload multiple images for the event gallery.</small>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <i class="fas fa-info-circle me-1"></i>
                                Registration Information
                            </div>
                            <div class="card-body">
                                <p><strong>Current Registrations:</strong> <span class="badge bg-primary">{{ $workshop->registrations_count ?? 0 }}</span></p>
                                <p><strong>Available Spots:</strong> <span class="badge bg-success">{{ $workshop->max_attendees - ($workshop->registrations_count ?? 0) }}</span></p>
                                
                                @if(($workshop->registrations_count ?? 0) > 0)
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> This event already has registrations. Changes to date, time, or location should be communicated to registered attendees.
                                    </div>
                                    
                                    <a href="{{ route('admin.workshop-events.registrations', $workshop) }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-users"></i> Manage Registrations
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.workshop-events.show', $workshop) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Workshop Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize date/time picker
        flatpickr("#event_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today"
        });
        
        // Initialize select2
        $('.select2').select2({
            placeholder: "Select a workshop template (optional)",
            allowClear: true
        });
        
        // Image preview
        const imageInput = document.getElementById('image_path');
        const imagePreview = document.getElementById('main-image-preview');
        const imagePreviewContainer = document.getElementById('main-image-preview-container');
        const removeImageCheckbox = document.getElementById('remove_main_image');
        
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                        imagePreviewContainer.classList.remove('d-none');
                        
                        if (removeImageCheckbox) {
                            removeImageCheckbox.checked = false;
                        }
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        if (removeImageCheckbox) {
            removeImageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    imageInput.value = '';
                    imagePreview.src = '';
                    imagePreview.classList.add('d-none');
                }
            });
        }
    });
</script>
@endsection
