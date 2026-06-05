<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// FIXED: Dùng Review model thay vì Comment (Comment model không tồn tại,
//        bảng thực tế là 'reviews' theo migration)
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

        // FIXED: Thêm filter theo rating (tính năng hữu ích cho admin)
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $comments = $query->latest()->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data'    => $comments
        ]);
    }

    public function destroy($id)
    {
        // FIXED: dùng Review::findOrFail thay vì Comment::findOrFail
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa bình luận thành công'
        ]);
    }
}
