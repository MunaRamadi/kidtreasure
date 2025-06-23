@extends('admin.layouts.app')

@section('title', 'إضافة قصة جديدة')

@section('styles')
<style>
.form-section {
    background: #f8f9fc;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #4e73df;
}
.form-section h5 {
    color: #4e73df;
    margin-bottom: 1rem;
    font-weight: 600;
}
.file-upload-area {
    border: 2px dashed #d1d3e2;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}
.file-upload-area:hover {
    border-color: #4e73df;
    background-color: #f8f9fc;
}
.file-upload-area.dragover {
    border-color: #4e73df;
    background-color: #e3f2fd;
}
.file-preview {
    max-width: 200px;
    max-height: 200px;
    border-radius: 8px;
    margin-top: 1rem;
}
.video-preview {
    max-width: 300px;
    max-height: 200px;
    border-radius: 8px;
    margin-top: 1rem;
}
.featured-section {
    background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
    color: white;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
.character-count {
    font-size: 0.8rem;
    color: #6c757d;
    float: right;
}
.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}
.btn-preview {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary"></i>
            إضافة قصة جديدة
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.stories.index') }}">إدارة القصص</a></li>
                <li class="breadcrumb-item active">إضافة قصة جديدة</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" id="storyForm">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Child Information -->
                <div class="form-section">
                    <h5><i class="fas fa-child text-primary"></i> معلومات الطفل</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="child_name" class="form-label">اسم الطفل <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('child_name') is-invalid @enderror" 
                                       id="child_name" name="child_name" value="{{ old('child_name') }}" 
                                       placeholder="أدخل اسم الطفل" required>
                                @error('child_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="child_age" class="form-label">العمر <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('child_age') is-invalid @enderror" 
                                       id="child_age" name="child_age" value="{{ old('child_age') }}" 
                                       min="1" max="18" placeholder="العمر" required>
                                @error('child_age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story Content -->
                <div class="form-section">
                    <h5><i class="fas fa-book text-primary"></i> محتوى القصة</h5>
                    <div class="form-group">
                        <label for="title_ar" class="form-label">عنوان القصة (عربي) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror" 
                               id="title_ar" name="title_ar" value="{{ old('title_ar') }}" 
                               placeholder="أدخل عنوان القصة بالعربية" required maxlength="200">
                        <div class="character-count">
                            <span id="title_ar_count">0</span>/200 حرف
                        </div>
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title_en" class="form-label">عنوان القصة (انجليزي)</label>
                        <input type="text" class="form-control @error('title_en') is-invalid @enderror" 
                               id="title_en" name="title_en" value="{{ old('title_en') }}" 
                               placeholder="Enter story title in English" maxlength="200">
                        <div class="character-count">
                            <span id="title_en_count">0</span>/200 حرف
                        </div>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content_ar" class="form-label">محتوى القصة (عربي) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content_ar') is-invalid @enderror" 
                                  id="content_ar" name="content_ar" rows="10" 
                                  placeholder="اكتب محتوى القصة بالعربية..." required>{{ old('content_ar') }}</textarea>
                        <div class="character-count">
                            <span id="content_ar_count">0</span> حرف
                        </div>
                        @error('content_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content_en" class="form-label">محتوى القصة (انجليزي)</label>
                        <textarea class="form-control @error('content_en') is-invalid @enderror" 
                                  id="content_en" name="content_en" rows="10" 
                                  placeholder="Write story content in English...">{{ old('content_en') }}</textarea>
                        <div class="character-count">
                            <span id="content_en_count">0</span> حرف
                        </div>
                        @error('content_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Parent Information -->
                <div class="form-section">
                    <h5><i class="fas fa-user text-primary"></i> معلومات الوالد/المؤلف</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_name" class="form-label">اسم الوالد <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                       id="parent_name" name="parent_name" value="{{ old('parent_name') }}" 
                                       placeholder="أدخل اسم الوالد" required>
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control @error('parent_email') is-invalid @enderror" 
                                       id="parent_email" name="parent_email" value="{{ old('parent_email') }}" 
                                       placeholder="أدخل البريد الإلكتروني">
                                @error('parent_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parent_phone" class="form-label">رقم الهاتف</label>
                        <input type="tel" class="form-control @error('parent_phone') is-invalid @enderror" 
                               id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" 
                               placeholder="أدخل رقم الهاتف">
                        @error('parent_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Media Upload -->
                <div class="form-section">
                    <h5><i class="fas fa-image text-primary"></i> الوسائط المرفقة</h5>
                    
                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="image" class="form-label">صورة القصة</label>
                        <div class="file-upload-area" onclick="document.getElementById('image').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-0">اضغط لاختيار صورة أو اسحب الملف هنا</p>
                            <small class="text-muted">JPG, PNG, GIF (حد أقصى 5MB)</small>
                        </div>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*" style="display: none;">
                        <div id="imagePreview" class="mt-3"></div>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Video Upload -->
                    <div class="form-group">
                        <label for="video" class="form-label">فيديو القصة</label>
                        <div class="file-upload-area" onclick="document.getElementById('video').click()">
                            <i class="fas fa-video fa-3x text-muted mb-3"></i>
                            <p class="mb-0">اضغط لاختيار فيديو أو اسحب الملف هنا</p>
                            <small class="text-muted">MP4, AVI, MOV (حد أقصى 50MB)</small>
                        </div>
                        <input type="file" class="form-control-file @error('video') is-invalid @enderror" 
                               id="video" name="video" accept="video/*" style="display: none;">
                        <div id="videoPreview" class="mt-3"></div>
                        @error('video')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Story Preview -->
                <div class="form-section">
                    <h5><i class="fas fa-eye text-primary"></i> معاينة القصة</h5>
                    <button type="button" class="btn btn-preview" id="previewBtn">
                        <i class="fas fa-eye"></i> معاينة القصة
                    </button>
                    <div id="storyPreview" class="mt-3" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h5 id="previewTitle">عنوان القصة</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="previewImage"></div>
                                        <div id="previewVideo"></div>
                                    </div>
                                    <div class="col-md-8">
                                        <p><strong>اسم الطفل:</strong> <span id="previewChildName"></span></p>
                                        <p><strong>العمر:</strong> <span id="previewChildAge"></span> سنوات</p>
                                        <p><strong>الوالد:</strong> <span id="previewParentName"></span></p>
                                        <div id="previewContent"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Status & Options -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">إعدادات النشر</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status" class="form-label">حالة القصة</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status">
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                    في الانتظار
                                </option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>
                                    مقبولة
                                </option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>
                                    مرفوضة
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" 
                                       id="is_featured" name="is_featured" value="1" 
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    قصة مميزة
                                </label>
                            </div>
                            <small class="text-muted">القصص المميزة تظهر في المقدمة</small>
                        </div>

                        <div class="form-group">
                            <label for="admin_notes" class="form-label">ملاحظات الإدارة</label>
                            <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                      id="admin_notes" name="admin_notes" rows="4" 
                                      placeholder="ملاحظات داخلية للإدارة...">{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Featured Section -->
                <div class="featured-section">
                    <h6><i class="fas fa-star"></i> القصة المميزة</h6>
                    <p class="mb-2">عند تمييز القصة ستظهر في:</p>
                    <ul class="mb-0">
                        <li>الصفحة الرئيسية</li>
                        <li>قسم القصص المميزة</li>
                        <li>البحث المتقدم</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-2">
                            <i class="fas fa-save"></i> حفظ القصة
                        </button>
                        <button type="button" class="btn btn-secondary btn-block mb-2" id="saveDraftBtn">
                            <i class="fas fa-edit"></i> حفظ كمسودة
                        </button>
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-light btn-block">
                            <i class="fas fa-arrow-left"></i> العودة للقائمة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Character counting
    function updateCharCount(inputId, countId, maxLength = null) {
        const input = $('#' + inputId);
        const counter = $('#' + countId);
        
        function updateCount() {
            const length = input.val().length;
            counter.text(length + (maxLength ? '/' + maxLength : ''));
            
            if (maxLength && length > maxLength) {
                counter.parent().addClass('text-danger');
            } else {
                counter.parent().removeClass('text-danger');
            }
        }
        
        input.on('input', updateCount);
        updateCount(); // Initial count
    }
    
    updateCharCount('title_ar', 'title_ar_count', 200);
    updateCharCount('title_en', 'title_en_count', 200);
    updateCharCount('content_ar', 'content_ar_count');
    updateCharCount('content_en', 'content_en_count');

    // File upload handling
    $('#image').change(function() {
        handleImageUpload(this, 'imagePreview');
    });

    $('#video').change(function() {
        handleVideoUpload(this, 'videoPreview');
    });

    // Drag and drop functionality
    $('.file-upload-area').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $('.file-upload-area').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });

    $('.file-upload-area').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            const targetInput = $(this).next('input[type="file"]');
            targetInput[0].files = files;
            targetInput.trigger('change');
        }
    });

    // Story preview
    $('#previewBtn').click(function() {
        updateStoryPreview();
    });

    // Save as draft
    $('#saveDraftBtn').click(function() {
        $('#status').val('draft');
        $('#storyForm').submit();
    });

    // Form validation
    $('#storyForm').submit(function(e) {
        let isValid = true;
        
        // Check required fields
        const requiredFields = ['child_name', 'child_age', 'title_ar', 'content_ar', 'parent_name'];
        requiredFields.forEach(function(field) {
            const input = $('#' + field);
            if (!input.val().trim()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
            
            Swal.fire({
                title: 'خطأ في الإدخال',
                text: 'يرجى ملء جميع الحقول المطلوبة',
                icon: 'error',
                confirmButtonText: 'موافق'
            });
        }
    });
});

function handleImageUpload(input, previewId) {
    const file = input.files[0];
    const preview = $('#' + previewId);
    
    if (file) {
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                title: 'خطأ',
                text: 'يرجى اختيار ملف صورة صحيح',
                icon: 'error',
                confirmButtonText: 'موافق'
            });
            input.value = '';
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) { // 5MB
            Swal.fire({
                title: 'خطأ',
                text: 'حجم الصورة يجب أن يكون أقل من 5 ميجابايت',
                icon: 'error',
                confirmButtonText: 'موافق'
            });
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.html(`
                <div class="position-relative d-inline-block">
                    <img src="${e.target.result}" alt="معاينة الصورة" class="file-preview">
                    <button type="button" class="btn btn-sm btn-danger position-absolute" 
                            style="top: 5px; right: 5px;" onclick="removeFile('${input.id}', '${previewId}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
        };
        reader.readAsDataURL(file);
    }
}

function handleVideoUpload(input, previewId) {
    const file = input.files[0];
    const preview = $('#' + previewId);
    
    if (file) {
        if (!file.type.startsWith('video/')) {
            Swal.fire({
                title: 'خطأ',
                text: 'يرجى اختيار ملف فيديو صحيح',
                icon: 'error',
                confirmButtonText: 'موافق'
            });
            input.value = '';
            return;
        }
        
        if (file.size > 50 * 1024 * 1024) { // 50MB
            Swal.fire({
                title: 'خطأ',
                text: 'حجم الفيديو يجب أن يكون أقل من 50 ميجابايت',
                icon: 'error',
                confirmButtonText: 'موافق'
            });
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.html(`
                <div class="position-relative d-inline-block">
                    <video src="${e.target.result}" class="video-preview" controls></video>
                    <button type="button" class="btn btn-sm btn-danger position-absolute" 
                            style="top: 5px; right: 5px;" onclick="removeFile('${input.id}', '${previewId}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
        };
        reader.readAsDataURL(file);
    }
}

function removeFile(inputId, previewId) {
    $('#' + inputId).val('');
    $('#' + previewId).empty();
}

function updateStoryPreview() {
    const title = $('#title_ar').val() || 'عنوان القصة';
    const childName = $('#child_name').val() || 'اسم الطفل';
    const childAge = $('#child_age').val() || 'العمر';
    const parentName = $('#parent_name').val() || 'اسم الوالد';
    const content = $('#content_ar').val() || 'محتوى القصة';
    
    $('#previewTitle').text(title);
    $('#previewChildName').text(childName);
    $('#previewChildAge').text(childAge);
    $('#previewParentName').text(parentName);
    $('#previewContent').html('<p>' + content.replace(/\n/g, '</p><p>') + '</p>');
    
    // Handle image preview
    const imageInput = $('#image')[0];
    if (imageInput.files && imageInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImage').html(`<img src="${e.target.result}" alt="صورة القصة" class="img-fluid mb-3" style="max-width: 100%; border-radius: 8px;">`);
        };
        reader.readAsDataURL(imageInput.files[0]);
    } else {
        $('#previewImage').empty();
    }
    
    // Handle video preview
    const videoInput = $('#video')[0];
    if (videoInput.files && videoInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#previewVideo').html(`<video src="${e.target.result}" class="img-fluid mb-3" controls style="max-width: 100%; border-radius: 8px;"></video>`);
        };
        reader.readAsDataURL(videoInput.files[0]);
    } else {
        $('#previewVideo').empty();
    }
    
    $('#storyPreview').slideDown();
}
</script>
@endsection