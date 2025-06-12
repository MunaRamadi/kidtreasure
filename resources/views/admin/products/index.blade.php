@extends('admin.layouts.app')

@section('title', 'إدارة الصناديق التعليمية')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">إدارة الصناديق التعليمية</h1>
            <p class="mb-0 text-muted">إدارة وتنظيم جميع الصناديق التعليمية في المتجر</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>
            إضافة صندوق جديد
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">إجمالي الصناديق</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">الصناديق النشطة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->where('is_active', true)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">المخزون الإجمالي</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->sum('stock_quantity') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">الصناديق المميزة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->where('is_featured', true)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>
                البحث والتصفية
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">البحث</label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="ابحث في اسم الصندوق أو الوصف...">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label for="box_type" class="form-label">نوع الصندوق</label>
                    <select class="form-select" id="box_type" name="box_type">
                        <option value="">جميع الأنواع</option>
                        <option value="innovation" {{ request('box_type') == 'innovation' ? 'selected' : '' }}>
                            🚀 صندوق الابتكار
                        </option>
                        <option value="creativity" {{ request('box_type') == 'creativity' ? 'selected' : '' }}>
                            🎨 صندوق الإبداع
                        </option>
                        <option value="treasure" {{ request('box_type') == 'treasure' ? 'selected' : '' }}>
                            💎 صندوق الكنز
                        </option>
                        <option value="discovery" {{ request('box_type') == 'discovery' ? 'selected' : '' }}>
                            🔍 صندوق الاستكشاف
                        </option>
                        <option value="science" {{ request('box_type') == 'science' ? 'selected' : '' }}>
                            🧪 صندوق العلوم
                        </option>
                        <option value="art" {{ request('box_type') == 'art' ? 'selected' : '' }}>
                            🎭 صندوق الفنون
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="age_group" class="form-label">الفئة العمرية</label>
                    <select class="form-select" id="age_group" name="age_group">
                        <option value="">جميع الأعمار</option>
                        <option value="3-5" {{ request('age_group') == '3-5' ? 'selected' : '' }}>3-5 سنوات</option>
                        <option value="6-8" {{ request('age_group') == '6-8' ? 'selected' : '' }}>6-8 سنوات</option>
                        <option value="9-12" {{ request('age_group') == '9-12' ? 'selected' : '' }}>9-12 سنة</option>
                        <option value="13-16" {{ request('age_group') == '13-16' ? 'selected' : '' }}>13-16 سنة</option>
                        <option value="17+" {{ request('age_group') == '17+' ? 'selected' : '' }}>17+ سنة</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="status" class="form-label">الحالة</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">جميع الحالات</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>
                قائمة الصناديق التعليمية
            </h6>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>اسم الصندوق</th>
                                <th>النوع</th>
                                <th>الفئة العمرية</th>
                                <th>السعر</th>
                                <th>المخزون</th>
                                <th>الحالة</th>
                                <th>مميز</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if($product->featured_image)
                                            <img src="{{ asset('storage/' . $product->featured_image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 4px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    </td>
                                    <td>
                                        @switch($product->box_type)
                                            @case('innovation')
                                                <span class="badge bg-primary">🚀 الابتكار</span>
                                                @break
                                            @case('creativity')
                                                <span class="badge bg-success">🎨 الإبداع</span>
                                                @break
                                            @case('treasure')
                                                <span class="badge bg-warning text-dark">💎 الكنز</span>
                                                @break
                                            @case('discovery')
                                                <span class="badge bg-info">🔍 الاستكشاف</span>
                                                @break
                                            @case('science')
                                                <span class="badge bg-secondary">🧪 العلوم</span>
                                                @break
                                            @case('art')
                                                <span class="badge bg-dark">🎭 الفنون</span>
                                                @break
                                            @default
                                                <span class="badge bg-light text-dark">غير محدد</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $product->age_group }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($product->price, 2) }} د.أ</span>
                                        @if($product->discount_price)
                                            <br>
                                            <small class="text-decoration-line-through text-muted">
                                                {{ number_format($product->discount_price, 2) }} د.أ
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->stock_quantity > 10)
                                            <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                        @elseif($product->stock_quantity > 0)
                                            <span class="badge bg-warning text-dark">{{ $product->stock_quantity }}</span>
                                        @else
                                            <span class="badge bg-danger">نفد المخزون</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                نشط
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>
                                                غير نشط
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_featured)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star me-1"></i>
                                                مميز
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                <i class="far fa-star"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $product->created_at->format('Y-m-d') }}
                                            <br>
                                            {{ $product->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product->id) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الصندوق؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            عرض {{ $products->firstItem() }} إلى {{ $products->lastItem() }} 
                            من أصل {{ $products->total() }} صندوق
                        </small>
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">لا توجد صناديق تعليمية</h5>
                    <p class="text-muted mb-4">لم يتم العثور على أي صناديق تعليمية بالمعايير المحددة</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>
                        إضافة صندوق جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit form on filter change
    document.querySelectorAll('#box_type, #age_group, #status').forEach(function(element) {
        element.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Clear search functionality
    document.getElementById('search').addEventListener('input', function() {
        if (this.value === '') {
            // Optional: Auto-submit when search is cleared
        }
    });

    // Bulk actions functionality (optional)
    function toggleAll() {
        const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
        const selectAll = document.getElementById('select-all');
        
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selectAll.checked;
        });
    }

    // Confirm delete action
    function confirmDelete(productName) {
        return confirm(`هل أنت متأكد من حذف الصندوق "${productName}"؟\nهذا الإجراء لا يمكن التراجع عنه.`);
    }

    // Toggle product status via AJAX (optional enhancement)
    function toggleStatus(productId, currentStatus) {
        fetch(`/admin/products/${productId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: !currentStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث حالة الصندوق');
        });
    }
</script>
@endpush

@push('styles')
<style>
    .table th {
        background-color: #f8f9fc;
        border-color: #e3e6f0;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .btn-group .btn {
        margin: 0 1px;
    }
    
    .img-thumbnail {
        border: 1px solid #e3e6f0;
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
</style>
@endpush
@endsection