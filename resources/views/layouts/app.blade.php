<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CarStore - Hệ thống bán xe')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    @yield('styles')
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    @include('partials.header')

    <main class="flex-grow">
        @yield('content')
    </main>

<footer class="bg-gray-900 text-gray-300 pt-14 pb-8 mt-auto">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-10">
        <div>
            <div class="flex items-center gap-2 text-2xl font-black text-white mb-4">
                <i class="fa-solid fa-car-side text-blue-500"></i> CARSTORE
            </div>
            <p class="text-sm text-gray-400">Hệ thống phân phối xe chính hãng. Mang đẳng cấp đến gần hơn.</p>
            <div class="flex gap-4 mt-5">
                <a href="#" class="text-gray-400 hover:text-white transition text-xl"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition text-xl"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition text-xl"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-4">Khám phá</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-blue-400 transition">Đội xe mới nhất</a></li>
                <li><a href="#" class="hover:text-blue-400 transition">Chương trình lái thử</a></li>
                <li><a href="#" class="hover:text-blue-400 transition">Tin tức & sự kiện</a></li>
                <li><a href="#" class="hover:text-blue-400 transition">Video giới thiệu</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-4">Hỗ trợ</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-blue-400 transition">Chính sách bảo hành</a></li>
                <li><a href="#" class="hover:text-blue-400 transition">Hướng dẫn mua hàng</a></li>
                <li><a href="#" class="hover:text-blue-400 transition">Trả góp & vay</a></li>
                <li><a href="#" class="hover:text-blue-400 transition">Liên hệ showroom</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-4">Liên hệ</h4>
            <ul class="space-y-2 text-sm">
                <li><i class="fa-solid fa-location-dot mr-2 w-4 text-blue-400"></i> 280, An Dương Vương, phường Chợ Quán, Thành phố Hồ Chí Minh</li>
                <li><i class="fa-solid fa-phone mr-2 text-blue-400"></i> 0964584850</li>
                <li><i class="fa-regular fa-envelope mr-2 text-blue-400"></i> luchientansang@gmail.com</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-800 mt-12 pt-6 text-center text-xs text-gray-500">
        © {{ date('Y') }} CARSTORE. Được thực hiện bởi Team Kẹo dừa Vĩnh Long.
    </div>
</footer>

    @yield('scripts')
</body>
</html>