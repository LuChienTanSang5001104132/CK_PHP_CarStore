<nav class="bg-white shadow-sm border-b sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-black text-blue-600 flex items-center gap-2 tracking-tight">
            <i class="fas fa-car-side text-blue-600"></i> 
            <span class="bg-gradient-to-r from-blue-700 to-blue-500 bg-clip-text text-transparent">CARSTORE</span>
        </a>

        <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
            <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
            <a href="/cars" class="hover:text-blue-600 transition">Mẫu xe</a>
        </div>

        <div class="flex items-center gap-6">
            <a href="/cart" class="text-gray-700 hover:text-blue-600 font-medium flex items-center gap-2 text-sm relative py-2 transition">
                <i class="fa-solid fa-cart-shopping text-lg"></i> Giỏ hàng
                <span id="cart-count" class="absolute top-0 -right-3 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-sm">0</span>
            </a>

            <div id="auth-section" class="relative ml-2 group">
                <div class="animate-pulse flex items-center gap-2 py-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                    <div class="h-4 w-20 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const authSection = document.getElementById('auth-section');
        const token = localStorage.getItem('token');

        if (!token) {
            // Giao diện khi CHƯA đăng nhập
            authSection.innerHTML = `
                <div class="flex items-center gap-4">
                    <a href="/login" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition"><i class="fa-solid fa-arrow-right-to-bracket"></i> Đăng nhập</a>
                    <a href="/register" class="text-sm font-medium bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">Đăng ký</a>
                </div>
            `;
        } else {
            // Giao diện khi ĐÃ đăng nhập (Dropdown Avatar)
            authSection.innerHTML = `
                <div class="cursor-pointer text-gray-700 hover:text-blue-600 font-medium flex items-center gap-2 text-sm py-2 transition">
                    <img id="header-avatar" src="/images/default-avatar.png" class="w-8 h-8 rounded-full object-cover border border-gray-200 shadow-sm" alt="Avatar">
                    <span id="header-name">Đang tải...</span>
                    <i class="fa-solid fa-chevron-down text-[10px] transition duration-300 group-hover:rotate-180"></i>
                </div>
                
                <div class="absolute top-full right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                    <div class="p-3 border-b border-gray-50 bg-gray-50/50">
                        <p class="text-xs text-gray-500 mb-1">Đăng nhập với email:</p>
                        <p id="header-email" class="text-sm font-bold text-gray-800 truncate"></p>
                    </div>
                    
                    <a href="/profile" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition flex items-center gap-3">
                        <i class="fa-solid fa-id-card text-gray-400 w-4"></i> Hồ sơ cá nhân
                    </a>
                    <a href="/orders" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition flex items-center gap-3">
                        <i class="fa-solid fa-clock-rotate-left text-gray-400 w-4"></i> Lịch sử mua hàng
                    </a>
                    
                    <div class="border-t border-gray-100">
                        <button onclick="clientLogout()" class="w-full text-left block px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition flex items-center gap-3">
                            <i class="fa-solid fa-right-from-bracket text-red-400 w-4"></i> Đăng xuất
                        </button>
                    </div>
                </div>
            `;

            // Gọi API lấy dữ liệu User
            try {
                const res = await fetch('/api/profile', {
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                });
                const data = await res.json();
                
                if (data.status === 'success') {
                    const user = data.user || data.data;
                    document.getElementById('header-name').textContent = user.full_name || user.name;
                    document.getElementById('header-email').textContent = user.email;
                    
                    if (user.avatar) {
                        document.getElementById('header-avatar').src = '/storage/' + user.avatar;
                    } else {
                        // Tự động tạo ảnh từ chữ cái đầu nếu chưa có avatar
                        document.getElementById('header-avatar').src = `https://ui-avatars.com/api/?name=${user.name}&background=0D8ABC&color=fff&rounded=true`;
                    }
                } else {
                    clientLogout(); // Token hết hạn thì đăng xuất
                }
            } catch (err) {
                console.error("Lỗi:", err);
            }
        }
    });

    async function clientLogout() {
        const token = localStorage.getItem('token');
        if(token) {
            try {
                await fetch('/api/logout', { 
                    method: 'POST', 
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                });
            } catch(e) {}
            localStorage.removeItem('token');
            localStorage.removeItem('user_role');
        }
        window.location.href = '/login';
    }
</script>