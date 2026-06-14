<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with([
            'user:id,name,email,avatar',
            'car:id,name,brand_id',
            'car.brand:id,name',
        ]);

        if ($request->filled('search')) {
            $query->where('content', 'like', "%{$request->search}%");
        }

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $comments = $query->latest()->paginate($request->get('per_page', 20));
        
        // Truyền thêm biến $reviews để file Blade ở bước trước hoạt động đúng
        $reviews = $comments; 

        // Nếu gọi từ API
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $comments
            ]);
        }

        // Nếu gọi từ Giao diện Web
        return view('admin.comments.index', compact('comments', 'reviews'));
    }

    // LƯU Ý: Đã thêm Request $request vào hàm destroy để kiểm tra luồng API
    public function destroy(Request $request, $id) 
    {
        $review = Review::findOrFail($id);
        $review->delete();

        // Nếu gọi từ API
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa bình luận thành công'
            ]);
        }

        // Nếu gọi từ Giao diện Web
        return redirect()->route('admin.comments.index')->with('success', 'Đã xóa bình luận thành công!');
    }
}