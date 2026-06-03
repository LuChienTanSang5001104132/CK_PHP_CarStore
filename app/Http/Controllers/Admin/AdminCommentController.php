<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['user:id,name,email,avatar', 'car:id,name,brand']);

        if ($request->filled('search')) {
            $query->where('content', 'like', "%{$request->search}%");
        }

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        $comments = $query->latest()->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data'    => $comments
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa bình luận thành công'
        ]);
    }
}