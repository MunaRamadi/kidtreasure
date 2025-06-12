@extends('admin.layouts.app')

@section('title', 'إضافة صندوق تعليمي جديد')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">إضافة صندوق تعليمي جديد</h1>
            <p class="mb-0 text-muted">أضف صندوق تعليمي جديد إلى متجرك</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            العودة إلى قائمة الصناديق
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Product Information Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>
                            معلومات الصندوق التعليمي
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Product Name -->
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">اسم الصندوق <span class="text-danger">*</span></label>
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
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">الوصف <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="أدخل وصف تفصيلي للصندوق التعليمي"
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Box Type -->
                            <div class="col-md-6 mb-3">
                                <label for="box_type" class="form-label">نوع الصندوق <span class="text-danger">*</span></label>
                                <select class="form-select @error('box_type') is-invalid @enderror" 
                                        id="box_type" 
                                        name="box_type" 
                                        required>
                                    <option value="">اختر نوع الصندوق</option>
                                    <option value="innovation" {{ old('box_type') == 'innovation' ? 'selected' : '' }}>
                                        🚀 صندوق الابتكار
                                    </option>
                                    <option value="creativity" {{ old('box_type') == 'creativity' ? 'selected' : '' }}>
                                        🎨 صندوق الإبداع
                                    </option>
                                    <option value="treasure" {{ old('box_type') == 'treasure' ? 'selected' : '' }}>
                                        💎 صندوق الكنز
                                    </option>
                                    <option value="discovery" {{ old('box_type') == 'discovery' ? 'selected' : '' }}>
                                        🔍 صندوق الاستكشاف
                                    </option>
                                    <option value="science" {{ old('box_type') == 'science' ? 'selected' : '' }}>
                                        🧪 صندوق العلوم
                                    </option>
                                    <option value="art" {{ old('box_type') == 'art' ? 'selected' : '' }}>
                                        🎭 صندوق الفنون
                                    </option>
                                </select>
                                @error('box_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Age Group -->
                            <div class="col-md-6 mb-3">
                                <label for="age_group" class="form-label">الفئة العمرية <span class="text-danger">*</span></label>
                                <select class="form-select @error('age_group') is-invalid @enderror" 
                                        id="age_group" 
                                        name="age_group" 
                                        required>
                                    <option value="">اختر الفئة العمرية</option>
                                    @foreach($ageGroups as $ageGroup)
                                        <option value="{{ $ageGroup }}" {{ old('age_group') == $ageGroup ? 'selected' : '' }}>
                                            {{ $ageGroup }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('age_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Difficulty Level -->
                            <div class="col-md-6 mb-3">
                                <label for="difficulty_level" class="form-label">مستوى الصعوبة <span class="text-danger">*</span></label>
                                <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                        id="difficulty_level" 
                                        name="difficulty_level" 
                                        required>
                                    <option value="">اختر مستوى الصعوبة</option>
                                    <option value="مبتدئ" {{ old('difficulty_level') == 'مبتدئ' ? 'selected' : '' }}>
                                        🟢 مبتدئ
                                    </option>
                                    <option value="متوسط" {{ old('difficulty_level') == 'متوسط' ? 'selected' : '' }}>
                                        🟡 متوسط
                                    </option>
                                    <option value="متقدم" {{ old('difficulty_level') == 'متقدم' ? 'selected' : '' }}>
                                        🔴 متقدم
                                    </option>
                                </select>
                                @error('difficulty_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price_jod" class="form-label">السعر (دينار أردني) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control @error('price_jod') is-invalid @enderror" 
                                           id="price_jod" 
                                           name="price_jod" 
                                           value="{{ old('price_jod') }}" 
                                           step="0.01" 
                                           min="0" 
                                           placeholder="0.00"
                                           required>
                                    <span class="input-group-text">دينار</span>
                                    @error('price_jod')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Stock Quantity -->
                            <div class="col-md-12 mb-3">
                                <label for="stock_quantity" class="form-label">كمية المخزون <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       id="stock_quantity" 
                                       name="stock_quantity" 
                                       value="{{ old('stock_quantity') }}" 
                                       min="0" 
                                       placeholder="أدخل كمية المخزون"
                                       required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contents and Educational Goals Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list-ul me-2"></i>
                            المحتويات والأهداف التعليمية
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Contents -->
                            <div class="col-md-12 mb-3">
                                <label for="contents" class="form-label">محتويات الصندوق</label>
                                <textarea class="form-control @error('contents') is-invalid @enderror" 
                                          id="contents" 
                                          name="contents" 
                                          rows="4" 
                                          placeholder="اكتب محتويات الصندوق (كل عنصر في سطر منفصل)&#10;مثال:&#10;- قطع ليجو ملونة&#10;- دليل التعليمات&#10;- ملصقات تفاعلية&#10;- أدوات القياس">{{ old('contents') }}</textarea>
                                <small class="form-text text-muted">اكتب كل عنصر في سطر منفصل أو افصل بينها بفواصل</small>
                                @error('contents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Educational Goals -->
                            <div class="col-md-12 mb-3">
                                <label for="educational_goals" class="form-label">الأهداف التعليمية</label>
                                <textarea class="form-control @error('educational_goals') is-invalid @enderror" 
                                          id="educational_goals" 
                                          name="educational_goals" 
                                          rows="3" 
                                          placeholder="اكتب الأهداف التعليمية للصندوق&#10;مثال:&#10;- تطوير مهارات حل المشاكل&#10;- تحفيز الإبداع والابتكار&#10;- تعلم العمل الجماعي">{{ old('educational_goals') }}</textarea>
                                <small class="form-text text-muted">حدد الأهداف التعليمية والمهارات التي يطورها هذا الصندوق</small>
                                @error('educational_goals')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Product Image Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-image me-2"></i>
                            صورة الصندوق
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">رفع صورة</label>
                            <input type="file" 
                                   class="form-control @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" 
                                   name="featured_image" 
                                   accept="image/*"
                                   onchange="previewImage(event)">
                            <small class="form-text text-muted">الحد الأقصى: 2MB، الأنواع المدعومة: JPG, PNG, GIF</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="imagePreview" class="text-center" style="display: none;">
                            <img id="preview" src="" alt="معاينة الصورة" class="img-fluid rounded shadow" style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2 d-block mx-auto" onclick="removeImage()">
                                <i class="fas fa-trash me-1"></i>
                                إزالة الصورة
                            </button>
                        </div>

                        <div class="mt-3 p-3 bg-light rounded">
                            <small class="text-muted">
                                <i class="fas fa-lightbulb me-1"></i>
                                <strong>نصائح للصورة:</strong><br>
                                • استخدم صورة عالية الجودة<br>
                                • تأكد من وضوح المنتج<br>
                                • الخلفية البيضاء مفضلة<br>
                                • الحجم المثالي: 800x800 بكسل
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Product Settings Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-cog me-2"></i>
                            إعدادات الصندوق
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-eye me-1"></i>
                                صندوق مفعل
                            </label>
                            <small class="form-text text-muted d-block">إذا كان مفعلاً، سيظهر الصندوق في المتجر</small>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   value="1" 
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star me-1"></i>
                                صندوق مميز
                            </label>
                            <small class="form-text text-muted d-block">الصناديق المميزة تظهر في الصفحة الرئيسية</small>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>الصناديق المميزة لها أولوية في العرض وتجذب المزيد من الانتباه</small>
                        </div>
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
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i>
                                إعادة تعيين
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                سيتم حفظ الصندوق كمسودة إذا لم يكن مفعلاً
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    border-color: #007bff;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}

#imagePreview img {
    transition: all 0.3s ease;
    border: 3px solid #e3e6f0;
}

#imagePreview img:hover {
    transform: scale(1.05);
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

.bg-light {
    background-color: #f8f9fc !important;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    transform: translateY(-1px);
}
</style>
@endpush

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('حجم الملف كبير جداً. الحد الأقصى 2 ميجابايت.');
            event.target.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('نوع الملف غير مدعوم. يرجى اختيار JPG أو PNG أو GIF.');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('featured_image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
}

function resetForm() {
    if (confirm('هل أنت متأكد من رغبتك في إعادة تعيين النموذج؟ سيتم فقدان جميع البيانات المدخلة.')) {
        document.getElementById('productForm').reset();
        removeImage();
        // Remove validation classes
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }
}

// Enhanced form validation
document.getElementById('productForm').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'description', 'box_type', 'age_group', 'difficulty_level', 'price_jod', 'stock_quantity'];
    let isValid = true;
    let firstInvalidField = null;
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            element.classList.add('is-invalid');
            if (!firstInvalidField) {
                firstInvalidField = element;
            }
            isValid = false;
        } else {
            element.classList.remove('is-invalid');
        }
    });
    
    // Validate price
    const price = document.getElementById('price_jod');
    if (price.value && parseFloat(price.value) <= 0) {
        price.classList.add('is-invalid');
        isValid = false;
        if (!firstInvalidField) firstInvalidField = price;
    }
    
    // Validate stock quantity
    const stock = document.getElementById('stock_quantity');
    if (stock.value && parseInt(stock.value) < 0) {
        stock.classList.add('is-invalid');
        isValid = false;
        if (!firstInvalidField) firstInvalidField = stock;
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('يرجى ملء جميع الحقول المطلوبة والتأكد من صحة البيانات');
        if (firstInvalidField) {
            firstInvalidField.focus();
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});

// Real-time validation
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    function validateField(field) {
        if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('is-invalid');
        } else if (field.type === 'number' && field.value) {
            if (field.id === 'price_jod' && parseFloat(field.value) <= 0) {
                field.classList.add('is-invalid');
            } else if (field.id === 'stock_quantity' && parseInt(field.value) < 0) {
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        } else {
            field.classList.remove('is-invalid');
        }
    }
    
    // Auto-save draft functionality (optional)
    let autoSaveTimeout;
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                saveDraft();
            }, 30000); // Save after 30 seconds of inactivity
        });
    });
    
    function saveDraft() {
        const formData = new FormData(document.getElementById('productForm'));
        const data = {};
        for (let [key, value] of formData.entries()) {
            if (key !== '_token' && key !== 'featured_image') {
                data[key] = value;
            }
        }
        localStorage.setItem('productDraft', JSON.stringify(data));
        
        // Show subtle notification
        const notification = document.createElement('div');
        notification.className = 'alert alert-success position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; opacity: 0.8;';
        notification.innerHTML = '<i class="fas fa-save me-2"></i>تم حفظ المسودة تلقائياً';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // Load draft on page load
    const draft = localStorage.getItem('productDraft');
    if (draft && confirm('تم العثور على مسودة محفوظة. هل تريد استكمالها؟')) {
        const data = JSON.parse(draft);
        Object.keys(data).forEach(key => {
            const field = document.getElementById(key);
            if (field) {
                if (field.type === 'checkbox') {
                    field.checked = data[key] === '1';
                } else {
                    field.value = data[key];
                }
            }
        });
    }
});

// Clear draft on successful submission
document.getElementById('productForm').addEventListener('submit', function() {
    localStorage.removeItem('productDraft');
});
</script>
@endpush