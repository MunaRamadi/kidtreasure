@extends('admin.layouts.app')

@section('title', 'تعديل الورشة')

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
    <div class="container-fluid px-4" style="direction: rtl;">
        <h1 class="mt-4">تعديل الورشة</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.workshops.index') }}">الورش</a></li>
            <li class="breadcrumb-item active">تعديل: {{ $workshop->name_ar }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                معلومات الورشة
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

                <form action="{{ route('admin.workshops.update', $workshop) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name_ar" class="form-label">الاسم بالعربية <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                            id="name_ar" name="name_ar" value="{{ old('name_ar', $workshop->name_ar) }}"
                                            dir="rtl" required>
                                        @error('name_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name_en" class="form-label">الاسم بالإنجليزية <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                            id="name_en" name="name_en" value="{{ old('name_en', $workshop->name_en) }}"
                                            required>
                                        @error('name_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description_ar" class="form-label">الوصف بالعربية <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('description_ar') is-invalid @enderror"
                                    id="description_ar" name="description_ar" rows="4" dir="rtl"
                                    required>{{ old('description_ar', $workshop->description_ar) }}</textarea>
                                @error('description_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="description_en" class="form-label">الوصف بالإنجليزية <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('description_en') is-invalid @enderror"
                                    id="description_en" name="description_en" rows="4"
                                    required>{{ old('description_en', $workshop->description_en) }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="target_age_group" class="form-label">الفئة العمرية المستهدفة <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('target_age_group') is-invalid @enderror"
                                            id="target_age_group" name="target_age_group"
                                            value="{{ old('target_age_group', $workshop->target_age_group) }}"
                                            placeholder="مثال: 5-8 سنوات" required>
                                        @error('target_age_group')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="skills_developed" class="form-label">المهارات المكتسبة</label>
                                        <input type="text"
                                            class="form-control @error('skills_developed') is-invalid @enderror"
                                            id="skills_developed" name="skills_developed"
                                            value="{{ old('skills_developed', $workshop->skills_developed ?? '') }}">
                                        @error('skills_developed')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">قائمة مهارات مفصولة بفواصل</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-images me-1"></i>
                                    صورة الورشة
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">صورة الورشة</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">ستكون هذه الصورة الرئيسية المعروضة للورشة.</small>

                                        @if($workshop->image)
                                            <div class="mt-3">
                                                <div class="d-flex align-items-center">
                                                    <button type="button" id="remove_image_btn"
                                                        class="btn btn-danger btn-sm mx-2" data-bs-toggle="modal"
                                                        data-bs-target="#confirmModal">
                                                        <i class="fas fa-trash me-1"></i> إزالة الصورة
                                                    </button>
                                                    <a href="{{ asset('storage/' . $workshop->image) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        عرض الصورة الحالية
                                                    </a>
                                                </div>
                                                <div id="current-main-image" class="mt-2">
                                                    <img src="{{ asset('storage/' . $workshop->image) }}"
                                                        alt="الصورة الحالية" class="img-thumbnail"
                                                        style="max-height: 200px;">
                                                </div>
                                            </div>
                                        @endif

                                        <div id="main-image-preview-container" class="mt-2 d-none">
                                            <img id="main-image-preview" src="#" alt="معاينة الصورة الرئيسية"
                                                class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-cog me-1"></i>
                                        إعدادات الورشة
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1" {{ old('is_active', $workshop->is_active ?? 1) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">نشط</label>
                                            <small class="form-text text-muted d-block">الورش غير النشطة لن تكون مرئية
                                                للمستخدمين.</small>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_featured"
                                                name="is_featured" value="1" {{ old('is_featured', $workshop->is_featured ?? 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">ورشة مميزة</label>
                                            <small class="form-text text-muted d-block">قد يتم تسليط الضوء على الورش المميزة
                                                في الصفحة الرئيسية.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.workshops.show', $workshop) }}"
                                class="btn btn-secondary me-2">إلغاء</a>
                            <button type="submit" class="btn btn-primary mx-2">تحديث الورشة</button>
                        </div>
                </form>
            </div>
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
                    هل أنت متأكد من رغبتك في إزالة هذه الصورة؟
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

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
            const mainImageInput = document.getElementById('image');
            const mainImagePreview = document.getElementById('main-image-preview');
            const mainImagePreviewContainer = document.getElementById('main-image-preview-container');
            const removeMainImageBtn = document.getElementById('remove_image_btn');
            const currentMainImage = document.getElementById('current-main-image');

            if (mainImageInput) {
                mainImageInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            mainImagePreview.src = e.target.result;
                            mainImagePreviewContainer.classList.remove('d-none');

                            // Hide current image section if it exists when a new image is selected
                            if (currentMainImage && currentMainImage.parentElement) {
                                currentMainImage.parentElement.style.display = 'none';
                            }
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Remove image functionality
            if (removeMainImageBtn) {
                removeMainImageBtn.addEventListener('click', function () {
                    // Show the confirmation modal
                    confirmModal.show();
                });

                // Handle confirm button click
                document.getElementById('confirmRemoveBtn').addEventListener('click', function () {
                    confirmModal.hide();

                    // Show loading state
                    removeMainImageBtn.disabled = true;
                    removeMainImageBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> جاري الإزالة...';

                    // Make AJAX request to remove the image
                    fetch('{{ route('admin.workshops.remove-image', $workshop) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ type: 'main' })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hide the image container
                                if (currentMainImage) {
                                    currentMainImage.parentElement.remove();
                                }

                                // Show success message in result modal
                                document.getElementById('resultModalLabel').textContent = 'نجاح';
                                document.getElementById('resultModalBody').textContent = 'تمت إزالة الصورة بنجاح';
                                document.getElementById('resultModalBody').className = 'modal-body text-success';
                                resultModal.show();
                            } else {
                                // Show error message in result modal
                                document.getElementById('resultModalLabel').textContent = 'خطأ';
                                document.getElementById('resultModalBody').textContent = data.message || 'فشل في إزالة الصورة';
                                document.getElementById('resultModalBody').className = 'modal-body text-danger';
                                resultModal.show();

                                // Reset button state
                                removeMainImageBtn.disabled = false;
                                removeMainImageBtn.innerHTML = '<i class="fas fa-trash me-1"></i> إزالة الصورة';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);

                            // Show error message in result modal
                            document.getElementById('resultModalLabel').textContent = 'خطأ';
                            document.getElementById('resultModalBody').textContent = 'حدث خطأ أثناء إزالة الصورة';
                            document.getElementById('resultModalBody').className = 'modal-body text-danger';
                            resultModal.show();

                            // Reset button state
                            removeMainImageBtn.disabled = false;
                            removeMainImageBtn.innerHTML = '<i class="fas fa-trash me-1"></i> إزالة الصورة';
                        });
                });
            }
        });
    </script>
@endsection