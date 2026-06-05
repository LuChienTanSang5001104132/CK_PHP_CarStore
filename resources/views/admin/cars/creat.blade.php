@extends('admin.layout.app')

@section('title', 'Thêm Xe Mới')
@section('header', 'Thêm Xe Mới')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6 md:p-8">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Thông tin xe nhập kho</h2>
    </div>

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tên xe <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ví dụ: VinFast VF8 Ultra">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hãng xe <span class="text-red-500">*</span></label>
                <select name="brand_id" required class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Chọn Hãng Xe --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Giá bán (₫) <span class="text-red-500">*</span></label>
                <input type="number" name="price" required min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nhập số tiền">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng trong kho <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" required min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ví dụ: 10">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Năm sản xuất <span class="text-red-500">*</span></label>
                <input type="number" name="year" required min="1900" max="{{ date('Y')+1 }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ date('Y') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phân khúc xe <span class="text-red-500">*</span></label>
                <input type="text" name="type" required class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ví dụ: SUV, Sedan, Hatchback...">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện của xe</label>
            <input type="file" name="featured_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả chi tiết</label>
            <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nhập thông số kỹ thuật hoặc giới thiệu xe..."></textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="status" id="status" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="status" class="ml-2 text-sm text-gray-700 font-medium">Kích hoạt mở bán ngay lập tức</label>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
            <a href="{{ route('admin.cars.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">Hủy bỏ</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow transition-colors">Lưu lại</button>
        </div>
    </form>
</div>
@endsection