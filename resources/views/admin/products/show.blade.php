@extends('admin.layouts.app')

@section('title', 'عرض الصندوق - ' . $product->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
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
        <!-- Box Image and Status -->
        <div class="col-lg-4">
            <!-- Box Image Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-image me-2"></i>
                        صورة الصندوق
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 300px; width: 100%; object-fit: cover;">
                    @else
                        <!-- عرض الرمز التعبيري حسب نوع الصندوق -->
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                             style="height: 300px;">
                            <div class="text-center">
                                <div style="font-size: 4rem; margin-bottom: 1rem;">
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
                                        @default
                                            📦
                                    @endswitch
                                </div>
                                <p class="text-muted">{{ $product->name }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Box Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        حالة الصندوق
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">الحالة</small>
                            <div class="mt-1">
                                @if($product->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>
                                        نشط
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>
                                        غير نشط
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">المخزون</small>
                            <div class="mt-1">
                                @if($product->stock_quantity > 0)
                                    <span class="badge bg-success">
                                        <i class="fas fa-box me-1"></i>
                                        متوفر ({{ $product->stock_quantity }})
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        نفد المخزون
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($product->is_featured)
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted">تصنيف خاص</small>
                            <div class="mt-1">
                                <span class="badge bg-warning">
                                    <i class="fas fa-star me-1"></i>
                                    صندوق مميز
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Box Type Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tag me-2"></i>
                        نوع الصندوق
                    </h6>
                </div>
                <div class="card-body text-center">
                    @php
                        $boxTypes = [
                            'innovation' => ['name' => 'صندوق الابتكار', 'emoji' => '🚀', 'color' => 'primary'],
                            'creativity' => ['name' => 'صندوق الإبداع', 'emoji' => '🎨', 'color' => 'info'],
                            'treasure' => ['name' => 'صندوق الكنز', 'emoji' => '💎', 'color' => 'warning']
                        ];
                        $currentType = $boxTypes[$product->box_type] ?? ['name' => 'غير محدد', 'emoji' => '📦', 'color' => 'secondary'];
                    @endphp
                    
                    <div class="mb-3">
                        <div style="font-size: 3rem;">{{ $currentType['emoji'] }}</div>
                    </div>
                    <h5 class="text-{{ $currentType['color'] }}">{{ $currentType['name'] }}</h5>
                    <p class="text-muted">{{ $product->difficulty_level ?? 'غير محدد' }}</p>
                </div>
            </div>
        </div>

        <!-- Box Details -->
        <div class="col-lg-8">
            <!-- Basic Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info me-2"></i>
                        المعلومات الأساسية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">اسم الصندوق</label>
                            <p class="mb-0 fw-bold">{{ $product->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">الفئة العمرية</label>
                            <p class="mb-0">
                                <span class="badge bg-info">
                                    <i class="fas fa-child me-1"></i>
                                    {{ $product->age_group ?? 'غير محدد' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">السعر</label>
                            <p class="mb-0 fw-bold text-success">
                                <i class="fas fa-money-bill me-1"></i>
                                {{ number_format($product->price_jod, 2) }} دينار أردني
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">كمية المخزون</label>
                            <p class="mb-0">
                                <i class="fas fa-boxes me-1"></i>
                                {{ $product->stock_quantity }} صندوق
                            </p>
                        </div>
                    </div>

                    @if($product->description)
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label text-muted">وصف الصندوق</label>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">{!! nl2br(e($product->description)) !!}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Box Contents Card -->
            @if($product->contents)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>
                        محتويات الصندوق
                    </h6>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded">
                        @php
                            $contents = explode("\n", $product->contents);
                        @endphp
                        <ul class="mb-0">
                            @foreach($contents as $item)
                                @if(trim($item))
                                    <li class="mb-1">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        {{ trim($item) }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Educational Goals Card -->
            @if($product->educational_goals)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-graduation-cap me-2"></i>
                        الأهداف التعليمية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{!! nl2br(e($product->educational_goals)) !!}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar me-2"></i>
                        معلومات إضافية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label text-muted">تاريخ الإضافة</label>
                            <p class="mb-0">
                                <i class="fas fa-plus-circle me-1"></i>
                                {{ $product->created_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">آخر تحديث</label>
                            <p class="mb-0">
                                <i class="fas fa-edit me-1"></i>
                                {{ $product->updated_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs me-2"></i>
                        الإجراءات
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل الصندوق
                        </a>
                        
                        <a href="{{ route('admin.products.duplicate', $product) }}" 
                           class="btn btn-info">
                            <i class="fas fa-copy me-2"></i>
                            نسخ الصندوق
                        </a>

                        <form method="POST" 
                              action="{{ route('admin.products.destroy', $product) }}" 
                              class="d-inline"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الصندوق؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>
                                حذف الصندوق
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        border-radius: 10px 10px 0 0 !important;
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
    
    .btn-group .btn {
        border-radius: 6px;
    }
    
    .btn-group .btn:not(:last-child) {
        margin-right: 0.5rem;
    }
    
    .img-fluid {
        transition: transform 0.3s ease;
    }
    
    .img-fluid:hover {
        transform: scale(1.05);
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }

    /* تحسين مظهر قوائم المحتويات */
    ul {
        list-style: none;
        padding-left: 0;
    }
    
    ul li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    ul li:last-child {
        border-bottom: none;
    }
    
    /* تحسين مظهر الرموز التعبيرية */
    .box-emoji {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endpush