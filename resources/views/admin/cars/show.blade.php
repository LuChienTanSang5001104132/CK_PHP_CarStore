@extends('admin.layout.app')

@section('title', 'Chi Tiết Xe')
@section('header', 'Chi Tiết Xe')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="/admin/cars" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h2 id="car-name-title" class="text-2xl font-bold text-gray-800">Đang tải...</h2>
                <p class="text-sm text-gray-500 mt-0.5">Chi tiết thông tin xe</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a id="btn-edit" href="#"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition-colors text-sm">
                <i class="fas fa-edit mr-2"></i> Chỉnh Sửa
            </a>
        </div>
    </div>

    <div id="car-content-wrapper" class="grid grid-cols-1 lg:grid-cols-3 gap-6 hidden">
        {{-- Cột trái: Ảnh + Trạng thái --}}
        <div class="lg:col-span-1 flex flex-col gap-6">

            {{-- Ảnh chính --}}
            <div class="bg-white rounded-2xl shadow p-4" id="main-image-container">
                </div>

            {{-- Trạng thái & Thống kê --}}
            <div class="bg-white rounded-2xl shadow p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Trạng thái</span>
                    <span id="car-status-badge"></span>
                </div>
                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-sm text-gray-500"><i class="fas fa-boxes mr-1 text-blue-400"></i> Tồn kho</span>
                    <span class="font-bold text-gray-800" id="car-quantity"></span>
                </div>
                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-sm text-gray-500"><i class="fas fa-eye mr-1 text-purple-400"></i> Lượt xem</span>
                    <span class="font-bold text-gray-800" id="car-views"></span>
                </div>
            </div>
        </div>

        {{-- Cột phải: Thông tin chi tiết --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- Thông tin cơ bản --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500"></i> Thông Tin Cơ Bản
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Tên Xe</p>
                        <p class="font-semibold text-gray-800" id="car-name"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Hãng Xe</p>
                        <p class="font-semibold text-gray-800" id="car-brand"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Giá Bán</p>
                        <p class="font-bold text-green-600 text-lg" id="car-price"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Năm Sản Xuất</p>
                        <p class="font-semibold text-gray-800" id="car-year"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Loại Xe</p>
                        <p class="font-semibold text-gray-800" id="car-type"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Màu Sắc</p>
                        <p class="font-semibold text-gray-800" id="car-color"></p>
                    </div>
                </div>
            </div>

            {{-- Thông số kỹ thuật --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-cogs text-orange-500"></i> Thông Số Kỹ Thuật
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Nhiên Liệu</p>
                        <p class="font-semibold text-gray-800" id="car-fuel"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Hộp Số</p>
                        <p class="font-semibold text-gray-800" id="car-transmission"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Dung Tích Động Cơ</p>
                        <p class="font-semibold text-gray-800" id="car-engine"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Số Chỗ Ngồi</p>
                        <p class="font-semibold text-gray-800" id="car-seats"></p>
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="bg-white rounded-2xl shadow p-6 hidden" id="desc-container">
                <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-align-left text-purple-500"></i> Mô Tả
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line" id="car-desc"></p>
            </div>
            
            {{-- Đánh giá --}}
            <div class="bg-white rounded-2xl shadow p-6 hidden" id="reviews-container">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-star text-yellow-400"></i> Đánh Giá Gần Đây
                </h3>
                <div class="flex flex-col gap-3" id="reviews-list">
                    </div>
            </div>

        </div>
    </div>
</div>

<script>
    const token = localStorage.getItem('token');
    const urlParts = window.location.pathname.split('/');
    const carId = urlParts[3]; 

    document.addEventListener('DOMContentLoaded', () => {
        if (!token) window.location.href = '/login';
        
        document.getElementById('btn-edit').href = `/admin/cars/${carId}/edit`;
        loadCarDetails();
    });

    async function loadCarDetails() {
        try {
            const res = await fetch(`/api/admin/cars/${carId}`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const result = await res.json();
            
            if (result.success) {
                const car = result.data;
                document.getElementById('car-content-wrapper').classList.remove('hidden');
                
                // Đổ dữ liệu cơ bản
                document.getElementById('car-name-title').textContent = car.name;
                document.getElementById('car-name').textContent = car.name;
                document.getElementById('car-brand').textContent = car.brand ? car.brand.name : 'N/A';
                document.getElementById('car-price').textContent = new Intl.NumberFormat('vi-VN').format(car.price) + ' ₫';
                document.getElementById('car-year').textContent = car.year;
                document.getElementById('car-type').textContent = car.type || 'N/A';
                document.getElementById('car-color').textContent = car.color || 'N/A';
                
                // Trạng thái và thống kê
                const statusHtml = car.status == 1 
                    ? `<span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full"><i class="fas fa-circle text-[8px] mr-1"></i> Đang hoạt động</span>`
                    : `<span class="bg-red-100 text-red-600 text-xs font-semibold px-3 py-1 rounded-full"><i class="fas fa-circle text-[8px] mr-1"></i> Ngừng kinh doanh</span>`;
                document.getElementById('car-status-badge').innerHTML = statusHtml;
                document.getElementById('car-quantity').textContent = car.quantity + ' xe';
                document.getElementById('car-views').textContent = new Intl.NumberFormat('vi-VN').format(car.views || 0);

                // Thông số kỹ thuật
                document.getElementById('car-fuel').textContent = car.fuel_type || 'N/A';
                document.getElementById('car-transmission').textContent = car.transmission || 'N/A';
                document.getElementById('car-engine').textContent = car.engine_capacity || 'N/A';
                document.getElementById('car-seats').textContent = car.seats ? car.seats + ' chỗ' : 'N/A';

                // Ảnh chính
                const mainImgDiv = document.getElementById('main-image-container');
                if (car.featured_image) {
                    mainImgDiv.innerHTML = `<img src="/storage/${car.featured_image}" class="w-full h-56 object-contain rounded-xl bg-gray-50">`;
                } else {
                    mainImgDiv.innerHTML = `<div class="w-full h-56 bg-gray-100 rounded-xl flex flex-col items-center justify-center text-gray-400"><i class="fas fa-car text-4xl mb-2"></i><span class="text-sm">Chưa có ảnh</span></div>`;
                }

                // Mô tả
                if (car.description) {
                    document.getElementById('desc-container').classList.remove('hidden');
                    document.getElementById('car-desc').textContent = car.description;
                }

                // Đánh giá
                if (car.reviews && car.reviews.length > 0) {
                    document.getElementById('reviews-container').classList.remove('hidden');
                    let reviewHtml = '';
                    car.reviews.slice(0, 3).forEach(review => {
                        let stars = '';
                        for(let i=1; i<=5; i++) {
                            stars += `<i class="fas fa-star text-xs ${i <= review.rating ? 'text-yellow-400' : 'text-gray-200'}"></i>`;
                        }
                        
                        const dateObj = new Date(review.created_at);
                        const dateStr = dateObj.toLocaleDateString('vi-VN');
                        const userName = review.user ? review.user.name : 'Ẩn danh';

                        reviewHtml += `
                            <div class="border border-gray-100 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-semibold text-sm text-gray-800">${userName}</span>
                                    <span class="text-xs text-gray-400">${dateStr}</span>
                                </div>
                                <div class="flex gap-0.5 mb-2">${stars}</div>
                                ${review.content ? `<p class="text-sm text-gray-600">${review.content}</p>` : ''}
                            </div>
                        `;
                    });
                    document.getElementById('reviews-list').innerHTML = reviewHtml;
                }
            } else {
                alert('Không tìm thấy xe!');
                window.location.href = '/admin/cars';
            }
        } catch (e) {
            console.error('Lỗi tải chi tiết xe', e);
        }
    }
</script>
@endsection