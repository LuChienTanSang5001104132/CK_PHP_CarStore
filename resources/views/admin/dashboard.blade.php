@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('header', 'Tổng Quan')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng Doanh Thu</p>
                    <p class="text-3xl font-bold text-green-600 mt-2" id="total-revenue">0 ₫</p>
                </div>
                <div class="text-4xl text-green-500"><i class="fas fa-dollar-sign"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng Đơn Hàng</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2" id="total-orders">0</p>
                </div>
                <div class="text-4xl text-blue-500"><i class="fas fa-shopping-bag"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Khách Hàng</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2" id="total-customers">0</p>
                </div>
                <div class="text-4xl text-purple-500"><i class="fas fa-users"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Sản Phẩm</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2" id="total-cars">0</p>
                </div>
                <div class="text-4xl text-orange-500"><i class="fas fa-car"></i></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Doanh thu theo tháng -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Doanh Thu 6 Tháng Gần Nhất</h3>
            <canvas id="revenueChart" height="120"></canvas>
        </div>

        <!-- Top xe bán chạy -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Top 5 Xe Bán Chạy</h3>
            <div id="top-cars" class="space-y-4"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Load data từ API
async function loadDashboard() {
    try {
        const res = await fetch('/api/admin/dashboard', {
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
        });
        const data = await res.json();

        if (data.success) {
            const d = data.data;

            document.getElementById('total-revenue').textContent = 
                Number(d.overview.total_revenue).toLocaleString('vi-VN') + ' ₫';
            
            document.getElementById('total-orders').textContent = d.overview.total_orders;
            document.getElementById('total-customers').textContent = d.overview.total_customers;
            document.getElementById('total-cars').textContent = d.overview.total_cars;

            // Render Top Cars
            let html = '';
            d.top_cars.forEach(car => {
                html += `
                    <div class="flex items-center gap-4">
                        <img src="/storage/${car.image}" class="w-12 h-12 object-cover rounded-lg" alt="">
                        <div class="flex-1">
                            <p class="font-medium">${car.name}</p>
                            <p class="text-sm text-gray-500">${car.brand}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">${Number(car.total_sold)} xe</p>
                        </div>
                    </div>`;
            });
            document.getElementById('top-cars').innerHTML = html;

            // Revenue Chart
            renderRevenueChart(d.revenue_last_6_months);
        }
    } catch (e) {
        console.error(e);
    }
}

function renderRevenueChart(months) {
    const ctx = document.getElementById('revenueChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months.map(m => m.month),
            datasets: [{
                label: 'Doanh Thu (triệu)',
                data: months.map(m => (m.revenue / 1000000).toFixed(1)),
                borderColor: '#1e40af',
                backgroundColor: 'rgba(30, 64, 175, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
}

// Load khi trang sẵn sàng
document.addEventListener('DOMContentLoaded', loadDashboard);
</script>
@endsection