@extends('layouts.app')

@section('title', 'Danh Sách Mẫu Xe Đẳng Cấp - CarStore')

@section('styles')
<style>
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endsection

@section('content')
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight">Khám Phá Các Mẫu Xe</h1>
            <p class="mt-4 text-gray-400 max-w-2xl mx-auto text-sm md:text-base">Bộ sưu tập siêu xe và xe sang đẳng cấp nhất, mang đến trải nghiệm lái hoàn hảo dành riêng cho bạn.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                        <h2 class="font-bold text-lg flex items-center gap-2 text-gray-800">
                            <i class="fas fa-filter text-blue-600"></i>Bộ Lọc
                        </h2>
                        <button onclick="resetFilters()" class="text-sm text-gray-400 hover:text-blue-600 transition">Xóa lọc</button>
                    </div>

                    <form id="filterForm" class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Tìm kiếm</label>
                            <input type="text" id="search" class="w-full border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2.5 border outline-none transition" placeholder="Tên xe...">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Hãng xe</label>
                            <select id="brand_id" class="w-full border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2.5 border outline-none transition bg-white">
                                <option value="">Tất cả hãng xe</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Phân khúc</label>
                            <select id="type" class="w-full border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2.5 border outline-none transition bg-white">
                                <option value="">Tất cả các loại</option>
                                <option value="SUV">SUV</option>
                                <option value="Sedan">Sedan</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="Coupe">Coupe</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-md shadow-blue-100 transition duration-200">
                            Áp dụng bộ lọc
                        </button>
                    </form>
                </div>
            </div>

            <div class="w-full lg:w-3/4">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800 tracking-tight" id="result-count">Đang tải danh sách xe...</h2>
                </div>

                <div id="cars-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>

                <div id="pagination" class="mt-10 flex justify-center gap-2"></div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<script>
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', () => {
        loadBrands();
        fetchCars();
    });

    // 1. Lấy danh sách hãng xe điền vào Selectbox
    async function loadBrands() {
        try {
            const res = await fetch('/api/brands');
            const result = await res.json();
            if (result.success || result.data) {
                const brands = result.data || result;
                let options = '<option value="">Tất cả hãng xe</option>';
                brands.forEach(b => {
                    options += `<option value="${b.id}">${b.name}</option>`;
                });
                document.getElementById('brand_id').innerHTML = options;
            }
        } catch (e) { 
            console.error('Lỗi tải hãng xe:', e); 
        }
    }

    // 2. Lấy danh sách xe hiển thị ra lưới kết hợp tham số lọc
    async function fetchCars(page = 1) {
        currentPage = page;
        const search = document.getElementById('search').value;
        const brand_id = document.getElementById('brand_id').value;
        const type = document.getElementById('type').value;
        
        const params = new URLSearchParams({ page, search, brand_id, type, status: 1 });
        const grid = document.getElementById('cars-grid');
        
        grid.innerHTML = '<div class="col-span-full text-center py-12"><i class="fas fa-circle-notch fa-spin text-3xl text-blue-500"></i></div>';

        try {
            const res = await fetch(`/api/cars?${params.toString()}`);
            const result = await res.json();

            if (result.success) {
                const carsData = result.data.data ? result.data.data : result.data; 
                const paginationData = result.data.current_page ? result.data : null;

                document.getElementById('result-count').innerHTML = `Hiển thị <span class="text-blue-600 font-extrabold">${result.data.total || carsData.length}</span> mẫu xe`;
                
                renderCarsGrid(carsData);
                
                if (paginationData) {
                    renderPagination(paginationData);
                }
            }
        } catch (e) {
            grid.innerHTML = `<div class="col-span-full text-center py-12 text-red-500 font-semibold"><i class="fas fa-exclamation-circle mr-2"></i>Không thể tải dữ liệu xe từ máy chủ.</div>`;
        }
    }

    // 3. Xử lý sự kiện gửi Form bộ lọc
    document.getElementById('filterForm').addEventListener('submit', (e) => {
        e.preventDefault();
        fetchCars(1);
    });

    // Hàm đặt lại bộ lọc về rỗng
    function resetFilters() {
        document.getElementById('search').value = '';
        document.getElementById('brand_id').value = '';
        document.getElementById('type').value = '';
        fetchCars(1);
    }

    // 4. Vẽ danh sách cấu trúc Card Xe ra HTML
    function renderCarsGrid(cars) {
        const grid = document.getElementById('cars-grid');
        
        if (!cars || cars.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full text-center py-16 text-gray-400">
                    <i class="fas fa-car-rear text-4xl mb-3 block"></i>
                    <p>Không tìm thấy mẫu xe nào phù hợp với bộ lọc.</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = cars.map(car => {
            const defaultImgPath = `/Image/${encodeURIComponent(car.name)}.jpg`;
            const imgUrl = car.featured_image ? `/storage/${car.featured_image}` : defaultImgPath;
            const priceFormatted = new Intl.NumberFormat('vi-VN').format(car.price) + ' ₫';
            
            return `
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm card-hover flex flex-col group">
                    <div class="relative h-48 overflow-hidden bg-gray-50 flex items-center justify-center p-4">
                        <img src="${imgUrl}" alt="${car.name}" class="w-full h-full object-contain group-hover:scale-105 transition duration-500" onerror="this.src='https://via.placeholder.com/400x250?text=CarStore'">
                        <div class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">${car.type || 'N/A'}</div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow border-t border-gray-50">
                        <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wider mb-1">${car.brand ? car.brand.name : 'N/A'}</p>
                        <h3 class="font-bold text-gray-900 mb-2 leading-tight text-base group-hover:text-blue-600 transition truncate">${car.name}</h3>
                        <div class="flex items-center gap-4 text-xs text-gray-400 font-medium mb-4">
                            <span><i class="fas fa-gas-pump mr-1.5 text-gray-300"></i>${car.fuel_type || 'N/A'}</span>
                            <span><i class="fas fa-cog mr-1.5 text-gray-300"></i>${car.transmission || 'N/A'}</span>
                        </div>
                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                            <span class="font-black text-blue-600 text-base md:text-lg">${priceFormatted}</span>
                            <a href="/ChiTietXe/${car.id}" class="bg-gray-900 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition-all duration-200">
                                Chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // 5. Kết xuất giao diện phân trang nút bấm
    function renderPagination(data) {
        const pagination = document.getElementById('pagination');
        let html = '';
        if (data.current_page > 1) {
            html += `<button onclick="fetchCars(${data.current_page - 1})" class="px-4 py-2 bg-white border border-gray-200 text-sm rounded-xl hover:bg-gray-50 text-gray-700 font-semibold transition">Trang Trước</button>`;
        }
        if (data.current_page < data.last_page) {
            html += `<button onclick="fetchCars(${data.current_page + 1})" class="px-4 py-2 bg-white border border-gray-200 text-sm rounded-xl hover:bg-gray-50 text-gray-700 font-semibold transition">Trang Sau</button>`;
        }
        pagination.innerHTML = html;
    }
</script>
@endsection