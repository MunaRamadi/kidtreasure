<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Story::with('user');

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('child_name', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%")
                  ->orWhere('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $stories = $query->latest('submission_date')->paginate(15)->withQueryString();

        return view('admin.stories.index', compact('stories'));
    }

    public function show(Story $story)
    {
        return view('admin.stories.show', compact('story'));
    }

    public function updateStatus(Request $request, Story $story)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $story->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);

        return back()->with('success', 'تم تحديث حالة القصة بنجاح');
    }

    public function destroy(Story $story)
    {
        // حذف الملفات المرفقة
        if ($story->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $story->image_url));
        }
        
        if ($story->video_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $story->video_url));
        }

        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم حذف القصة بنجاح');
    }
}
