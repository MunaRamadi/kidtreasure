@extends('admin.layouts.app')

@section('title', 'إضافة صندوق تعليمي جديد')

@section('content')
<div class="container-fluid" dir="rtl">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">إضافة صندوق تعليمي جديد</h1>
            <p class="mb-0 text-muted">إنشاء صندوق تعليمي جديد للمتجر</p>
        </div>
        <div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                العودة إلى قائمة الصناديق
            </a>
        </div>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>يرجى تصحيح الأخطاء التالية:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Basic Information -->
            <div class="col-lg-8">
                <!-- Basic Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>
                            المعلومات الأساسية
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-box me-2"></i>
                                اسم الصندوق <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="أدخل اسم الصندوق التعليمي"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-2"></i>
                                وصف الصندوق <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="أدخل وصفاً تفصيلياً للصندوق التعليمي"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Box Type and Age Group Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="box_type" class="form-label">
                                        <i class="fas fa-tag me-2"></i>
                                        نوع الصندوق <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('box_type') is-invalid @enderror" 
                                            id="box_type" 
                                            name="box_type" 
                                            required>
                                        <option value="">اختر نوع الصندوق</option>
                                        @foreach($boxTypes as $key => $value)
                                            <option value="{{ $key }}" {{ old('box_type') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('box_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="age_group" class="form-label">
                                        <i class="fas fa-child me-2"></i>
                                        الفئة العمرية <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('age_group') is-invalid @enderror" 
                                           id="age_group" 
                                           name="age_group" 
                                           value="{{ old('age_group') }}" 
                                           placeholder="مثال: 6-12 سنة"
                                           required>
                                    @error('age_group')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Difficulty Level and Price Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="difficulty_level" class="form-label">
                                        <i class="fas fa-signal me-2"></i>
                                        مستوى الصعوبة <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                            id="difficulty_level" 
                                            name="difficulty_level" 
                                            required>
                                        <option value="">اختر مستوى الصعوبة</option>
                                        @foreach($difficultyLevels as $key => $value)
                                            <option value="{{ $key }}" {{ old('difficulty_level') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('difficulty_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price_jod" class="form-label">
                                        <i class="fas fa-dollar-sign me-2"></i>
                                        السعر (دينار أردني) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('price_jod') is-invalid @enderror" 
                                           id="price_jod" 
                                           name="price_jod" 
                                           value="{{ old('price_jod') }}" 
                                           min="0" 
                                           step="0.01" 
                                           placeholder="0.00"
                                           required>
                                    @error('price_jod')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stock Quantity -->
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">
                                <i class="fas fa-warehouse me-2"></i>
                                كمية المخزون <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock_quantity') is-invalid @enderror" 
                                   id="stock_quantity" 
                                   name="stock_quantity" 
                                   value="{{ old('stock_quantity', 0) }}" 
                                   min="0" 
                                   placeholder="0"
                                   required>
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Details Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-list-ul me-2"></i>
                            التفاصيل الإضافية
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Contents -->
                        <div class="mb-3">
                            <label for="contents" class="form-label">
                                <i class="fas fa-cube me-2"></i>
                                محتويات الصندوق
                            </label>
                            <textarea class="form-control @error('contents') is-invalid @enderror" 
                                      id="contents" 
                                      name="contents" 
                                      rows="5" 
                                      placeholder="أدخل قائمة بمحتويات الصندوق (اختياري)">{{ old('contents') }}</textarea>
                            @error('contents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">يمكنك استخدام أسطر منفصلة لكل عنصر</div>
                        </div>

                        <!-- Educational Goals -->
                        <div class="mb-3">
                            <label for="educational_goals" class="form-label">
                                <i class="fas fa-graduation-cap me-2"></i>
                                الأهداف التعليمية
                            </label>
                            <textarea class="form-control @error('educational_goals') is-invalid @enderror" 
                                      id="educational_goals" 
                                      name="educational_goals" 
                                      rows="4" 
                                      placeholder="أدخل الأهداف التعليمية للصندوق (اختياري)">{{ old('educational_goals') }}</textarea>
                            @error('educational_goals')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Images Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-images me-2"></i>
                            الصور
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Featured Image (Box Image) -->
                        <div class="mb-4">
                            <label for="featured_image" class="form-label">
                                <i class="fas fa-box me-2"></i>
                                صورة الصندوق
                            </label>
                            <input type="file" 
                                   class="form-control @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" 
                                   name="featured_image" 
                                   accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">صورة الصندوق الخارجي (اختياري)</div>
                            
                            <!-- Image Preview -->
                            <div id="featured-image-preview" class="mt-2" style="display: none;">
                                <img id="featured-image-preview-img" src="" alt="معاينة الصورة" 
                                     class="img-fluid rounded border" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="mb-3">
                            <label for="product_image" class="form-label">
                                <i class="fas fa-gift me-2"></i>
                                صورة المنتج
                            </label>
                            <input type="file" 
                                   class="form-control @error('product_image') is-invalid @enderror" 
                                   id="product_image" 
                                   name="product_image" 
                                   accept="image/*">
                            @error('product_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">صورة محتويات الصندوق (اختياري)</div>
                            
                            <!-- Image Preview -->
                            <div id="product-image-preview" class="mt-2" style="display: none;">
                                <img id="product-image-preview-img" src="" alt="معاينة الصورة" 
                                     class="img-fluid rounded border" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-toggle-on me-2"></i>
                            حالة النشر
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Active Status -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-eye me-2"></i>
                                نشط ومرئي للعملاء
                            </label>
                        </div>

                        <!-- Featured Status -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star me-2"></i>
                                صندوق مميز
                            </label>
                        </div>
                        <div class="form-text">الصناديق المميزة تظهر في الصفحة الرئيسية</div>
                    </div>
                </div>

                <!-- Box Type Preview Card -->
                <div class="card shadow mb-4" id="box-type-preview" style="display: none;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-eye me-2"></i>
                            معاينة نوع الصندوق
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <div id="box-emoji" style="font-size: 3rem; margin-bottom: 1rem;"></div>
                        <h6 id="box-name" class="text-primary"></h6>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                حفظ الصندوق
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Box Type Preview
    const boxTypeSelect = document.getElementById('box_type');
    const boxTypePreview = document.getElementById('box-type-preview');
    const boxEmoji = document.getElementById('box-emoji');
    const boxName = document.getElementById('box-name');
    
    const boxTypes = {
        'innovation': {emoji: '🚀', name: 'صندوق الابتكار'},
        'creativity': {emoji: '🎨', name: 'صندوق الإبداع'},
        'treasure': {emoji: '💎', name: 'صندوق الكنز'},
        'discovery': {emoji: '🔍', name: 'صندوق الاستكشاف'},
        'science': {emoji: '🔬', name: 'صندوق العلوم'},
        'art': {emoji: '🎭', name: 'صندوق الفنون'}
    };
    
    boxTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        if (selectedType && boxTypes[selectedType]) {
            boxEmoji.textContent = boxTypes[selectedType].emoji;
            boxName.textContent = boxTypes[selectedType].name;
            boxTypePreview.style.display = 'block';
        } else {
            boxTypePreview.style.display = 'none';
        }
    });
    
    // Image Preview Functions
    function setupImagePreview(inputId, previewId, previewImgId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const previewImg = document.getElementById(previewImgId);
        
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    }
    
    // Setup image previews
    setupImagePreview('featured_image', 'featured-image-preview', 'featured-image-preview-img');
    setupImagePreview('product_image', 'product-image-preview', 'product-image-preview-img');
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = ['name', 'description', 'box_type', 'age_group', 'difficulty_level', 'price_jod', 'stock_quantity'];
        let isValid = true;
        
        requiredFields.forEach(function(field) {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('يرجى ملء جميع الحقول المطلوبة');
        }
    });
    
    // Auto-generate slug preview (optional)
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function() {
        // Could add slug preview here if needed
    });
});
</script>
@endpush

@push('styles')
<style>
.form-check-input:checked {
    background-color: #4e73df;
    border-color: #4e73df;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}

.invalid-feedback {
    display: block;
}

#box-type-preview {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

@media (max-width: 768px) {
    .d-grid.gap-2 {
        gap: 0.75rem !important;
    }
}
</style>
@endpush
@endsection