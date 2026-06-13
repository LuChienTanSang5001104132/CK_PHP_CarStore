@extends('admin.layout.app')

@section('title', 'Thêm Xe Mới')
@section('header', 'Thêm Xe Mới')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6 md:p-8">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Thông tin xe nhập kho</h2>
    </div>

    <div id="errorAlert" class="hidden mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl text-red-700 text-sm shadow-sm"></div>

    <form id="createCarForm" class="space-y-6">
        {{-- THÔNG TIN CƠ BẢN --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i> Thông Tin Cơ Bản
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên xe <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ví dụ: VinFast VF8 Ultra">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hãng xe <span class="text-red-500">*</span></label>
                    <select id="brand_id" name="brand_id" required class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Đang tải dữ liệu... --</option>
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
                    <select name="type" required class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn loại xe --</option>
                        <option value="SUV">SUV</option>
                        <option value="Sedan">Sedan</option>
                        <option value="Hatchback">Hatchback</option>
                        <option value="Pickup">Pickup</option>
                        <option value="MPV">MPV</option>
                        <option value="Crossover">Crossover</option>
                        <option value="Coupe">Coupe</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Màu sắc</label>
                    <input type="text" name="color" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ví dụ: Trắng, Đen, Đỏ...">
                </div>
            </div>
        </div>

        {{-- THÔNG SỐ KỸ THUẬT --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                <i class="fas fa-cogs text-orange-500"></i> Thông Số Kỹ Thuật
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nhiên liệu</label>
                    <select name="fuel_type" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn nhiên liệu --</option>
                        <option value="Xăng">Xăng</option>
                        <option value="Dầu">Dầu</option>
                        <option value="Điện">Điện</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Plug-in Hybrid">Plug-in Hybrid</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hộp số</label>
                    <select name="transmission" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn hộp số --</option>
                        <option value="Tự động">Tự động</option>
                        <option value="Sàn">Sàn</option>
                        <option value="CVT">CVT</option>
                        <option value="DCT">DCT</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dung tích động cơ</label>
                    <input type="text" name="engine_capacity" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ví dụ: 2.0L, 1.5T...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số chỗ ngồi</label>
                    <select name="seats" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn số chỗ --</option>
                        <option value="2">2 chỗ</option>
                        <option value="4">4 chỗ</option>
                        <option value="5">5 chỗ</option>
                        <option value="7">7 chỗ</option>
                        <option value="8">8 chỗ</option>
                        <option value="9">9 chỗ</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ẢNH & MÔ TẢ --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                <i class="fas fa-image text-purple-500"></i> Ảnh & Mô Tả
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện của xe</label>
                    <input type="file" name="featured_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả chi tiết</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nhập thông số kỹ thuật hoặc giới thiệu xe..."></textarea>
                </div>
            </div>
        </div>

        {{-- TRẠNG THÁI --}}
        <div class="flex items-center">
            <input type="checkbox" id="statusCheckbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="statusCheckbox" class="ml-2 text-sm text-gray-700 font-medium">Kích hoạt mở bán ngay lập tức</label>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
            <a href="/admin/cars" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">Hủy bỏ</a>
            <button type="submit" id="submitBtn" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow transition-colors">
                <i class="fas fa-save mr-2"></i> Lưu lại
            </button>
        </div>
    </form>
</div>

<script>
    const token = localStorage.getItem('token');

    document.addEventListener('DOMContentLoaded', () => {
        if (!token) window.location.href = '/login';
        loadBrands();
    });

    // Tải danh sách hãng xe
    async function loadBrands() {
        try {
            const res = await fetch('/api/brands', { headers: { 'Accept': 'application/json' } });
            const result = await res.json();
            if (result.success || result.data) {
                const brands = result.data || result;
                let options = '<option value="">-- Chọn Hãng Xe --</option>';
                brands.forEach(b => {
                    options += `<option value="${b.id}">${b.name}</option>`;
                });
                document.getElementById('brand_id').innerHTML = options;
            }
        } catch (e) { console.error('Chưa có API lấy hãng xe'); }
    }

    // Xử lý Lưu Form
    document.getElementById('createCarForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        const errorAlert = document.getElementById('errorAlert');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Đang xử lý...';
        errorAlert.classList.add('hidden');

        // Tạo FormData để gửi cả file ảnh
        const formData = new FormData(e.target);
        
        // Gắn giá trị checkbox vào formData (nếu checked = 1, unchecked = 0)
        formData.set('status', document.getElementById('statusCheckbox').checked ? 1 : 0);

        try {
            const res = await fetch('/api/admin/cars', {
                method: 'POST',
                headers: { 
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                    // Không set Content-Type, trình duyệt sẽ tự động tạo boundary cho multipart/form-data
                },
                body: formData
            });

            const result = await res.json();

            if (res.ok && result.success) {
                alert('Thêm xe thành công!');
                window.location.href = '/admin/cars';
            } else {
                errorAlert.classList.remove('hidden');
                let errorMsg = result.message || 'Có lỗi xảy ra!';
                if (result.errors) {
                    errorMsg = Object.values(result.errors).map(err => `• ${err}`).join('<br>');
                }
                errorAlert.innerHTML = errorMsg;
            }
        } catch (error) {
            errorAlert.classList.remove('hidden');
            errorAlert.textContent = 'Lỗi kết nối đến máy chủ!';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Lưu lại';
        }
    });
</script>
@endsection