@extends('admin.layouts.app')

@section('title', 'إدارة قصص الأطفال')

@section('content')
<div class="container-fluid" dir="rtl">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">إدارة قصص الأطفال</h1>
            <p class="mb-0 text-muted">إدارة وتنظيم جميع قصص الأطفال في الموقع</p>
        </div>
        @auth
            <a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>
                إضافة قصة جديدة
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>
                تسجيل الدخول
            </a>
        @endauth
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">إجمالي القصص</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">في الانتظار</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">القصص المميزة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['featured'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">القصص المنشورة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['published'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
            <form method="GET" action="{{ route('admin.stories.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">البحث</label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="ابحث في العنوان أو المحتوى...">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="featured" class="form-label">النوع</label>
                    <select class="form-select" id="featured" name="featured">
                        <option value="">الكل</option>
                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>مميزة</option>
                        <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>عادية</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="difficulty_level" class="form-label">مستوى الصعوبة</label>
                    <select class="form-select" id="difficulty_level" name="difficulty_level">
                        <option value="">جميع المستويات</option>
                        <option value="Easy" {{ request('difficulty_level') == 'Easy' ? 'selected' : '' }}>سهل</option>
                        <option value="Medium" {{ request('difficulty_level') == 'Medium' ? 'selected' : '' }}>متوسط</option>
                        <option value="Hard" {{ request('difficulty_level') == 'Hard' ? 'selected' : '' }}>صعب</option>
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

                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stories Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>
                قائمة قصص الأطفال
            </h6>
        </div>
        <div class="card-body">
            @if($stories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>عنوان القصة</th>
                                <th>اسم الطفل</th>
                                <th>الكاتب</th>
                                <th>مستوى الصعوبة</th>
                                <th>المدة</th>
                                <th>مميزة</th>
                                <th>تاريخ الإرسال</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stories as $story)
                                <tr class="{{ isset($highlightId) && $story->story_id == $highlightId ? 'table-danger' : '' }}">
                                    <td>{{ $story->id }}</td>
                                    <td>
                                        @if($story->image_full_url)
                                            <img src="{{ $story->image_full_url }}" 
                                                 alt="{{ $story->title_ar ?: 'قصة ' . $story->child_name }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 4px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $story->title_ar ?: 'قصة ' . $story->child_name }}</div>
                                        <small class="text-muted">{{ Str::limit(strip_tags($story->content_ar), 50) }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $story->child_name }}</div>
                                        @if($story->child_age)
                                            <small class="text-muted">{{ $story->child_age }} سنوات</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($story->user)
                                            <span class="text-dark">{{ $story->user->name }}</span>
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($story->difficulty_level)
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
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($story->duration)
                                            <span class="badge bg-info">{{ $story->duration }}</span>
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($story->is_featured)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star me-1"></i>
                                                مميزة
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                <i class="far fa-star"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $story->submission_date ? $story->submission_date->format('Y-m-d') : $story->created_at->format('Y-m-d') }}
                                            <br>
                                            {{ $story->submission_date ? $story->submission_date->format('H:i') : $story->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.stories.show', $story) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.stories.edit', $story) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.stories.destroy', $story) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirmDelete('{{ $story->title_ar ?: 'قصة ' . $story->child_name }}')">
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
                            عرض {{ $stories->firstItem() }} إلى {{ $stories->lastItem() }} 
                            من أصل {{ $stories->total() }} قصة
                        </small>
                    </div>
                    <div>
                        {{ $stories->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">لا توجد قصص</h5>
                    <p class="text-muted mb-4">لم يتم العثور على أي قصص بالمعايير المحددة</p>
                    <a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>
                        إضافة قصة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit form on filter change
    document.querySelectorAll('#featured, #difficulty_level').forEach(function(element) {
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
        const checkboxes = document.querySelectorAll('input[name="selected_stories[]"]');
        const selectAll = document.getElementById('select-all');
        
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selectAll.checked;
        });
    }

    // Confirm delete action
    function confirmDelete(storyTitle) {
        return confirm(`هل أنت متأكد من حذف القصة "${storyTitle}"؟\nهذا الإجراء لا يمكن التراجع عنه.`);
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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection