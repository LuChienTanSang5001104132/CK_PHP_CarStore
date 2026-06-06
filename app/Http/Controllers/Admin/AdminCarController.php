<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Brand; // Import thêm Model Brand để làm bộ lọc hoặc form thêm mới
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCarController extends Controller
{
    // 1. TRANG DANH SÁCH XE
    public function index(Request $request)
    {
        $query = Car::with('brand')->withCount('orderItems');

        // Tìm kiếm theo tên xe hoặc tên hãng
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"));
            });
        }

        // Lọc theo hãng
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate($request->get('per_page', 15));
        $brands = Brand::all(); // Lấy danh sách hãng để đổ vào thanh Select tìm kiếm trên giao diện

        // SỬA: Trả về view thay vì JSON
        return view('admin.cars.index', compact('cars', 'brands'));
    }

    // 2. TRANG HIỂN THỊ FORM THÊM XE
    public function create()
    {
        $brands = Brand::all(); // Cần danh sách hãng để Admin chọn khi thêm xe
        return view('admin.cars.creat', compact('brands'));
    }

    // 3. XỬ LÝ LƯU XE MỚI VÀO DATABASE
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'brand_id'        => 'required|exists:brands,id',
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
            'featured_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->except(['featured_image', 'slug']);
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        $data['status'] = $request->has('status') ? 1 : 0; // Đảm bảo checkbox trạng thái hoạt động đúng

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('cars', 'public');
        }

        Car::create($data);

        // SỬA: Chuyển hướng kèm thông báo thành công
        return redirect()->route('admin.cars.index')->with('success', 'Thêm xe thành công!');
    }

    // 4. TRANG XEM CHI TIẾT XE (Nếu bạn cần)
    public function show($id)
    {
        $car = Car::with(['brand'])->findOrFail($id);
        return view('admin.cars.show', compact('car'));
    }

    // 5. TRANG HIỂN THỊ FORM SỬA XE
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $brands = Brand::all();
        return view('admin.cars.edit', compact('car', 'brands'));
    }

    // 6. XỬ LÝ CẬP NHẬT THÔNG TIN XE
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
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->filled('name')) {
            $data['slug'] = Str::slug($request->name) . '-' . $car->id;
        }

        if ($request->hasFile('featured_image')) {
            if ($car->featured_image) {
                Storage::disk('public')->delete($car->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('cars', 'public');
        }

        $car->update($data);

        // SỬA: Chuyển hướng kèm thông báo thành công
        return redirect()->route('admin.cars.index')->with('success', 'Cập nhật xe thành công!');
    }

    // 7. XỬ LÝ XÓA XE
    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Bảo vệ dữ liệu: Xe đã có đơn hàng thì không được xóa
        if ($car->orderItems()->exists()) {
            return redirect()->route('admin.cars.index')->with('error', 'Không thể xóa xe này vì nó đã nằm trong đơn hàng!');
        }

        if ($car->featured_image) {
            Storage::disk('public')->delete($car->featured_image);
        }

        $car->delete();

        // SỬA: Chuyển hướng kèm thông báo thành công
        return redirect()->route('admin.cars.index')->with('success', 'Xóa xe thành công!');
    }
}