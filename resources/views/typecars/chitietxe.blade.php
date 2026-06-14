@extends('layouts.app')

@section('title', 'Chi Tiết Siêu Xe | CarStore')

@section('content')
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm text-gray-500 flex items-center gap-2">
            <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
            <a href="/mauxe" class="hover:text-blue-600 transition">Mẫu xe</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
            <span id="breadcrumb-name" class="font-semibold text-gray-800">Đang tải...</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div id="loading-spinner" class="text-center py-20">
            <i class="fas fa-circle-notch fa-spin text-4xl text-blue-500 mb-4"></i>
            <p class="text-gray-500 text-sm font-medium">Đang tải thông tin chi tiết siêu xe...</p>
        </div>

        <div id="car-details" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">
                
                <div class="w-full lg:col-span-3">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-center h-[350px] md:h-[450px] lg:h-[520px] transition-all overflow-hidden group">
                        <img id="car-main-image" src="" alt="Hình ảnh xe" class="w-full h-full object-contain drop-shadow-2xl group-hover:scale-105 transition duration-500">
                    </div>
                </div>

                <div class="w-full lg:col-span-2 flex flex-col h-full min-h-[350px] md:min-h-[450px] lg:min-h-[520px]">
                    <div class="mb-2 flex flex-wrap gap-2">
                        <span id="car-brand" class="bg-blue-50 text-blue-700 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide">Hãng Xe</span>
                        <span id="car-type" class="bg-gray-100 text-gray-600 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide">Phân Khúc</span>
                    </div>
                    
                    <h1 id="car-name" class="text-3xl md:text-4xl font-black text-gray-900 mt-2 mb-2 tracking-tight leading-tight">Tên Mẫu Xe</h1>
                    
                    <div class="flex items-center gap-5 text-xs text-gray-400 font-medium mb-6">
                        <span id="car-year"><i class="far fa-calendar-alt mr-1 text-gray-300"></i> Năm SX: --</span>
                        <span><i class="fas fa-eye mr-1 text-gray-300"></i> Lượt xem: <span id="car-views" class="font-semibold text-gray-600">0</span></span>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 mb-6 border border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Giá niêm yết chính hãng</p>
                        <h2 id="car-price" class="text-3xl md:text-4xl font-black text-blue-600 tracking-tight">0 ₫</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-sm"><i class="fas fa-gas-pump"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Nhiên liệu</p>
                                <p id="car-fuel" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 text-sm"><i class="fas fa-cog"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Hộp số</p>
                                <p id="car-transmission" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-sm"><i class="fas fa-chair"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Số chỗ</p>
                                <p id="car-seats" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-sm"><i class="fas fa-tachometer-alt"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Động cơ</p>
                                <p id="car-engine" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-auto">
                        <button onclick="addToCart()" class="flex-1 bg-gray-900 hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ
                        </button>
                        <button onclick="buyNow()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2">
                            <i class="fa-regular fa-credit-card"></i> Mua ngay
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-12 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fas fa-align-left text-blue-600 text-sm"></i> Tổng quan về dòng xe
                </h3>
                <p id="car-description" class="text-gray-600 leading-relaxed whitespace-pre-line text-base"></p>
            </div>
        </div>
        
    </div>
@endsection

@section('scripts')
<script>
    // Lấy biến ID từ Route truyền sang
    const carId = Number('{{ $id }}');

    document.addEventListener('DOMContentLoaded', () => {
        loadCarDetails();
    });

    // 1. Hàm nạp thông tin chi tiết xe từ API Backend
    async function loadCarDetails() {
        const spinner = document.getElementById('loading-spinner');
        const detailsBox = document.getElementById('car-details');

        try {
            const res = await fetch(`/api/cars/${carId}`);
            const result = await res.json();

            if (res.ok && result.success) {
                const car = result.data;

                // Điền dữ liệu vào giao diện
                document.getElementById('breadcrumb-name').textContent = car.name;
                document.getElementById('car-name').textContent = car.name;
                document.getElementById('car-brand').textContent = car.brand ? car.brand.name : 'N/A';
                document.getElementById('car-type').textContent = car.type || 'N/A';
                document.getElementById('car-year').innerHTML = `<i class="far fa-calendar-alt mr-1 text-gray-300"></i> Năm SX: ${car.year}`;
                document.getElementById('car-views').textContent = car.views || 0;
                document.getElementById('car-price').textContent = new Intl.NumberFormat('vi-VN').format(car.price) + ' ₫';
                
                document.getElementById('car-fuel').textContent = car.fuel_type || '--';
                document.getElementById('car-transmission').textContent = car.transmission || '--';
                document.getElementById('car-seats').textContent = car.seats ? car.seats + ' chỗ' : '--';
                document.getElementById('car-engine').textContent = car.engine_capacity || '--';
                
                document.getElementById('car-description').textContent = car.description || 'Hiện tại chưa có bài viết đánh giá chi tiết cho dòng sản phẩm này.';

                // Tải hình ảnh
                const defaultImgPath = `/Image/${encodeURIComponent(car.name)}.jpg`;
                const imgUrl = car.featured_image ? `/storage/${car.featured_image}` : defaultImgPath;
                
                const mainImage = document.getElementById('car-main-image');
                mainImage.src = imgUrl;
                mainImage.onerror = function() {
                    this.src = 'https://via.placeholder.com/800x500?text=Hinh+Anh+Dang+Cap+Nhat';
                };

                // Hiển thị nội dung
                spinner.classList.add('hidden');
                detailsBox.classList.remove('hidden');

            } else {
                spinner.innerHTML = `
                    <div class="p-6 bg-red-50 border border-red-200 rounded-2xl max-w-md mx-auto text-red-700">
                        <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                        <p class="font-bold">${result.message || 'Mẫu xe này không tồn tại hoặc đã ngừng kinh doanh!'}</p>
                        <a href="/mauxe" class="mt-4 inline-block text-sm bg-gray-900 text-white px-4 py-2 rounded-xl font-semibold">Quay lại showroom</a>
                    </div>`;
            }
        } catch (error) {
            spinner.innerHTML = `
                <div class="text-red-500 font-bold">
                    <i class="fas fa-wifi text-2xl mb-2"></i>
                    <p>Lỗi kết nối nghiêm trọng đến máy chủ, vui lòng thử lại sau!</p>
                </div>`;
        }
    }

    // 2. Chức năng Thêm vào giỏ hàng
    async function addToCart() {
        const token = localStorage.getItem('token');
        
        if (!token) {
            alert('⚠️ Bạn vui lòng đăng nhập tài khoản để thực hiện tính năng thêm sản phẩm vào giỏ hàng!');
            window.location.href = '/login';
            return false;
        }

        try {
            const res = await fetch('/api/cart', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token, 
                    'Accept': 'application/json' 
                },
                body: JSON.stringify({
                    car_id: carId,
                    quantity: 1
                })
            });

            const result = await res.json();

            if (res.ok && result.success) {
                alert('✅ Đã thêm siêu xe vào hệ thống giỏ hàng của bạn thành công!');
                // Tùy chọn: Bạn có thể cập nhật số lượng giỏ hàng trên Header tại đây nếu muốn
                return true;
            } else {
                alert('❌ Thao tác thất bại: ' + (result.message || 'Hệ thống giỏ hàng đang bận!'));
                return false;
            }
        } catch (error) {
            alert('❌ Máy chủ phản hồi lỗi, không thể cập nhật giỏ hàng lúc này!');
            return false;
        }
    }

    // 3. Chức năng Mua ngay
    async function buyNow() {
        const success = await addToCart();
        if (success) {
            window.location.href = '/checkout';
        }
    }
</script>
@endsection