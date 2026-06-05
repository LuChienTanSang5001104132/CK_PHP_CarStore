@extends('admin.layout.app')

@section('title', 'Cập Nhật Xe')
@section('header', 'Chỉnh Sửa Thông Tin Xe')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6 md:p-8">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Chỉnh sửa: <span class="text-blue-600">{{ $car->name }}</span></h2>
    </div>

    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tên xe</label>
                <input type="text" name="name" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $car->name }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hãng xe</label>
                <select name="brand_id" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $car->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Giá bán (₫)</label>
                <input type="number" name="price" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ intval($car->price) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng kho</label>
                <input type="number" name="quantity" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $car->quantity }}">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Thay đổi ảnh mới (Để trống nếu giữ ảnh cũ)</label>
            @if($car->featured_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $car->featured_image) }}" class="w-32 h-20 object-cover rounded-xl shadow-sm border">
                </div>
            @endif
            <input type="file" name="featured_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
            <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">{{ $car->description }}</textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="status" id="status" value="1" {{ $car->status ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="status" class="ml-2 text-sm text-gray-700 font-medium">Kích hoạt mở bán</label>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
            <a href="{{ route('admin.cars.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">Hủy</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow transition-colors">Cập nhật ngay</button>
        </div>
    </form>
</div>
@endsection