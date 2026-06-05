<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCarController extends Controller
{
    public function index(Request $request)
    {
        // FIXED: join với brands để lấy tên hãng; dùng with() thay vì query raw
        $query = Car::with('brand')->withCount('orderItems');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data'    => $cars
        ]);
    }

    public function show($id)
    {
        $car = Car::with(['brand', 'images', 'reviews.user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $car
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'brand_id'        => 'required|exists:brands,id',  // FIXED: validate brand_id
            'price'           => 'required|numeric|min:0',
            'quantity'        => 'required|integer|min:0',
            'year'            => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'type'            => 'required|string',
            'fuel_type'       => 'nullable|string',
            'transmission'    => 'nullable|string',
            'engine_capacity' => 'nullable|string',
            'seats'           => 'nullable|integer|min:1',
            'color'           => 'nullable|string',
            'description'     => 'nullable|string',
            'status'          => 'boolean',
            // FIXED: Xử lý upload ảnh đúng cách
            'featured_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->except(['featured_image', 'slug']);

        // Tạo slug tự động từ tên xe
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        // FIXED: Xử lý upload ảnh (phần này trước đây bị thiếu hoàn toàn)
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('cars', 'public');
        }

        $car = Car::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm xe thành công',
            'data'    => $car->load('brand')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'name'            => 'sometimes|string|max:255',
            'brand_id'        => 'sometimes|exists:brands,id',
            'price'           => 'sometimes|numeric|min:0',
            'quantity'        => 'sometimes|integer|min:0',
            'year'            => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'type'            => 'sometimes|string',
            'fuel_type'       => 'nullable|string',
            'transmission'    => 'nullable|string',
            'engine_capacity' => 'nullable|string',
            'seats'           => 'nullable|integer',
            'color'           => 'nullable|string',
            'description'     => 'nullable|string',
            'status'          => 'boolean',
            'featured_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->except(['featured_image', 'slug', '_method']);

        // Nếu đổi tên thì cập nhật slug
        if ($request->filled('name')) {
            $data['slug'] = Str::slug($request->name) . '-' . $car->id;
        }

        // FIXED: Xử lý thay ảnh mới và xóa ảnh cũ
        if ($request->hasFile('featured_image')) {
            if ($car->featured_image) {
                Storage::disk('public')->delete($car->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')
                ->store('cars', 'public');
        }

        $car->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật xe thành công',
            'data'    => $car->fresh()->load('brand')
        ]);
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // FIXED: Xóa ảnh trên storage khi xóa xe
        if ($car->featured_image) {
            Storage::disk('public')->delete($car->featured_image);
        }

        $car->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa xe thành công'
        ]);
    }
}
