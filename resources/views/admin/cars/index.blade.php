@extends('admin.layout.app')

@section('title', 'Quản Lý Xe')
@section('header', 'Danh Sách Xe')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Quản Lý Kho Xe</h2>
            <p class="text-sm text-gray-500 mt-1">Xem, tìm kiếm và điều chỉnh danh sách xe đang kinh doanh.</p>
        </div>
        <a href="/admin/cars/create" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
            <i class="fas fa-plus mr-2"></i> Thêm Xe Mới
        </a>
    </div>

    <div id="alert-box" class="hidden p-4 mb-6 rounded-xl text-sm shadow-sm font-medium"></div>

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <form id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" id="searchInput" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tìm theo tên xe, hãng...">
            </div>
            <div>
                <select id="brandSelect" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Chọn Hãng Xe --</option>
                    </select>
            </div>
            <div>
                <select id="statusSelect" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Trạng Thái --</option>
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Ngừng kinh doanh</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-xl px-4 py-2 transition-colors">
                <i class="fas fa-filter mr-1"></i> Lọc kết quả
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm font-semibold">
                        <th class="p-4">Hình Ảnh</th>
                        <th class="p-4">Tên Xe</th>
                        <th class="p-4">Hãng Xe</th>
                        <th class="p-4">Giá Bán</th>
                        <th class="p-4">Kho / Đơn</th>
                        <th class="p-4 text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody id="car-list" class="divide-y divide-gray-100 text-sm">
                    <tr><td colspan="6" class="p-8 text-center text-gray-400">Đang tải dữ liệu...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="pagination" class="mt-6 flex justify-end gap-2"></div>
</div>

<script>
    const token = localStorage.getItem('token');
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', () => {
        if (!token) window.location.href = '/login';
        loadBrands();
        fetchCars();
    });

    // 1. Tải danh sách hãng xe vào Select
    async function loadBrands() {
        try {
            // Giả định bạn sẽ tạo 1 API /api/brands, nếu chưa có, hãy tạo nó.
            const res = await fetch('/api/brands', { headers: { 'Accept': 'application/json' } });
            const result = await res.json();
            if (result.success || result.data) {
                const brands = result.data || result;
                let options = '<option value="">-- Chọn Hãng Xe --</option>';
                brands.forEach(b => {
                    options += `<option value="${b.id}">${b.name}</option>`;
                });
                document.getElementById('brandSelect').innerHTML = options;
            }
        } catch (e) { console.error('Chưa có API lấy hãng xe'); }
    }

    // 2. Lấy và hiển thị danh sách xe
    async function fetchCars(page = 1) {
        currentPage = page;
        const search = document.getElementById('searchInput').value;
        const brand_id = document.getElementById('brandSelect').value;
        const status = document.getElementById('statusSelect').value;

        const params = new URLSearchParams({ page, search, brand_id, status });

        try {
            const res = await fetch(`/api/admin/cars?${params.toString()}`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const result = await res.json();

            if (result.success) {
                renderTable(result.data.data);
                renderPagination(result.data);
            }
        } catch (e) {
            document.getElementById('car-list').innerHTML = `<tr><td colspan="6" class="p-8 text-center text-red-500">Lỗi tải dữ liệu!</td></tr>`;
        }
    }

    // 3. Xử lý Form Lọc
    document.getElementById('filterForm').addEventListener('submit', (e) => {
        e.preventDefault();
        fetchCars(1);
    });

    // 4. Render Bảng dữ liệu
    function renderTable(cars) {
        const tbody = document.getElementById('car-list');
        if (cars.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-gray-400">Không tìm thấy chiếc xe nào.</td></tr>`;
            return;
        }

        let html = '';
        cars.forEach(car => {
            const imgHtml = car.featured_image 
                ? `<img src="/storage/${car.featured_image}" class="w-20 h-12 object-contain bg-gray-50 rounded-xl shadow-sm">`
                : `<div class="w-20 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-xs text-gray-400">Không ảnh</div>`;
            
            const brandName = car.brand ? car.brand.name : 'N/A';
            const price = new Intl.NumberFormat('vi-VN').format(car.price) + ' ₫';

            html += `
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="p-4">${imgHtml}</td>
                <td class="p-4">
                    <p class="font-bold text-gray-900">${car.name}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Năm SX: ${car.year} | ${car.type}</p>
                </td>
                <td class="p-4 text-gray-600">${brandName}</td>
                <td class="p-4 font-bold text-green-600">${price}</td>
                <td class="p-4 text-gray-600">
                    <div>Còn lại: <span class="font-semibold">${car.quantity}</span></div>
                    <div class="text-xs text-blue-500 mt-0.5">Đã đặt: ${car.order_items_count || 0} đơn</div>
                </td>
                <td class="p-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="/admin/cars/${car.id}" class="text-gray-600 hover:text-gray-900 font-semibold bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors text-xs"><i class="fas fa-eye mr-1"></i> Xem</a>
                        <a href="/admin/cars/${car.id}/edit" class="text-blue-600 hover:text-blue-900 font-semibold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors text-xs"><i class="fas fa-edit mr-1"></i> Sửa</a>
                        <button onclick="deleteCar(${car.id})" class="text-red-600 hover:text-red-900 font-semibold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors text-xs"><i class="fas fa-trash mr-1"></i> Xóa</button>
                    </div>
                </td>
            </tr>`;
        });
        tbody.innerHTML = html;
    }

    // 5. Render Phân Trang
    function renderPagination(data) {
        const pagination = document.getElementById('pagination');
        let html = '';
        if (data.current_page > 1) {
            html += `<button onclick="fetchCars(${data.current_page - 1})" class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 text-sm font-medium">Trang Trước</button>`;
        }
        if (data.current_page < data.last_page) {
            html += `<button onclick="fetchCars(${data.current_page + 1})" class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 text-sm font-medium">Trang Sau</button>`;
        }
        pagination.innerHTML = html;
    }

    // 6. Xóa xe
    async function deleteCar(id) {
        if (!confirm('Bạn có chắc muốn xóa chiếc xe này?')) return;
        
        try {
            const res = await fetch(`/api/admin/cars/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const result = await res.json();
            
            const alertBox = document.getElementById('alert-box');
            alertBox.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'bg-red-50', 'text-red-700');
            
            if (result.success) {
                alertBox.classList.add('bg-green-50', 'text-green-700');
                alertBox.textContent = result.message || 'Xóa thành công!';
                fetchCars(currentPage);
            } else {
                alertBox.classList.add('bg-red-50', 'text-red-700');
                alertBox.textContent = result.message || 'Lỗi khi xóa!';
            }
        } catch (e) {
            alert('Lỗi kết nối máy chủ!');
        }
    }
</script>
@endsection