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
    <div class="container px-4">
        <h1 class="mt-4">Edit Workshop Event</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">Workshop Events</a></li>
            <li class="breadcrumb-item active">Edit: {{ $event->title }}</li>
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

                <form action="{{ route('admin.workshop-events.update', $event) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="title" class="form-label required-label">Event Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $event->title) }}" required>
                                <small class="text-muted">Enter a descriptive title for this workshop event.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="workshop_id" class="form-label">Workshop Template (Optional)</label>
                                <select class="form-select select2" id="workshop_id" name="workshop_id">
                                    <option value="">None (Standalone Event)</option>
                                    @foreach($workshopTemplates as $template)
                                        <option value="{{ $template->id }}" {{ old('workshop_id', $event->workshop_id) == $template->id ? 'selected' : '' }}>
                                            {{ $template->name_en }} ({{ $template->target_age_group }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Link this event to a workshop template/category
                                    (optional).</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label required-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="6"
                                    required>{{ old('description', $event->description) }}</textarea>
                                <small class="text-muted">Provide a detailed description of the workshop event.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="event_date" class="form-label required-label">Event Date & Time</label>
                                        <input type="text" class="form-control" id="event_date" name="event_date"
                                            value="{{ old('event_date', $event->event_date->format('Y-m-d H:i')) }}"
                                            required>
                                        <small class="text-muted">Select the date and time when this event will take
                                            place.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="duration_hours" class="form-label required-label">Duration
                                            (hours)</label>
                                        <input type="number" class="form-control" id="duration_hours" name="duration_hours"
                                            value="{{ old('duration_hours', $event->duration_hours ?? 2) }}" min="0.5"
                                            step="0.5" required>
                                        <small class="text-muted">Enter the duration of the event in hours.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="max_attendees" class="form-label required-label">Maximum
                                            Attendees</label>
                                        <input type="number" class="form-control" id="max_attendees" name="max_attendees"
                                            value="{{ old('max_attendees', $event->max_attendees) }}" min="1" required>
                                        <small class="text-muted">Maximum number of participants allowed.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price_jod" class="form-label required-label">Price (JOD)</label>
                                        <input type="number" class="form-control" id="price_jod" name="price_jod"
                                            value="{{ old('price_jod', $event->price_jod) }}" step="0.01" min="0" required>
                                        <small class="text-muted">Event price in Jordanian Dinars. Use 0 for free
                                            events.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="location" class="form-label required-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location"
                                    value="{{ old('location', $event->location) }}" required>
                                <small class="text-muted">Where will this workshop take place?</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="age_group" class="form-label required-label">Age Group</label>
                                <input type="text" class="form-control" id="age_group" name="age_group"
                                    value="{{ old('age_group', $event->age_group) }}" required>
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


                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image_path" class="form-label">Main Image</label>
                                                <input type="file"
                                                    class="form-control @error('image_path') is-invalid @enderror"
                                                    id="image_path" name="image_path" accept="image/*">
                                                @error('image_path')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                @if($event->image_path)
                                                    <div class="mt-2" id="main-image-preview-container">
                                                        <img src="{{ asset('storage/' . $event->image_path) }}"
                                                            class="img-thumbnail" style="max-height: 150px;"
                                                            alt="Main image preview" id="main-image-preview">
                                                        <div class="d-flex mt-1 gap-2">
                                                            <button type="button" class="btn btn-danger btn-sm remove-image-btn"
                                                                data-type="main">
                                                                <i class="fas fa-trash-alt"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mt-2 d-none" id="main-image-preview-container">
                                                        <img src="" class="img-thumbnail d-none" style="max-height: 150px;"
                                                            alt="Main image preview" id="main-image-preview">
                                                    </div>
                                                @endif
                                                <small class="form-text text-muted">This will be the primary image shown for
                                                    the event.</small>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mb-4">
                                        <label for="gallery_images" class="form-label">Gallery Images</label>
                                        <div class="d-flex gap-2 mb-2">
                                            <input type="file"
                                                class="form-control @error('gallery_images.*') is-invalid @enderror"
                                                id="gallery_images" name="gallery_images[]" multiple accept="image/*">
                                            <button type="button" class="btn btn-success" id="add-gallery-images-btn">
                                                Add
                                            </button>
                                        </div>
                                        @error('gallery_images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div id="gallery-preview-container" class="mt-2">
                                            <!-- New images will be previewed here -->
                                        </div>

                                        @if($event->gallery_images && count($event->gallery_images) > 0)
                                            <div class="mt-3">
                                                <label class="form-label">Current Gallery Images</label>
                                                <div class="d-flex flex-wrap gap-2" id="current-gallery-container">
                                                    @foreach($event->gallery_images as $index => $image)
                                                        <div class="position-relative gallery-image-item" data-index="{{ $index }}">
                                                            <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"
                                                                style="height: 100px; width: 100px; object-fit: cover;"
                                                                alt="Gallery image {{ $index + 1 }}">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 rounded-circle gallery-remove-btn"
                                                                style="width: 24px; height: 24px;" data-index="{{ $index }}">
                                                                <i class="fas fa-times" style="font-size: 12px;"></i>
                                                            </button>
                                                            <!-- Hidden input to track removed images -->
                                                            <input type="hidden" name="removed_gallery_images[]"
                                                                class="removed-gallery-input" value="{{ $index }}" disabled>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">You can upload multiple images for the event
                                            gallery.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Registration Information
                                </div>
                                <div class="card-body">
                                    <p><strong>Current Registrations:</strong> <span
                                            class="badge bg-primary">{{ $event->registrations_count ?? 0 }}</span></p>
                                    <p><strong>Available Spots:</strong> <span
                                            class="badge bg-success">{{ $event->max_attendees - ($event->registrations_count ?? 0) }}</span>
                                    </p>

                                    @if(($event->registrations_count ?? 0) > 0)
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i> This event already has registrations.
                                            Changes to date, time, or location should be communicated to registered attendees.
                                        </div>

                                        <a href="{{ route('admin.workshop-events.registrations', $event) }}"
                                            class="btn btn-outline-primary btn-sm w-100">
                                            <i class="fas fa-users"></i> Manage Registrations
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.workshop-events.show', $event) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Workshop Event
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Debug: Check if Bootstrap is available
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap is not defined. Make sure bootstrap.bundle.min.js is loaded properly.');
                return;
            }

            // Debug: Check if modal elements exist
            const confirmModalEl = document.getElementById('confirmModal');
            const resultModalEl = document.getElementById('resultModal');

            console.log('Confirm Modal Element:', confirmModalEl);
            console.log('Result Modal Element:', resultModalEl);

            if (!confirmModalEl) {
                console.error('Confirm Modal element not found in DOM');
                return;
            }

            if (!resultModalEl) {
                console.error('Result Modal element not found in DOM');
                return;
            }

            // Initialize Bootstrap modals
            const confirmModal = new bootstrap.Modal(confirmModalEl);
            const resultModal = new bootstrap.Modal(resultModalEl);

            // Variables for tracking current removal operation
            let currentRemoveType = null; // 'new', 'existing', or 'main'
            let currentItemToRemove = null;
            let currentImageIndex = null;

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

            // Main Image preview
            const mainImageInput = document.getElementById('image_path');
            const mainImagePreview = document.getElementById('main-image-preview');
            const mainImagePreviewContainer = document.getElementById('main-image-preview-container');

            if (mainImageInput) {
                mainImageInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            mainImagePreview.src = e.target.result;
                            mainImagePreview.classList.remove('d-none');
                            mainImagePreviewContainer.classList.remove('d-none');
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Gallery Images management
            const galleryImagesInput = document.getElementById('gallery_images');
            const galleryPreviewContainer = document.getElementById('gallery-preview-container');
            const addGalleryImagesBtn = document.getElementById('add-gallery-images-btn');
            let newImageIndex = 0;

            // Function to create a preview for a new gallery image
            function createGalleryImagePreview(file, index) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'position-relative new-gallery-image-item';
                previewDiv.dataset.index = index;

                const img = document.createElement('img');
                img.className = 'img-thumbnail';
                img.style = 'height: 100px; width: 100px; object-fit: cover;';
                img.alt = `New gallery image ${index + 1}`;

                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Create remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 rounded-circle new-gallery-remove-btn';
                removeBtn.style = 'width: 24px; height: 24px;';
                removeBtn.innerHTML = '<i class="fas fa-times" style="font-size: 12px;"></i>';
                removeBtn.addEventListener('click', function () {
                    // Set the current item to be removed
                    currentItemToRemove = previewDiv;
                    currentRemoveType = 'new';

                    // Show the confirmation modal
                    document.getElementById('confirmModalLabel').textContent = 'Confirm Image Removal';
                    document.getElementById('confirmModalBody').textContent = 'Are you sure you want to remove this image?';
                    confirmModal.show();
                });

                // Create hidden input to store the file
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'file';
                hiddenInput.name = `gallery_images[]`;  
                hiddenInput.style.display = 'none';
                hiddenInput.className = 'new-gallery-file-input';

                // Create a DataTransfer object and add the file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                hiddenInput.files = dataTransfer.files;

                previewDiv.appendChild(img);
                previewDiv.appendChild(removeBtn);
                previewDiv.appendChild(hiddenInput);

                return previewDiv;
            }

            // Add gallery images when the add button is clicked
            if (addGalleryImagesBtn) {
                addGalleryImagesBtn.addEventListener('click', function () {
                    if (galleryImagesInput.files && galleryImagesInput.files.length > 0) {
                        // Create container for new images if it doesn't exist
                        if (!galleryPreviewContainer.querySelector('.new-gallery-images')) {
                            const newImagesDiv = document.createElement('div');
                            newImagesDiv.className = 'new-gallery-images d-flex flex-wrap gap-2 mb-3';
                            galleryPreviewContainer.appendChild(newImagesDiv);
                        }

                        const newImagesContainer = galleryPreviewContainer.querySelector('.new-gallery-images');

                        // Add each selected file as a preview
                        for (let i = 0; i < galleryImagesInput.files.length; i++) {
                            const file = galleryImagesInput.files[i];
                            const preview = createGalleryImagePreview(file, newImageIndex++);
                            newImagesContainer.appendChild(preview);
                        }

                        // Clear the file input
                        galleryImagesInput.value = '';
                    }
                });
            }

            // Gallery image removal for existing images
            document.querySelectorAll('.gallery-remove-btn').forEach(button => {
                button.addEventListener('click', function handleRemove() {
                    const index = parseInt(this.getAttribute('data-index'), 10);
                    const galleryItem = this.closest('.gallery-image-item');
                    
                    console.log('Clicked remove button for gallery image with index:', index);
                    
                    // Set the current item to be removed and store the index
                    currentItemToRemove = galleryItem;
                    currentImageIndex = index;
                    currentRemoveType = 'existing';
                    
                    // Show the confirmation modal
                    document.getElementById('confirmModalLabel').textContent = 'Confirm Image Removal';
                    document.getElementById('confirmModalBody').textContent = 'Are you sure you want to remove this image?';
                    confirmModal.show();
                });
            });

            // Add click event listeners to main image remove button
            document.querySelectorAll('.remove-image-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const imageType = this.getAttribute('data-type');
                    console.log('Clicked remove button for', imageType, 'image');

                    // Store references for later use
                    currentRemoveType = imageType;

                    // Show the confirmation modal
                    document.getElementById('confirmModalLabel').textContent = 'Confirm Image Removal';
                    document.getElementById('confirmModalBody').textContent = 'Are you sure you want to remove this image?';
                    confirmModal.show();
                });
            });

            // Handle confirm button click for all types of removals
            document.getElementById('confirmRemoveBtn').addEventListener('click', function () {
                confirmModal.hide();

                // Handle different types of removals
                if (currentRemoveType === 'new') {
                    // Remove new gallery image preview
                    currentItemToRemove.remove();

                    // Show success message
                    document.getElementById('resultModalLabel').textContent = 'Success';
                    document.getElementById('resultModalBody').textContent = 'Image removed successfully';
                    document.getElementById('resultModalBody').className = 'modal-body text-success';
                    resultModal.show();
                } else if (currentRemoveType === 'existing') {
                    console.log('Removing existing gallery image with index:', currentImageIndex);

                    // Remove the gallery image via AJAX
                    fetch('{{ route('admin.workshop-events.remove-image', $event) }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            type: 'gallery',
                            index: currentImageIndex
                        })
                    })
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                // Remove the gallery item from the DOM
                                currentItemToRemove.remove();

                                // Show success message
                                document.getElementById('resultModalLabel').textContent = 'Success';
                                document.getElementById('resultModalBody').textContent = data.message || 'Image removed successfully';
                                document.getElementById('resultModalBody').className = 'modal-body text-success';
                            } else {
                                // Show error message
                                document.getElementById('resultModalLabel').textContent = 'Error';
                                document.getElementById('resultModalBody').textContent = data.message || 'An error occurred while removing the image';
                                document.getElementById('resultModalBody').className = 'modal-body text-danger';
                            }

                            resultModal.show();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById('resultModalLabel').textContent = 'Error';
                            document.getElementById('resultModalBody').textContent = 'An error occurred while removing the image';
                            document.getElementById('resultModalBody').className = 'modal-body text-danger';
                            resultModal.show();
                        });
                } else if (currentRemoveType === 'main') {
                    console.log('Removing main image');

                    // Create a simple form data object
                    const formData = new FormData();
                    formData.append('type', 'main');
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    // Handle main image removal via AJAX using POST
                    fetch('{{ route('admin.workshop-events.remove-image', $event) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            return response.text().then(text => {
                                console.error('Error response:', text);
                                throw new Error('Network response was not ok');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            // Hide the image preview
                            document.getElementById('main-image-preview-container').classList.add('d-none');

                            // Show success message
                            document.getElementById('resultModalLabel').textContent = 'Success';
                            document.getElementById('resultModalBody').textContent = data.message || 'Image removed successfully';
                            document.getElementById('resultModalBody').className = 'modal-body text-success';
                        } else {
                            // Show error message
                            document.getElementById('resultModalLabel').textContent = 'Error';
                            document.getElementById('resultModalBody').textContent = data.message || 'An error occurred while removing the image';
                            document.getElementById('resultModalBody').className = 'modal-body text-danger';
                        }

                        resultModal.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('resultModalLabel').textContent = 'Error';
                        document.getElementById('resultModalBody').textContent = 'An error occurred while removing the image';
                        document.getElementById('resultModalBody').className = 'modal-body text-danger';
                        resultModal.show();
                    });
                }
            });

            // Form submission handler to include new gallery images
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    // Process removed gallery images
                    document.querySelectorAll('.removed-gallery-input:not([disabled])').forEach(input => {
                        input.name = 'remove_gallery_images[]';
                    });

                    // Process new gallery images
                    const newGalleryItems = document.querySelectorAll('.new-gallery-image-item');
                    if (newGalleryItems.length > 0) {
                        // We need to prevent default form submission to handle the files
                        e.preventDefault();

                        // Create a new FormData object from the form
                        const formData = new FormData(form);
                        
                        // Make sure the PUT method is included
                        formData.append('_method', 'PUT');

                        // Clear any existing gallery_images[] entries
                        const entries = Array.from(formData.entries());
                        for (const entry of entries) {
                            if (entry[0] === 'gallery_images[]') {
                                formData.delete('gallery_images[]');
                            }
                        }

                        // Add each file from new gallery items
                        let hasValidFiles = false;
                        newGalleryItems.forEach(item => {
                            const fileInput = item.querySelector('.new-gallery-file-input');
                            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                                formData.append('gallery_images[]', fileInput.files[0]);
                                console.log('Adding gallery image:', fileInput.files[0].name);
                                hasValidFiles = true;
                            }
                        });

                        console.log('Submitting form with', newGalleryItems.length, 'new gallery images');
                        
                        // Debug: Log all form data entries
                        for (let pair of formData.entries()) {
                            console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name : pair[1]));
                        }

                        // Send form data via fetch
                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => {
                                if (response.redirected) {
                                    window.location.href = response.url;
                                } else {
                                    return response.text().then(html => {
                                        document.open();
                                        document.write(html);
                                        document.close();
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error submitting form:', error);
                                alert('An error occurred while saving the workshop event. Please try again.');
                            });
                    }
                    // If no new gallery images, let the form submit normally
                });
            }
        });
    </script>
@endsection