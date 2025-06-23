@extends('admin.layouts.app')

@section('title', 'إدارة القصص')

@section('styles')
<style>
.story-card {
    transition: all 0.3s ease;
    border: 1px solid #e3e6f0;
}
.story-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.status-badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}
.featured-badge {
    background: linear-gradient(45deg, #f6ad55, #ed8936);
    color: white;
    border: none;
}
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}
.filter-section {
    background: #f8f9fc;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}
.story-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}
.bulk-actions {
    display: none;
    background: #4e73df;
    color: white;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}
.bulk-actions.show {
    display: block;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-book-open text-primary"></i>
            إدارة القصص
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.stories.analytics') }}" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar"></i> الإحصائيات
            </a>
            <a href="{{ route('admin.stories.export', request()->query()) }}" class="btn btn-success btn-sm">
                <i class="fas fa-download"></i> تصدير
            </a>
            <a href="{{ route('admin.stories.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> إضافة قصة جديدة
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي القصص
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                في الانتظار
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                مقبولة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                مرفوضة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.stories.index') }}" id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label for="type" class="form-label">نوع القصة</label>
                    <select name="type" id="type" class="form-control">
                        <option value="all" {{ ($storyType ?? 'all') == 'all' ? 'selected' : '' }}>جميع القصص</option>
                        <option value="featured" {{ ($storyType ?? '') == 'featured' ? 'selected' : '' }}>القصص المميزة</option>
                        <option value="user_submitted" {{ ($storyType ?? '') == 'user_submitted' ? 'selected' : '' }}>مرسلة من المستخدمين</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">الحالة</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">جميع الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مقبولة</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="search" class="form-label">البحث</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="اسم الطفل، الوالد، أو العنوان..." 
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label for="sort" class="form-label">الترتيب</label>
                    <select name="sort" id="sort" class="form-control">
                        <option value="newest" {{ ($sortBy ?? 'newest') == 'newest' ? 'selected' : '' }}>الأحدث أولاً</option>
                        <option value="oldest" {{ ($sortBy ?? '') == 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
                        <option value="name" {{ ($sortBy ?? '') == 'name' ? 'selected' : '' }}>حسب اسم الطفل</option>
                        <option value="pending_first" {{ ($sortBy ?? '') == 'pending_first' ? 'selected' : '' }}>المعلقة أولاً</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="date_from" class="form-label">من تاريخ</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" 
                           value="{{ request('date_from') }}">
                </div>

                <div class="col-md-4">
                    <label for="date_to" class="form-label">إلى تاريخ</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" 
                           value="{{ request('date_to') }}">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> بحث
                    </button>
                    <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> إعادة تعيين
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions" id="bulkActions">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong id="selectedCount">0</strong> قصة محددة
            </div>
            <div>
                <form method="POST" action="{{ route('admin.stories.bulk-action') }}" id="bulkForm" class="d-inline">
                    @csrf
                    <input type="hidden" name="story_ids" id="selectedIds">
                    
                    <button type="button" class="btn btn-sm btn-success" onclick="submitBulkAction('approve')">
                        <i class="fas fa-check"></i> اعتماد
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="submitBulkAction('reject')">
                        <i class="fas fa-times"></i> رفض
                    </button>
                    <button type="button" class="btn btn-sm btn-info" onclick="submitBulkAction('feature')">
                        <i class="fas fa-star"></i> تمييز
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="submitBulkAction('unfeature')">
                        <i class="fas fa-star-o"></i> إلغاء التمييز
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="submitBulkAction('delete')">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </form>
                <button type="button" class="btn btn-sm btn-light" onclick="clearSelection()">
                    إلغاء التحديد
                </button>
            </div>
        </div>
    </div>

    <!-- Stories Grid -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                القصص ({{ $stories->total() ?? 0 }} قصة)
            </h6>
            <div>
                <input type="checkbox" id="selectAll" class="form-check-input">
                <label for="selectAll" class="form-check-label ms-2">تحديد الكل</label>
            </div>
        </div>
        <div class="card-body">
            @if(isset($stories) && $stories->count() > 0)
                <div class="row">
                    @foreach($stories as $story)
                        @if(isset($story->id))
                        <div class="col-xl-4 col-lg-6 mb-4">
                            <div class="story-card card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="story-checkbox form-check-input me-2" 
                                               value="{{ $story->id }}">
                                        <h6 class="card-title mb-0">{{ Str::limit($story->title_ar ?? 'بدون عنوان', 30) }}</h6>
                                    </div>
                                    @if($story->is_featured ?? false)
                                        <span class="badge featured-badge">
                                            <i class="fas fa-star"></i> مميزة
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        @if($story->image_url ?? false)
                                            <div class="col-4">
                                                <img src="{{ $story->image_full_url ?? ($story->image_url ?? '') }}" 
                                                     alt="صورة القصة" 
                                                     class="story-image"
                                                     onerror="this.style.display='none'">
                                            </div>
                                            <div class="col-8">
                                        @else
                                            <div class="col-12">
                                        @endif
                                            <p class="text-muted small mb-1">
                                                <i class="fas fa-child"></i> {{ $story->child_name ?? 'غير محدد' }} ({{ $story->child_age ?? 0 }} سنوات)
                                            </p>
                                            <p class="text-muted small mb-1">
                                                <i class="fas fa-user"></i> {{ $story->parent_name ?? 'غير محدد' }}
                                            </p>
                                            <p class="text-muted small mb-1">
                                                <i class="fas fa-calendar"></i> {{ $story->created_at ? $story->created_at->format('Y/m/d') : 'غير محدد' }}
                                            </p>
                                            
                                            <div class="mb-2">
                                                <span class="badge badge-{{ $story->status_color ?? 'secondary' }} status-badge">
                                                    {{ $story->status_label ?? $story->status ?? 'غير محدد' }}
                                                </span>
                                            </div>

                                            @if($story->has_media ?? false)
                                                <div class="mb-2">
                                                    @if($story->image_url)
                                                        <i class="fas fa-image text-info" title="يحتوي على صورة"></i>
                                                    @endif
                                                    @if($story->video_url ?? false)
                                                        <i class="fas fa-video text-success ms-1" title="يحتوي على فيديو"></i>
                                                    @endif
                                                </div>
                                            @endif

                                            <p class="card-text small">
                                                {{ Str::limit(strip_tags($story->content_ar ?? ''), 80) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-between">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.stories.show', ['story' => $story->id]) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                        <a href="{{ route('admin.stories.edit', ['story' => $story->id]) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                    </div>

                                    @if(($story->status ?? '') === 'pending')
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    onclick="quickReview({{ $story->id }}, 'approve')">
                                                <i class="fas fa-check"></i> اعتماد
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" 
                                                    onclick="quickReview({{ $story->id }}, 'reject')">
                                                <i class="fas fa-times"></i> رفض
                                            </button>
                                        </div>
                                    @endif

                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="deleteStory({{ $story->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $stories->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-book-open fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">لا توجد قصص</h5>
                    <p class="text-gray-500">لم يتم العثور على أي قصص بالمعايير المحددة</p>
                    <a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة أول قصة
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Review Modal -->
<div class="modal fade" id="quickReviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">مراجعة سريعة</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="quickReviewForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="reviewStoryId">
                    <input type="hidden" id="reviewAction">
                    
                    <div class="form-group">
                        <label for="adminNotes">ملاحظات الإدارة (اختيارية)</label>
                        <textarea id="adminNotes" name="admin_notes" class="form-control" rows="3" 
                                  placeholder="أدخل ملاحظات للمؤلف..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من حذف هذه القصة؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-submit filters on change
    $('#type, #status, #sort').change(function() {
        $('#filterForm').submit();
    });

    // Bulk selection
    $('#selectAll').change(function() {
        $('.story-checkbox').prop('checked', this.checked);
        updateBulkActions();
    });

    $('.story-checkbox').change(function() {
        updateBulkActions();
        updateSelectAll();
    });

    function updateBulkActions() {
        const checkedBoxes = $('.story-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            $('#bulkActions').addClass('show');
            $('#selectedCount').text(count);
            
            const ids = [];
            checkedBoxes.each(function() {
                ids.push($(this).val());
            });
            $('#selectedIds').val(JSON.stringify(ids));
        } else {
            $('#bulkActions').removeClass('show');
        }
    }

    function updateSelectAll() {
        const totalBoxes = $('.story-checkbox').length;
        const checkedBoxes = $('.story-checkbox:checked').length;
        
        $('#selectAll').prop('checked', totalBoxes > 0 && totalBoxes === checkedBoxes);
    }
});

function clearSelection() {
    $('.story-checkbox, #selectAll').prop('checked', false);
    $('#bulkActions').removeClass('show');
}

function submitBulkAction(action) {
    if (!confirm('هل أنت متأكد من تنفيذ هذا الإجراء على القصص المحددة؟')) {
        return;
    }
    
    $('<input>').attr({
        type: 'hidden',
        name: 'action',
        value: action
    }).appendTo('#bulkForm');
    
    $('#bulkForm').submit();
}

function quickReview(storyId, action) {
    $('#reviewStoryId').val(storyId);
    $('#reviewAction').val(action);
    $('#quickReviewModal .modal-title').text(action === 'approve' ? 'اعتماد القصة' : 'رفض القصة');
    $('#quickReviewModal').modal('show');
}

$('#quickReviewForm').submit(function(e) {
    e.preventDefault();
    
    const storyId = $('#reviewStoryId').val();
    const action = $('#reviewAction').val();
    const notes = $('#adminNotes').val();
    
    if (!storyId) {
        alert('خطأ في البيانات');
        return;
    }
    
    $.ajax({
        url: `/admin/stories/${storyId}/quick-review`,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            action: action,
            admin_notes: notes
        },
        success: function(response) {
            $('#quickReviewModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            alert('حدث خطأ أثناء المراجعة');
            console.error(xhr);
        }
    });
});

function deleteStory(storyId) {
    if (!storyId) {
        alert('خطأ في البيانات');
        return;
    }
    
    $('#deleteForm').attr('action', `/admin/stories/${storyId}`);
    $('#deleteModal').modal('show');
}
</script>
@endsection