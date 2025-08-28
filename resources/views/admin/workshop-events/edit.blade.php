@extends('admin.layouts.app')

@section('title', 'تعديل فعالية ورشة العمل')

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
    <div class="container px-4" style="direction: rtl;">
        <h1 class="mt-4">تعديل فعالية ورشة العمل</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">فعاليات ورش العمل</a></li>
            <li class="breadcrumb-item active">تعديل: {{ $event->title }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                تعديل فعالية ورشة العمل
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
                                <label for="title" class="form-label required-label">عنوان الفعالية</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $event->title) }}" required>
                                <small class="text-muted">أدخل عنوانًا وافيًا للفعالية.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="workshop_id" class="form-label">قالب ورشة العمل (اختياري)</label>
                                <select class="form-select select2" id="workshop_id" name="workshop_id">
                                    <option value="">لا شيء (فعالية مستقلة)</option>
                                    @foreach($workshopTemplates as $template)
                                        <option value="{{ $template->id }}" {{ old('workshop_id', $event->workshop_id) == $template->id ? 'selected' : '' }}>
                                            {{ $template->name_ar }} ({{ $template->target_age_group }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">اربط هذه الفعالية بقالب ورشة عمل (اختياري).</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label required-label">وصف الفعالية</label>
                                <textarea class="form-control" id="description" name="description" rows="6"
                                    required>{{ old('description', $event->description) }}</textarea>
                                <small class="text-muted">أدخل وصفًا مفصلًا للفعالية.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="event_date" class="form-label required-label">تاريخ ووقت الفعالية</label>
                                        <input type="text" class="form-control" id="event_date" name="event_date"
                                            value="{{ old('event_date', $event->event_date->format('Y-m-d H:i')) }}"
                                            required>
                                        <small class="text-muted">حدد تاريخ ووقت الفعالية.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="duration_hours" class="form-label required-label">مدة الفعالية (ساعات)</label>
                                        <input type="number" class="form-control" id="duration_hours" name="duration_hours"
                                            value="{{ old('duration_hours', $event->duration_hours ?? 2) }}" min="0.5"
                                            step="0.5" required>
                                        <small class="text-muted">أدخل مدة الفعالية بالساعات.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="max_attendees" class="form-label required-label">الحد الأقصى للمشاركين</label>
                                        <input type="number" class="form-control" id="max_attendees" name="max_attendees"
                                            value="{{ old('max_attendees', $event->max_attendees) }}" min="1" required>
                                        <small class="text-muted">حدد الحد الأقصى للمشاركين.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price_jod" class="form-label required-label">السعر (دينار أردني)</label>
                                        <input type="number" class="form-control" id="price_jod" name="price_jod"
                                            value="{{ old('price_jod', $event->price_jod) }}" step="0.01" min="0" required>
                                        <small class="text-muted">أدخل سعر الفعالية بالدينار الأردني. استخدم 0 للفعاليات المجانية.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="location" class="form-label required-label">موقع الفعالية</label>
                                <input type="text" class="form-control" id="location" name="location"
                                    value="{{ old('location', $event->location) }}" required>
                                <small class="text-muted">حدد موقع الفعالية.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="age_group" class="form-label required-label">فئة العمر</label>
                                <input type="text" class="form-control" id="age_group" name="age_group"
                                    value="{{ old('age_group', $event->age_group) }}" required>
                                <small class="text-muted">مثال: "5-7 سنوات"، "8-12 سنة"، "كبار السن"، "جميع الأعمار"</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-cog me-1"></i>
                                    إعدادات الفعالية
                                </div>
                                <div class="card-body">


                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image_path" class="form-label">الصورة الرئيسية</label>
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
                                                            alt="معاينة الصورة الرئيسية" id="main-image-preview">
                                                        <div class="d-flex mt-1 gap-2">
                                                            <button type="button" class="btn btn-danger btn-sm remove-image-btn"
                                                                data-type="main">
                                                                <i class="fas fa-trash-alt"></i> إزالة
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mt-2 d-none" id="main-image-preview-container">
                                                        <img src="" class="img-thumbnail d-none" style="max-height: 150px;"
                                                            alt="معاينة الصورة الرئيسية" id="main-image-preview">
                                                    </div>
                                                @endif
                                                <small class="form-text text-muted">هذه الصورة ستظهر كصورة رئيسية للفعالية.</small>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mb-4">
                                        <label for="gallery_images" class="form-label">صور المعرض</label>
                                        <div class="d-flex gap-2 mb-2">
                                            <input type="file"
                                                class="form-control @error('gallery_images.*') is-invalid @enderror"
                                                id="gallery_images" name="gallery_images[]" multiple accept="image/*">
                                            <button type="button" class="btn btn-success" id="add-gallery-images-btn">
                                                إضافة
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
                                                <label class="form-label">صور المعرض الحالية</label>
                                                <div class="d-flex flex-wrap gap-2" id="current-gallery-container">
                                                    @foreach($event->gallery_images as $index => $image)
                                                        <div class="position-relative gallery-image-item" data-index="{{ $index }}">
                                                            <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"
                                                                style="height: 100px; width: 100px; object-fit: cover;"
                                                                alt="صورة المعرض {{ $index + 1 }}">
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
                                        <small class="form-text text-muted">يمكنك تحميل صور متعددة للمعرض.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-1"></i>
                                    معلومات التسجيل
                                </div>
                                <div class="card-body">
                                    <p><strong>التسجيلات الحالية:</strong> <span
                                            class="badge bg-primary">{{ $event->registrations_count ?? 0 }}</span></p>
                                    <p><strong>المناصب المتاحة:</strong> <span
                                            class="badge bg-success">{{ $event->max_attendees - ($event->registrations_count ?? 0) }}</span>
                                    </p>

                                    @if(($event->registrations_count ?? 0) > 0)
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i> هذه الفعالية لديها تسجيلات بالفعل.
                                            يجب أن يتم التواصل مع المشاركين المسجلين بشأن أي تغييرات في التاريخ أو الوقت أو الموقع.
                                        </div>

                                        <a href="{{ route('admin.workshop-events.registrations', $event) }}"
                                            class="btn btn-outline-primary btn-sm w-100">
                                            <i class="fas fa-users"></i> إدارة التسجيلات
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.workshop-events.show', $event) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> تحديث فعالية ورشة العمل
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
                        <h5 class="modal-title" id="confirmModalLabel">تأكيد إزالة الصورة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="confirmModalBody">
                        هل أنت متأكد أنك تريد إزالة هذه الصورة؟
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-danger" id="confirmRemoveBtn">إزالة</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Modal -->
        <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">النتيجة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="resultModalBody">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">موافق</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize flatpickr date picker with Arabic locale
            flatpickr("#event_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "ar",
                time_24hr: true
            });

            // Initialize select2
            $('.select2').select2({
                dir: "rtl",
                placeholder: "اختر قالب ورشة العمل",
                allowClear: true
            });

            // Main image preview
            $('#image_path').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#main-image-preview').attr('src', e.target.result).removeClass('d-none');
                        $('#main-image-preview-container').removeClass('d-none');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Gallery images preview
            $('#gallery_images').change(function() {
                handleGalleryImagesPreview(this.files);
            });

            $('#add-gallery-images-btn').click(function() {
                $('#gallery_images').click();
            });

            // Handle gallery image preview
            function handleGalleryImagesPreview(files) {
                if (!files || files.length === 0) return;

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewHtml = `
                            <div class="position-relative gallery-preview-item mb-2">
                                <img src="${e.target.result}" class="img-thumbnail" 
                                    style="height: 100px; width: 100px; object-fit: cover;" alt="معاينة صورة المعرض">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 rounded-circle preview-remove-btn"
                                    style="width: 24px; height: 24px;">
                                    <i class="fas fa-times" style="font-size: 12px;"></i>
                                </button>
                            </div>
                        `;
                        $('#gallery-preview-container').append(previewHtml);
                    }

                    reader.readAsDataURL(file);
                }
            }

            // Remove preview image
            $(document).on('click', '.preview-remove-btn', function() {
                $(this).closest('.gallery-preview-item').remove();
            });

            // Handle existing gallery image removal
            $(document).on('click', '.gallery-remove-btn', function() {
                const index = $(this).data('index');
                const item = $(this).closest('.gallery-image-item');
                
                // Show confirmation modal
                $('#confirmModalBody').text('هل أنت متأكد أنك تريد إزالة هذه الصورة من المعرض؟');
                $('#confirmModal').modal('show');
                
                $('#confirmRemoveBtn').off('click').on('click', function() {
                    // Mark image as removed
                    item.find('.removed-gallery-input').prop('disabled', false);
                    item.addClass('opacity-50');
                    item.find('.gallery-remove-btn').prop('disabled', true).addClass('d-none');
                    
                    $('#confirmModal').modal('hide');
                    
                    // Show success message
                    $('#resultModalBody').html('<div class="alert alert-success mb-0">تمت إزالة الصورة. انقر على "تحديث فعالية ورشة العمل" لحفظ التغييرات.</div>');
                    $('#resultModal').modal('show');
                });
            });

            // Handle main image removal
            $(document).on('click', '.remove-image-btn', function() {
                const type = $(this).data('type');
                
                // Show confirmation modal
                $('#confirmModalBody').text('هل أنت متأكد أنك تريد إزالة الصورة الرئيسية؟');
                $('#confirmModal').modal('show');
                
                $('#confirmRemoveBtn').off('click').on('click', function() {
                    if (type === 'main') {
                        // Create a hidden input to signal image removal
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'remove_main_image',
                            value: '1'
                        }).appendTo('form');
                        
                        // Hide the preview
                        $('#main-image-preview-container').addClass('d-none');
                    }
                    
                    $('#confirmModal').modal('hide');
                    
                    // Show success message
                    $('#resultModalBody').html('<div class="alert alert-success mb-0">تمت إزالة الصورة. انقر على "تحديث فعالية ورشة العمل" لحفظ التغييرات.</div>');
                    $('#resultModal').modal('show');
                });
            });
        });
    </script>
@endsection