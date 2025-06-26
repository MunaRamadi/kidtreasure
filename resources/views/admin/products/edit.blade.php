@extends('admin.layouts.app')

@section('title', 'تعديل الصندوق: ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">تعديل الصندوق التعليمي</h1>
            <p class="mb-0 text-muted">أنت تقوم بتعديل: <strong>{{ $product->name }}</strong></p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            العودة إلى القائمة
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">معلومات الصندوق</h6></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الصندوق <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="box_type" class="form-label">نوع الصندوق <span class="text-danger">*</span></label>
                                <select class="form-select @error('box_type') is-invalid @enderror" id="box_type" name="box_type" required>
                                    <option value="">اختر النوع</option>
                                    @foreach($boxTypes as $key => $value)
                                        <option value="{{ $key }}" {{ old('box_type', $product->box_type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('box_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="age_group" class="form-label">الفئة العمرية <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('age_group') is-invalid @enderror" id="age_group" name="age_group" value="{{ old('age_group', $product->age_group) }}" required>
                                @error('age_group') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="difficulty_level" class="form-label">مستوى الصعوبة <span class="text-danger">*</span></label>
                                <select class="form-select @error('difficulty_level') is-invalid @enderror" id="difficulty_level" name="difficulty_level" required>
                                    <option value="">اختر المستوى</option>
                                    @foreach($difficultyLevels as $key => $value)
                                        <option value="{{ $key }}" {{ old('difficulty_level', $product->difficulty_level) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('difficulty_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price_jod" class="form-label">السعر (دينار) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price_jod') is-invalid @enderror" id="price_jod" name="price_jod" value="{{ old('price_jod', $product->price_jod) }}" step="0.01" min="0" required>
                                @error('price_jod') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="stock_quantity" class="form-label">كمية المخزون <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                                @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- قسم المحتوى والأهداف التعليمية -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">محتوى الصندوق والأهداف التعليمية</h6></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="contents" class="form-label">محتويات الصندوق</label>
                            <textarea class="form-control @error('contents') is-invalid @enderror" id="contents" name="contents" rows="3" placeholder="اكتب محتويات الصندوق هنا...">{{ old('contents', $product->contents) }}</textarea>
                            @error('contents') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="educational_goals" class="form-label">الأهداف التعليمية</label>
                            <textarea class="form-control @error('educational_goals') is-invalid @enderror" id="educational_goals" name="educational_goals" rows="3" placeholder="اكتب الأهداف التعليمية هنا...">{{ old('educational_goals', $product->educational_goals) }}</textarea>
                            @error('educational_goals') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- صورة الصندوق -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-box me-2"></i>
                            صورة الصندوق
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">رفع صورة جديدة (اختياري)</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                            <small class="form-text text-muted">أنواع الملفات المسموحة: JPEG, PNG, JPG, GIF. الحد الأقصى: 2MB</small>
                            @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        @if($product->featured_image_path)
                            <div class="text-center">
                                <label class="form-label">الصورة الحالية:</label>
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $product->featured_image_path) }}" 
                                         alt="صورة الصندوق" 
                                         class="img-fluid rounded shadow" 
                                         style="max-height: 200px; width: auto;">
                                    <span class="badge bg-primary position-absolute top-0 end-0 m-1">
                                        <i class="fas fa-box"></i>
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-3x mb-2"></i>
                                <p>لا توجد صورة للصندوق</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- صورة المنتج -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-cube me-2"></i>
                            صورة المنتج
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="product_image" class="form-label">رفع صورة جديدة (اختياري)</label>
                            <input type="file" class="form-control @error('product_image') is-invalid @enderror" id="product_image" name="product_image" accept="image/*">
                            <small class="form-text text-muted">أنواع الملفات المسموحة: JPEG, PNG, JPG, GIF. الحد الأقصى: 2MB</small>
                            @error('product_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        @if($product->product_image_path)
                            <div class="text-center">
                                <label class="form-label">الصورة الحالية:</label>
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $product->product_image_path) }}" 
                                         alt="صورة المنتج" 
                                         class="img-fluid rounded shadow" 
                                         style="max-height: 200px; width: auto;">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-1">
                                        <i class="fas fa-cube"></i>
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-3x mb-2"></i>
                                <p>لا توجد صورة للمنتج</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- إعدادات الصندوق -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">إعدادات الصندوق</h6></div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-eye me-1"></i>
                                صندوق مفعل
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star me-1"></i>
                                صندوق مميز
                            </label>
                        </div>
                        
                        <hr class="my-3">
                        
                        <!-- معلومات إضافية -->
                        <div class="small text-muted">
                            <p class="mb-1"><strong>تاريخ الإنشاء:</strong> {{ $product->created_at->format('Y-m-d H:i') }}</p>
                            <p class="mb-1"><strong>آخر تحديث:</strong> {{ $product->updated_at->format('Y-m-d H:i') }}</p>
                            @if($product->slug)
                                <p class="mb-0"><strong>الرابط:</strong> <code>{{ $product->slug }}</code></p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- أزرار الحفظ -->
                <div class="card shadow">
                    <div class="card-body d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>
                            حفظ التعديلات
                        </button>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>
                            عرض الصندوق
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.form-check-input:checked {
    background-color: #5a5c69;
    border-color: #5a5c69;
}

.badge {
    font-size: 0.65em;
}

.position-relative img {
    transition: transform 0.2s ease-in-out;
}

.position-relative:hover img {
    transform: scale(1.05);
}

.text-muted i {
    opacity: 0.6;
}
</style>
@endsection