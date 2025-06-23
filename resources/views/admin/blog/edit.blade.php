@extends('admin.layouts.app')

@section('title', 'تعديل المقال')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل المقال</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.blog.show', $post) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> عرض المقال
            </a>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.blog.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Title -->
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">العنوان <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $post->title) }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="col-md-12 mb-3">
                        <label for="excerpt" class="form-label">المقدمة</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" 
                                  name="excerpt" 
                                  rows="3" 
                                  maxlength="500"
                                  placeholder="مقدمة مختصرة عن المقال (اختياري)">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <div class="form-text">الحد الأقصى 500 حرف</div>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="col-md-12 mb-3">
                        <label for="content" class="form-label">المحتوى <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="15" 
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Featured Image -->
                    @if($post->featured_image)
                        <div class="col-md-12 mb-3">
                            <label class="form-label">الصورة المميزة الحالية</label>
                            <div class="mb-2">
                                <img src="{{ Storage::url($post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    @endif

                    <!-- New Featured Image -->
                    <div class="col-md-6 mb-3">
                        <label for="featured_image" class="form-label">
                            {{ $post->featured_image ? 'تغيير الصورة المميزة' : 'الصورة المميزة' }}
                        </label>
                        <input type="file" 
                               class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" 
                               name="featured_image" 
                               accept="image/*">
                        <div class="form-text">
                            {{ $post->featured_image ? 'اختر صورة جديدة لاستبدال الصورة الحالية' : 'الحد الأقصى 2 ميجابايت' }}
                        </div>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Publication Date -->
                    <div class="col-md-6 mb-3">
                        <label for="publication_date" class="form-label">تاريخ النشر</label>
                        <input type="datetime-local" 
                               class="form-control @error('publication_date') is-invalid @enderror" 
                               id="publication_date" 
                               name="publication_date" 
                               value="{{ old('publication_date', $post->publication_date ? $post->publication_date->format('Y-m-d\TH:i') : '') }}">
                        @error('publication_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Publication Status -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1" 
                                   {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">
                                نشر المقال
                            </label>
                        </div>
                        <div class="form-text">إذا لم يتم التحديد، سيتم حفظ المقال كمسودة</div>
                    </div>

                    <!-- Post Meta Information -->
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-info">
                            <h6>معلومات المقال:</h6>
                            <ul class="mb-0">
                                <li><strong>الكاتب:</strong> {{ $post->author->name ?? 'غير محدد' }}</li>
                                <li><strong>تاريخ الإنشاء:</strong> {{ $post->created_at->format('Y-m-d H:i') }}</li>
                                <li><strong>آخر تحديث:</strong> {{ $post->updated_at->format('Y-m-d H:i') }}</li>
                                <li><strong>الرابط:</strong> {{ $post->slug }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.blog.show', $post) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> عرض المقال
                    </a>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-resize textarea
    document.getElementById('content').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });

    // Image preview
    document.getElementById('featured_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                const existingPreview = document.getElementById('new-image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                // Create new preview
                const preview = document.createElement('div');
                preview.id = 'new-image-preview';
                preview.className = 'mt-2';
                preview.innerHTML = `
                    <p class="text-muted small">معاينة الصورة الجديدة:</p>
                    <img src="${e.target.result}" alt="معاينة الصورة الجديدة" 
                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                `;
                
                // Insert after the file input
                document.getElementById('featured_image').parentNode.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection