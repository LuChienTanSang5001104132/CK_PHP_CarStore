<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CarStore Admin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <!-- Icons (Heroicons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        .sidebar { transition: all 0.3s; }
        .nav-link { transition: all 0.2s; }
        .nav-link:hover { background-color: #1e40af; color: white; }
        .card-hover { transition: transform 0.2s; }
        .card-hover:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white sidebar overflow-y-auto">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-car"></i> CARSTORE
            </h1>
            <p class="text-gray-400 text-sm">Quản Trị Viên</p>
        </div>

        <nav class="p-4">
            <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.cars.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1">
                <i class="fas fa-car w-5"></i>
                <span>Quản lý Xe</span>
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1">
                <i class="fas fa-users w-5"></i>
                <span>Quản lý Người dùng</span>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1">
                <i class="fas fa-shopping-cart w-5"></i>
                <span>Quản lý Đơn hàng</span>
            </a>
            
            <a href="{{ route('admin.comments.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1">
                <i class="fas fa-comments w-5"></i>
                <span>Quản lý Bình luận</span>
            </a>

            <div class="my-6 border-t border-gray-800"></div>

            <a href="{{ route('admin.reports') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg mb-1">
                <i class="fas fa-chart-bar w-5"></i>
                <span>Báo cáo & Thống kê</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Xin chào, <strong>{{ auth()->user()->name }}</strong></span>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-red-600 hover:text-red-700 flex items-center gap-1">
                    <i class="fas fa-sign-out-alt"></i>
                    Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('-translate-x-full');
}
</script>

@yield('scripts')

</body>
</html>