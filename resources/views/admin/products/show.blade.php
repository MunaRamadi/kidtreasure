@extends('admin.layouts.app')

@section('title', 'عرض الصندوق - ' . $product->name)

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">تفاصيل الصندوق التعليمي</h1>
            <p class="mb-0 text-muted">عرض تفاصيل الصندوق الكاملة</p>
        </div>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                العودة إلى قائمة الصناديق
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>
                تعديل الصندوق
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- صورة الصندوق -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-box me-2"></i>
                        صورة الصندوق
                    </h6>
                    @if($product->has_featured_image)
                        <small class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            متوفرة
                        </small>
                    @else
                        <small class="text-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            غير متوفرة
                        </small>
                    @endif
                </div>
                <div class="card-body text-center p-2">
                    @if($product->has_featured_image)
                        <div class="image-container position-relative">
                            <img src="{{ $product->featured_image_url }}" 
                                 alt="صورة الصندوق - {{ $product->name }}" 
                                 class="img-fluid rounded shadow image-preview"
                                 style="max-height: 250px; width: 100%; object-fit: cover; cursor: pointer;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#boxImageModal">
                            <div class="image-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">اضغط للتكبير</small>
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded border" 
                             style="height: 250px;">
                            <div class="text-center">
                                <div class="mb-3 box-emoji" style="font-size: 3rem; opacity: 0.5;">
                                    @switch($product->box_type)
                                        @case('innovation')
                                            🚀
                                            @break
                                        @case('creativity')
                                            🎨
                                            @break
                                        @case('treasure')
                                            💎
                                            @break
                                        @case('discovery')
                                            🔍
                                            @break
                                        @case('science')
                                            🔬
                                            @break
                                        @case('art')
                                            🎭
                                            @break
                                        @default
                                            📦
                                    @endswitch
                                </div>
                                <p class="text-muted mb-0">لا توجد صورة للصندوق</p>
                                <small class="text-muted">{{ $product->box_type_arabic }}</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- صورة المنتج -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-cube me-2"></i>
                        صورة المنتج
                    </h6>
                    @if($product->has_product_image)
                        <small class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            متوفرة
                        </small>
                    @else
                        <small class="text-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            غير متوفرة
                        </small>
                    @endif
                </div>
                <div class="card-body text-center p-2">
                    @if($product->has_product_image)
                        <div class="image-container position-relative">
                            <img src="{{ $product->product_image_url }}" 
                                 alt="صورة المنتج - {{ $product->name }}" 
                                 class="img-fluid rounded shadow image-preview"
                                 style="max-height: 250px; width: 100%; object-fit: cover; cursor: pointer;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#productImageModal">
                            <div class="image-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">اضغط للتكبير</small>
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded border" 
                             style="height: 250px;">
                            <div class="text-center">
                                <i class="fas fa-box-open text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                                <p class="text-muted mb-0">لا توجد صورة للمنتج</p>
                                <small class="text-muted">محتويات الصندوق</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- الصورة القديمة (إذا كانت موجودة) -->
            @if($product->has_legacy_image)
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-secondary">
                        <i class="fas fa-image me-2"></i>
                        الصورة القديمة
                    </h6>
                    <small class="text-info">
                        <i class="fas fa-info-circle me-1"></i>
                        متوفرة
                    </small>
                </div>
                <div class="card-body text-center p-2">
                    <div class="image-container position-relative">
                        <img src="{{ asset('storage/' . $product->image_path) }}" 
                             alt="الصورة القديمة - {{ $product->name }}" 
                             class="img-fluid rounded shadow image-preview"
                             style="max-height: 250px; width: 100%; object-fit: cover; cursor: pointer;"
                             data-bs-toggle="modal" 
                             data-bs-target="#legacyImageModal">
                        <div class="image-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-2">اضغط للتكبير</small>
                </div>
            </div>
            @endif

            <!-- حالة الصندوق -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>
                        حالة الصندوق
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="text-center">
                                <span class="badge badge-{{ $product->is_active ? 'success' : 'danger' }} p-2">
                                    <i class="fas fa-{{ $product->is_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                                    {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <span class="badge badge-{{ $product->is_featured ? 'warning' : 'secondary' }} p-2">
                                    <i class="fas fa-star me-1"></i>
                                    {{ $product->is_featured ? 'مميز' : 'عادي' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <span class="badge badge-{{ $product->stock_status_color }} p-2">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $product->stock_status }}
                                </span>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        الكمية المتوفرة: {{ $product->stock_quantity }} وحدة
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- معلومات الصور -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">
                        <i class="fas fa-images me-2"></i>
                        إحصائيات الصور
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="text-primary">{{ $product->total_images_count }}</h6>
                            <small class="text-muted">إجمالي الصور</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-success">{{ count($product->available_image_types) }}</h6>
                            <small class="text-muted">أنواع متوفرة</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-info">{{ count($product->gallery_images ?? []) }}</h6>
                            <small class="text-muted">صور إضافية</small>
                        </div>
                    </div>
                    
                    @if(!empty($product->available_image_types))
                    <hr>
                    <div class="text-center">
                        <small class="text-muted d-block mb-2">الأنواع المتوفرة:</small>
                        @foreach($product->available_image_types as $type)
                            <span class="badge badge-outline-secondary me-1">
                                @switch($type)
                                    @case('product')
                                        <i class="fas fa-cube me-1"></i>
                                        المنتج
                                        @break
                                    @case('box')
                                        <i class="fas fa-box me-1"></i>
                                        الصندوق
                                        @break
                                    @case('legacy')
                                        <i class="fas fa-image me-1"></i>
                                        قديمة
                                        @break
                                @endswitch
                            </span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- المعلومات الأساسية -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        المعلومات الأساسية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">اسم الصندوق</label>
                            <p class="h5">{{ $product->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">نوع الصندوق</label>
                            <p class="mb-0">
                                <span class="badge badge-primary p-2">
                                    {{ $product->box_type_arabic }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">السعر</label>
                            <p class="h4 text-success mb-0">{{ $product->formatted_price_arabic }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">الفئة العمرية</label>
                            <p class="mb-0">
                                <span class="badge badge-info p-2">
                                    <i class="fas fa-child me-1"></i>
                                    {{ $product->age_group }}
                                </span>
                            </p>
                        </div>
                        @if($product->category)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">التصنيف</label>
                            <p class="mb-0">
                                <span class="badge badge-secondary p-2">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $product->category }}
                                </span>
                            </p>
                        </div>
                        @endif
                        @if($product->difficulty_level)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">مستوى الصعوبة</label>
                            <p class="mb-0">
                                <span class="badge badge-warning p-2">
                                    <i class="fas fa-signal me-1"></i>
                                    {{ $product->difficulty_level }}
                                </span>
                            </p>
                        </div>
                        @endif
                        @if($product->estimated_time)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">الوقت المقدر</label>
                            <p class="mb-0">
                                <span class="badge badge-success p-2">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $product->estimated_time }}
                                </span>
                            </p>
                        </div>
                        @endif
                        @if($product->slug)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">الرابط المخصص</label>
                            <p class="mb-0">
                                <code>{{ $product->slug }}</code>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- الوصف -->
            @if($product->description)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-align-left me-2"></i>
                        الوصف المختصر
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-justify">{{ $product->description }}</p>
                </div>
            </div>
            @endif

            <!-- الوصف التفصيلي -->
            @if($product->detailed_description)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt me-2"></i>
                        الوصف التفصيلي
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-justify">{!! nl2br(e($product->detailed_description)) !!}</div>
                </div>
            </div>
            @endif

            <!-- محتويات الصندوق -->
            @if($product->contents && is_array($product->contents) && count($product->contents) > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-list-ul me-2"></i>
                        محتويات الصندوق
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($product->contents as $index => $content)
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-success me-2">{{ $index + 1 }}</span>
                                    <span>{{ $content }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- الأهداف التعليمية -->
            @if($product->educational_goals)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-bullseye me-2"></i>
                        الأهداف التعليمية
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-justify">{{ $product->educational_goals }}</p>
                </div>
            </div>
            @endif

            <!-- الفوائد التعليمية -->
            @if($product->educational_benefits && is_array($product->educational_benefits) && count($product->educational_benefits) > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-graduation-cap me-2"></i>
                        الفوائد التعليمية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($product->educational_benefits as $index => $benefit)
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ $benefit }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- معرض الصور الإضافي -->
            @if(count($product->gallery_images ?? []) > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">
                        <i class="fas fa-images me-2"></i>
                        صور إضافية ({{ count($product->gallery_images) }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($product->gallery_images as $index => $image)
                            @if(Storage::disk('public')->exists($image))
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="image-container position-relative">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="صورة إضافية {{ $index + 1 }}" 
                                         class="img-fluid rounded shadow image-preview"
                                         style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#galleryModal{{ $index }}">
                                    <div class="image-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- معلومات إضافية -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">
                        <i class="fas fa-cog me-2"></i>
                        معلومات النظام
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">تاريخ الإنشاء</label>
                            <p class="mb-0">{{ $product->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">آخر تحديث</label>
                            <p class="mb-0">{{ $product->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                        @if($product->min_price && $product->max_price)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">نطاق السعر</label>
                            <p class="mb-0">
                                {{ number_format($product->min_price, 2) }} - {{ number_format($product->max_price, 2) }} دينار
                            </p>
                        </div>
                        @endif
                        @if($product->video_url)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">رابط الفيديو</label>
                            <p class="mb-0">
                                <a href="{{ $product->video_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-play me-1"></i>
                                    مشاهدة الفيديو
                                </a>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Box Image -->
@if($product->has_featured_image)
<div class="modal fade" id="boxImageModal" tabindex="-1" aria-labelledby="boxImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="boxImageModalLabel">صورة الصندوق - {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $product->featured_image_url }}" alt="صورة الصندوق" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal for Product Image -->
@if($product->has_product_image)
<div class="modal fade" id="productImageModal" tabindex="-1" aria-labelledby="productImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productImageModalLabel">صورة المنتج - {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $product->product_image_url }}" alt="صورة المنتج" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal for Legacy Image -->
@if($product->has_legacy_image)
<div class="modal fade" id="legacyImageModal" tabindex="-1" aria-labelledby="legacyImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="legacyImageModalLabel">الصورة القديمة - {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="الصورة القديمة" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modals for Gallery Images -->
@if(count($product->gallery_images ?? []) > 0)
    @foreach($product->gallery_images as $index => $image)
        @if(Storage::disk('public')->exists($image))
        <div class="modal fade" id="galleryModal{{ $index }}" tabindex="-1" aria-labelledby="galleryModalLabel{{ $index }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="galleryModalLabel{{ $index }}">صورة إضافية {{ $index + 1 }} - {{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $image) }}" alt="صورة إضافية {{ $index + 1 }}" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endif

@endsection

@push('styles')
<style>
.image-container {
    overflow: hidden;
    border-radius: 0.375rem;
}

.image-container .image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
    font-size: 1.5rem;
}

.image-container:hover .image-overlay {
    opacity: 1;
}

.image-preview {
    transition: transform 0.3s ease;
}

.image-container:hover .image-preview {
    transform: scale(1.05);
}

.badge-outline-secondary {
    background: transparent;
    border: 1px solid #6c757d;
    color: #6c757d;
}

.box-emoji {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.text-justify {
    text-align: justify;
}

.card {
    transition: box-shadow 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endpush