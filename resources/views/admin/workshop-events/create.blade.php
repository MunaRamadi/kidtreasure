@extends('admin.layouts.app')

@section('title', 'Create Workshop Event')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        .select2-container .select2-selection--single {
            height: 38px;
            line-height: 38px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Create Workshop Event</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">Workshop Events</a></li>
            <li class="breadcrumb-item active">Create Event</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-plus me-1"></i>
                Event Details
            </div>
            <div class="card-body">
                <form action="{{ route('admin.workshop-events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="workshop_id" class="form-label">Associated Workshop Template</label>
                                <select class="form-select workshop-select @error('workshop_id') is-invalid @enderror"
                                    id="workshop_id" name="workshop_id">
                                    <option value="">-- Select Workshop Template (Optional) --</option>
                                    @foreach($workshopTemplates as $template)
                                        <option value="{{ $template->id }}" {{ old('workshop_id') == $template->id ? 'selected' : '' }}>
                                            {{ $template->name_en }} ({{ $template->target_age_group }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('workshop_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Linking to a workshop template is optional but
                                    recommended for consistency.</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Event Description <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="duration_hours" class="form-label">Duration (hours) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duration_hours') is-invalid @enderror"
                                id="duration_hours" name="duration_hours" value="{{ old('duration_hours', 2) }}" step="0.5"
                                min="0.5" required>
                            @error('duration_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="max_attendees" class="form-label">Maximum Attendees <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('max_attendees') is-invalid @enderror"
                                id="max_attendees" name="max_attendees" value="{{ old('max_attendees', 20) }}" min="1"
                                required>
                            @error('max_attendees')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Event Date & Time <span class="text-danger">*</span></label>
                        <input type="text" class="form-control datepicker @error('event_date') is-invalid @enderror" 
                            id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                        @error('event_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="price_jod" class="form-label">Price (JOD) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('price_jod') is-invalid @enderror" id="price_jod"
                            name="price_jod" value="{{ old('price_jod', 0) }}" step="0.01" min="0" required>
                        @error('price_jod')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                            name="location" value="{{ old('location') }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="age_group" class="form-label">Target Age Group <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('age_group') is-invalid @enderror" id="age_group"
                            name="age_group" value="{{ old('age_group') }}" required>
                        @error('age_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Example: "5-8 years" or "Adults 18+"</small>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input @error('is_open_for_registration') is-invalid @enderror" type="checkbox"
                        id="is_open_for_registration" name="is_open_for_registration" value="1" {{ old('is_open_for_registration', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_open_for_registration">
                        Open for Registration
                    </label>
                    @error('is_open_for_registration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image_path" class="form-label">Main Image</label>
                        <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path"
                            accept="image/*">
                        @error('image_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">This will be the primary image shown for the event.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="featured_image_path" class="form-label">Featured Image</label>
                        <input type="file" class="form-control @error('featured_image_path') is-invalid @enderror" id="featured_image_path" name="featured_image_path"
                            accept="image/*">
                        @error('featured_image_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">This image will be used for featured sections or promotions.</small>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="gallery_images" class="form-label">Gallery Images</label>
                <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror" id="gallery_images" name="gallery_images[]"
                    multiple accept="image/*">
                @error('gallery_images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">You can upload multiple images for the event gallery.</small>

                <div class="image-preview" id="imagePreview"></div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.workshop-events.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Event</button>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize datetime picker
            flatpickr(".datepicker", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                time_24hr: true
            });

            // Initialize select2 for workshop template dropdown
            $('.workshop-select').select2({
                placeholder: "Select a workshop template",
                allowClear: true
            });

            // Auto-populate age group when selecting a workshop template
            $('#workshop_id').on('change', function () {
                const selectedOption = $(this).find('option:selected');
                if (selectedOption.val()) {
                    const text = selectedOption.text();
                    const ageGroup = text.match(/\((.*?)\)/);
                    if (ageGroup && ageGroup[1]) {
                        $('#age_group').val(ageGroup[1]);
                    }
                }
            });

            // Image preview functionality
            const input = document.getElementById('gallery_images');
            const preview = document.getElementById('imagePreview');

            input.addEventListener('change', function () {
                preview.innerHTML = '';

                if (this.files) {
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];
                        if (!file.type.match('image.*')) continue;

                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const div = document.createElement('div');
                            div.className = 'image-preview-item';

                            const img = document.createElement('img');
                            img.src = e.target.result;

                            div.appendChild(img);
                            preview.appendChild(div);
                        }

                        reader.readAsDataURL(file);
                    }
                }
            });
        });
    </script>
@endsection