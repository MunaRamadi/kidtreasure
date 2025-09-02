@extends('admin.layouts.app')

@section('title', 'عرض القصة')

@section('content')
<div class="container-fluid" dir="rtl">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $story->title_ar ?? 'عنوان القصة' }}</h1>
            @if($story->title_en)
                <p class="mb-0 text-muted">{{ $story->title_en }}</p>
            @endif
            <div class="d-flex align-items-center mt-2">
                <small class="text-muted me-3">{{ $story->created_at->format('d/m/Y') }}</small>
                <small class="text-muted me-3">{{ $story->category ?? 'غير محدد' }}</small>
                @if($story->child_age)
                    <small class="text-muted">العمر: {{ $story->child_age }} سنة</small>
                @endif
            </div>
        </div>
        
        <!-- Back Button -->
        <a href="{{ route('admin.stories.index') }}" 
           class="btn btn-secondary">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للقائمة
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Story Media Card -->
            @if($story->image || $story->video)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-images me-2"></i>
                            الوسائط
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @if($story->video)
                            <video controls class="w-100" style="height: 300px; object-fit: cover;">
                                <source src="{{ Storage::url($story->video) }}" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        @elseif($story->image)
                            <div class="position-relative">
                                <img src="{{ Storage::url($story->image) }}" 
                                     alt="{{ $story->title_ar ?? 'صورة القصة' }}" 
                                     class="w-100 cursor-pointer hover-opacity" 
                                     style="height: 300px; object-fit: cover;"
                                     onclick="openImageModal('{{ Storage::url($story->image) }}')">
                                <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-search-plus text-white fa-2x opacity-0"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Story Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-book me-2"></i>
                        محتوى القصة
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-gray-800 mb-2">النص العربي:</h6>
                        <div class="text-gray-700" style="line-height: 1.8; white-space: pre-line;">{{ $story->content_ar ?? 'لا يوجد محتوى عربي' }}</div>
                    </div>
                    
                    @if($story->content_en)
                        <div>
                            <h6 class="font-weight-bold text-gray-800 mb-2">النص الإنجليزي:</h6>
                            <div class="text-gray-700" style="line-height: 1.8; white-space: pre-line;">{{ $story->content_en }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Details Card -->
            @if($story->duration || $story->difficulty_level || $story->materials_used || $story->lesson_learned)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-lightbulb me-2"></i>
                            تفاصيل النشاط
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            @if($story->duration)
                                <div class="col-md-4 mb-3">
                                    <strong class="text-gray-700">المدة:</strong>
                                    <span class="d-block text-gray-600">{{ $story->duration }}</span>
                                </div>
                            @endif
                            @if($story->difficulty_level)
                                <div class="col-md-4 mb-3">
                                    <strong class="text-gray-700">مستوى الصعوبة:</strong>
                                    <div class="mt-1">
                                        @switch($story->difficulty_level)
                                            @case('Easy')
                                                <span class="badge bg-success">سهل</span>
                                                @break
                                            @case('Medium')
                                                <span class="badge bg-warning text-dark">متوسط</span>
                                                @break
                                            @case('Hard')
                                                <span class="badge bg-danger">صعب</span>
                                                @break
                                            @default
                                                <span class="badge bg-light text-dark">{{ $story->difficulty_level }}</span>
                                        @endswitch
                                    </div>
                                </div>
                            @endif
                            @if($story->materials_used)
                                <div class="col-md-4 mb-3">
                                    <strong class="text-gray-700">المواد المستخدمة:</strong>
                                    <span class="d-block text-gray-600">{{ $story->materials_used }}</span>
                                </div>
                            @endif
                        </div>
                        
                        @if($story->lesson_learned)
                            <div>
                                <strong class="text-gray-700">الدرس المستفاد:</strong>
                                <div class="text-gray-600 mt-1" style="white-space: pre-line;">{{ $story->lesson_learned }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Additional Notes Card -->
            @if($story->additional_notes)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-sticky-note me-2"></i>
                            ملاحظات إضافية
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-gray-700" style="white-space: pre-line;">{{ $story->additional_notes }}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Child Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-child me-2"></i>
                        معلومات الطفل
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-gray-700">الاسم:</strong>
                        <span class="d-block text-gray-600">{{ $story->child_name ?? 'غير محدد' }}</span>
                    </div>
                    @if($story->child_age)
                        <div>
                            <strong class="text-gray-700">العمر:</strong>
                            <span class="d-block text-gray-600">{{ $story->child_age }} سنة</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Parent Information Card -->
            @if($story->parent_name || $story->parent_contact)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user me-2"></i>
                            معلومات التواصل
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($story->parent_name)
                            <div class="mb-3">
                                <strong class="text-gray-700">الاسم:</strong>
                                <span class="d-block text-gray-600">{{ $story->parent_name }}</span>
                            </div>
                        @endif
                        @if($story->parent_contact)
                            <div>
                                <strong class="text-gray-700">التواصل:</strong>
                                <span class="d-block text-gray-600">{{ $story->parent_contact }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Category and Tags Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tags me-2"></i>
                        التصنيف والعلامات
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-gray-700">الفئة:</strong>
                        <span class="d-block text-gray-600">{{ $story->category ?? 'غير محدد' }}</span>
                    </div>
                    @if($story->tags)
                        <div>
                            <strong class="text-gray-700">الكلمات الدلالية:</strong>
                            <div class="mt-2">
                                @php
                                    $tags = explode(',', $story->tags);
                                @endphp
                                @foreach($tags as $tag)
                                    <span class="badge bg-light text-dark me-1 mb-1">
                                        {{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات الحالة
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-gray-700">حالة القصة:</strong>
                        <div class="mt-1">
                            @switch($story->status)
                                @case('approved')
                                    <span class="badge bg-success">مقبولة</span>
                                    @break
                                @case('pending')
                                    <span class="badge bg-warning text-dark">قيد المراجعة</span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">مرفوضة</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $story->status }}</span>
                            @endswitch
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong class="text-gray-700">تاريخ الإنشاء:</strong>
                        <span class="d-block text-gray-600">{{ $story->created_at->format('d/m/Y - H:i') }}</span>
                    </div>
                    @if($story->updated_at != $story->created_at)
                        <div>
                            <strong class="text-gray-700">آخر تحديث:</strong>
                            <span class="d-block text-gray-600">{{ $story->updated_at->format('d/m/Y - H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs me-2"></i>
                        الإجراءات
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.stories.edit', $story) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل القصة
                        </a>
                        
                        <button onclick="shareStory()" 
                                class="btn btn-success">
                            <i class="fas fa-share-alt me-2"></i>
                            مشاركة القصة
                        </button>
                        
                        <button onclick="printStory()" 
                                class="btn btn-info">
                            <i class="fas fa-print me-2"></i>
                            طباعة القصة
                        </button>
                        
                        <form action="{{ route('admin.stories.destroy', $story) }}" 
                              method="POST" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذه القصة؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                حذف القصة
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="صورة مكبرة" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}

function shareStory() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $story->title_ar ?? "قصة طفل" }}',
            text: 'شاهد هذه القصة الجميلة مع الطفل {{ $story->child_name ?? "الطفل" }}',
            url: window.location.href
        });
    } else {
        // نسخ الرابط للحافظة
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('تم نسخ رابط القصة إلى الحافظة!');
        });
    }
}

function printStory() {
    window.print();
}
</script>

@push('styles')
<style>
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .hover-opacity:hover {
        opacity: 0.8;
    }
    
    .image-overlay {
        background: rgba(0,0,0,0);
        transition: all 0.3s ease;
        border-radius: 0.375rem;
    }
    
    .image-overlay:hover {
        background: rgba(0,0,0,0.5);
    }
    
    .image-overlay:hover i {
        opacity: 1 !important;
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .text-gray-700 {
        color: #374151 !important;
    }
    
    .text-gray-600 {
        color: #6b7280 !important;
    }
    
    .text-gray-800 {
        color: #1f2937 !important;
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
    
    .btn-warning {
        background-color: #f6c23e;
        border-color: #f6c23e;
        color: #000;
    }
    
    .btn-warning:hover {
        background-color: #f4b619;
        border-color: #f4b619;
        color: #000;
    }
    
    .btn-success {
        background-color: #1cc88a;
        border-color: #1cc88a;
    }
    
    .btn-success:hover {
        background-color: #17a673;
        border-color: #169b6b;
    }
    
    .btn-info {
        background-color: #36b9cc;
        border-color: #36b9cc;
    }
    
    .btn-info:hover {
        background-color: #2c9faf;
        border-color: #2a96a5;
    }
    
    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }
    
    .btn-danger:hover {
        background-color: #e02d1b;
        border-color: #d52b1e;
    }
    
    .shadow {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
    
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
    
    .d-grid {
        display: grid;
    }
    
    .gap-2 {
        gap: 0.5rem;
    }
    
    /* Print styles */
    @media print {
        .btn, .card-header, .modal, script {
            display: none !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .col-lg-4 {
            display: none !important;
        }
        
        .col-lg-8 {
            width: 100% !important;
        }
    }
</style>
@endpush

@endsection