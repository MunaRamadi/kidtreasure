@extends('admin.layouts.app')

@section('title', 'إرسال قصة جديدة')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">إرسال قصة جديدة</h1>
            <p class="mb-0 text-muted">شاركنا قصة طفلك وساعدنا في إلهام الآخرين</p>
        </div>
        <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للقائمة
        </a>
    </div>

    <!-- Instructions Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle me-2"></i>
                إرشادات مهمة
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <ul class="mb-0 text-dark">
                        <li class="mb-2">تأكد من أن القصة تتعلق بطفل وتجربته الإبداعية</li>
                        <li class="mb-2">استخدم لغة مناسبة ومحترمة</li>
                        <li class="mb-2">الصور والفيديوهات يجب أن تكون واضحة ومناسبة</li>
                        <li class="mb-2">سيتم مراجعة القصة قبل نشرها</li>
                        <li class="mb-0">يمكن كتابة القصة بالعربية أو الإنجليزية أو كلاهما</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- معلومات الطفل -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-child me-2"></i>
                    معلومات الطفل
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="child_name" class="form-label">
                            اسم الطفل <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               id="child_name" 
                               name="child_name" 
                               value="{{ old('child_name') }}"
                               class="form-control @error('child_name') is-invalid @enderror"
                               required>
                        @error('child_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="child_age" class="form-label">
                            عمر الطفل
                        </label>
                        <input type="number" 
                               id="child_age" 
                               name="child_age" 
                               value="{{ old('child_age') }}"
                               min="1" 
                               max="18"
                               class="form-control @error('child_age') is-invalid @enderror">
                        @error('child_age')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- معلومات الوالد -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-2"></i>
                    معلومات التواصل
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="parent_name" class="form-label">
                            اسم الوالد/الوالدة
                        </label>
                        <input type="text" 
                               id="parent_name" 
                               name="parent_name" 
                               value="{{ old('parent_name') }}"
                               class="form-control @error('parent_name') is-invalid @enderror">
                        @error('parent_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="parent_contact" class="form-label">
                            معلومات التواصل (إيميل أو رقم هاتف)
                        </label>
                        <input type="text" 
                               id="parent_contact" 
                               name="parent_contact" 
                               value="{{ old('parent_contact') }}"
                               class="form-control @error('parent_contact') is-invalid @enderror">
                        @error('parent_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- محتوى القصة -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-book me-2"></i>
                    محتوى القصة
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- العنوان بالعربية -->
                    <div class="col-md-6 mb-3">
                        <label for="title_ar" class="form-label">
                            عنوان القصة بالعربية
                        </label>
                        <input type="text" 
                               id="title_ar" 
                               name="title_ar" 
                               value="{{ old('title_ar') }}"
                               class="form-control @error('title_ar') is-invalid @enderror"
                               placeholder="أدخل عنوان القصة بالعربية">
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- العنوان بالإنجليزية -->
                    <div class="col-md-6 mb-3">
                        <label for="title_en" class="form-label">
                            عنوان القصة بالإنجليزية
                        </label>
                        <input type="text" 
                               id="title_en" 
                               name="title_en" 
                               value="{{ old('title_en') }}"
                               class="form-control @error('title_en') is-invalid @enderror"
                               placeholder="Enter story title in English">
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- المحتوى بالعربية -->
                    <div class="col-12 mb-3">
                        <label for="content_ar" class="form-label">
                            محتوى القصة بالعربية <span class="text-danger">*</span>
                        </label>
                        <textarea id="content_ar" 
                                  name="content_ar" 
                                  rows="8"
                                  class="form-control @error('content_ar') is-invalid @enderror"
                                  placeholder="اكتب قصة الطفل بالتفصيل..."
                                  required>{{ old('content_ar') }}</textarea>
                        @error('content_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- المحتوى بالإنجليزية -->
                    <div class="col-12 mb-3">
                        <label for="content_en" class="form-label">
                            محتوى القصة بالإنجليزية
                        </label>
                        <textarea id="content_en" 
                                  name="content_en" 
                                  rows="8"
                                  class="form-control @error('content_en') is-invalid @enderror"
                                  placeholder="Write the story content in English...">{{ old('content_en') }}</textarea>
                        @error('content_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- تفاصيل إضافية -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info me-2"></i>
                    تفاصيل إضافية
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lesson_learned" class="form-label">
                            الدرس المستفاد
                        </label>
                        <textarea id="lesson_learned" 
                                  name="lesson_learned" 
                                  rows="4"
                                  class="form-control @error('lesson_learned') is-invalid @enderror"
                                  placeholder="ما هو الدرس الذي تعلمه الطفل؟">{{ old('lesson_learned') }}</textarea>
                        @error('lesson_learned')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="materials_used" class="form-label">
                            المواد المستخدمة
                        </label>
                        <textarea id="materials_used" 
                                  name="materials_used" 
                                  rows="4"
                                  class="form-control @error('materials_used') is-invalid @enderror"
                                  placeholder="ما هي المواد التي استخدمها الطفل؟">{{ old('materials_used') }}</textarea>
                        @error('materials_used')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="duration" class="form-label">
                            المدة المستغرقة
                        </label>
                        <input type="text" 
                               id="duration" 
                               name="duration" 
                               value="{{ old('duration') }}"
                               class="form-control @error('duration') is-invalid @enderror"
                               placeholder="مثال: 30 دقيقة، ساعة واحدة">
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                  <div class="row">
    <div class="col-md-6 mb-3">
        <label for="difficulty_level" class="form-label">
            مستوى الصعوبة
        </label>
        <select id="difficulty_level" 
                name="difficulty_level"
                class="form-select @error('difficulty_level') is-invalid @enderror">
            <option value="">اختر مستوى الصعوبة</option>
            <option value="Easy" {{ old('difficulty_level') == 'Easy' ? 'selected' : '' }}>سهل</option>
            <option value="Medium" {{ old('difficulty_level') == 'Medium' ? 'selected' : '' }}>متوسط</option>
            <option value="Hard" {{ old('difficulty_level') == 'Hard' ? 'selected' : '' }}>صعب</option>
        </select>
        @error('difficulty_level')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">
            حالة القصة <span class="text-danger">*</span>
        </label>
        <select id="status" 
                name="status"
                class="form-select @error('status') is-invalid @enderror"
                required>
            <option value="approved" {{ old('status', 'approved') == 'approved' ? 'selected' : '' }}>مقبولة (نشر فوري)</option>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    </div>

        <!-- الوسائط -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-images me-2"></i>
                    الصور والفيديوهات
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">
                            صورة القصة
                        </label>
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               class="form-control @error('image') is-invalid @enderror">
                        <div class="form-text">الحد الأقصى: 5 ميجابايت</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="video" class="form-label">
                            فيديو القصة
                        </label>
                        <input type="file" 
                               id="video" 
                               name="video" 
                               accept="video/*"
                               class="form-control @error('video') is-invalid @enderror">
                        <div class="form-text">الحد الأقصى: 50 ميجابايت</div>
                        @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Preview areas -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div id="image-preview" class="d-none">
                            <label class="form-label">معاينة الصورة:</label>
                            <div class="border rounded p-2">
                                <img id="preview-img" src="" alt="معاينة الصورة" class="img-fluid" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="video-preview" class="d-none">
                            <label class="form-label">معاينة الفيديو:</label>
                            <div class="border rounded p-2">
                                <video id="preview-video" controls class="w-100" style="max-height: 200px;">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الموافقات -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-check-circle me-2"></i>
                    الموافقات المطلوبة
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input @error('privacy_consent') is-invalid @enderror" 
                                   type="checkbox" 
                                   value="1" 
                                   id="privacy_consent"
                                   name="privacy_consent"
                                   required>
                            <label class="form-check-label" for="privacy_consent">
                                <strong>أوافق على سياسة الخصوصية</strong> <span class="text-danger">*</span>
                                <br>
                                <small class="text-muted">أوافق على نشر قصة طفلي على الموقع بعد المراجعة</small>
                            </label>
                            @error('privacy_consent')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input @error('data_consent') is-invalid @enderror" 
                                   type="checkbox" 
                                   value="1" 
                                   id="data_consent"
                                   name="data_consent"
                                   required>
                            <label class="form-check-label" for="data_consent">
                                <strong>أوافق على معالجة البيانات</strong> <span class="text-danger">*</span>
                                <br>
                                <small class="text-muted">أوافق على معالجة البيانات المرسلة لأغراض النشر</small>
                            </label>
                            @error('data_consent')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- أزرار الإرسال -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.stories.index') }}" 
                       class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>
                        إلغاء
                    </a>
                    
                    <button type="submit" 
                            class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>
                        إرسال القصة
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Preview functionality for images
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewDiv = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewDiv.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewDiv.classList.add('d-none');
        }
    });

    // Preview functionality for videos
    document.getElementById('video').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewDiv = document.getElementById('video-preview');
        const previewVideo = document.getElementById('preview-video');
        
        if (file) {
            const url = URL.createObjectURL(file);
            previewVideo.src = url;
            previewDiv.classList.remove('d-none');
        } else {
            previewDiv.classList.add('d-none');
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const privacyConsent = document.getElementById('privacy_consent');
        const dataConsent = document.getElementById('data_consent');
        
        if (!privacyConsent.checked || !dataConsent.checked) {
            e.preventDefault();
            alert('يجب الموافقة على جميع الشروط المطلوبة');
        }
    });

    // Character count for textareas (optional)
    document.querySelectorAll('textarea').forEach(function(textarea) {
        textarea.addEventListener('input', function() {
            // You can add character count functionality here
        });
    });
</script>
@endpush

@push('styles')
<style>
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .text-danger {
        color: #e74a3b !important;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    
    .btn-secondary {
        background-color: #858796;
        border-color: #858796;
    }
    
    .btn-secondary:hover {
        background-color: #717384;
        border-color: #6c757d;
    }
    
    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .invalid-feedback {
        font-size: 0.875rem;
    }
    
    .form-check-label {
        line-height: 1.5;
    }
    
    .form-check-label small {
        display: block;
        margin-top: 0.25rem;
    }
    
    .shadow {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
    
    #image-preview img,
    #video-preview video {
        border-radius: 0.375rem;
    }
</style>
@endpush
@endsection