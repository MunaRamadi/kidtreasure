@extends('admin.layouts.app')

@section('title', 'إدارة المقالات')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة المقالات</h1>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة مقال جديد
        </a>
    </div>

    <!-- Search and Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.blog.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">البحث</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="البحث في العنوان أو المحتوى">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">الحالة</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">جميع المقالات</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>منشور</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary me-2">
                        <i class="fas fa-search"></i> بحث
                    </button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Blog Posts Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">قائمة المقالات</h6>
        </div>
        <div class="card-body">
            @if($posts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>الكاتب</th>
                                <th>تاريخ النشر</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>
                                        @if($post->image_url)
                                            <img src="{{ Storage::url($post->image_url) }}" 
                                                 alt="{{ $post->title_ar ?? $post->title_en }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($post->title_ar ?? $post->title_en, 50) }}</div>
                                        @if($post->excerpt_ar ?? $post->excerpt_en)
                                            <small class="text-muted">{{ Str::limit($post->excerpt_ar ?? $post->excerpt_en, 80) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $post->author_name ?? 'غير محدد' }}</td>
                                    <td>{{ $post->publication_date ? $post->publication_date->format('Y-m-d') : 'غير محدد' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.blog.toggle-status', $post) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $post->is_published ? 'btn-success' : 'btn-warning' }}">
                                                {{ $post->is_published ? 'منشور' : 'مسودة' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blog.show', $post) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.edit', $post) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" 
                                                  action="{{ route('admin.blog.destroy', $post) }}" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                    <p class="text-muted">لا توجد مقالات للعرض</p>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        إضافة مقال جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection