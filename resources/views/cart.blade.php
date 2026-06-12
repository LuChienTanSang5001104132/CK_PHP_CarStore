<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng Của Bạn - CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                <i class="fas fa-car"></i> CARSTORE
            </a>
            <div class="flex items-center gap-6">
                <a href="/" class="hover:text-blue-600 font-medium">Trang chủ</a>
                <a href="/profile" class="hover:text-blue-600 font-medium">Tài khoản</a>
                <button onclick="logout()" class="text-red-500 hover:text-red-600 font-medium">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </button>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold mb-8 flex items-center gap-2">
            <i class="fas fa-shopping-cart text-blue-600"></i> Giỏ Hàng Của Bạn
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b text-gray-400 text-sm uppercase">
                                <th class="pb-3">Sản phẩm</th>
                                <th class="pb-3 text-center">Số lượng</th>
                                <th class="pb-3 text-right">Giá tiền</th>
                                <th class="pb-3 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-list">
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">Đang tải dữ liệu giỏ hàng...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border h-fit">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Tóm tắt đơn hàng</h3>
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-600">Tổng cộng:</span>
                    <span id="cart-total-price" class="text-2xl font-bold text-red-600">0 ₫</span>
                </div>
                
                <a href="/checkout" id="checkout-btn" class="block text-center w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-md shadow-blue-100">
                    Tiến hành thanh toán
                </a>
            </div>
        </div>
    </div>

    <script>
        // 1. Kiểm tra Token bảo mật ngay khi vào trang
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Vui lòng đăng nhập để xem giỏ hàng!');
            window.location.href = "{{ route('login') }}";
        }

        // 2. Hàm lấy dữ liệu giỏ hàng từ API
        async function fetchCart() {
            try {
                const res = await fetch('/api/cart', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                const result = await res.json();
                const tbody = document.getElementById('cart-items-list');
                const totalPriceDisplay = document.getElementById('cart-total-price');
                const checkoutBtn = document.getElementById('checkout-btn');

                if (res.ok && result.data && result.data.length > 0) {
                    let html = '';
                    let totalCartPrice = 0;

                    result.data.forEach(item => {
                        // Kiểm tra nếu thông tin xe tồn tại
                        const carName = item.car ? item.car.name : 'Sản phẩm không xác định';
                        const itemTotal = item.quantity * item.price;
                        totalCartPrice += itemTotal;

                        html += `
                            <tr class="border-b last:border-none">
                                <td class="py-4">
                                    <div class="font-bold text-gray-800">${carName}</div>
                                </td>
                                <td class="py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200 text-xs font-bold">-</button>
                                        <span class="font-semibold">${item.quantity}</span>
                                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200 text-xs font-bold">+</button>
                                    </div>
                                </td>
                                <td class="py-4 text-right font-semibold text-blue-600">
                                    ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(itemTotal)}
                                </td>
                                <td class="py-4 text-center">
                                    <button onclick="deleteItem(${item.id})" class="text-red-500 hover:text-red-700 transition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    tbody.innerHTML = html;
                    totalPriceDisplay.innerText = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalCartPrice);
                    checkoutBtn.classList.remove('opacity-50', 'pointer-events-none');
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center py-8 text-gray-400">Giỏ hàng của bạn đang trống.</td></tr>`;
                    totalPriceDisplay.innerText = '0 ₫';
                    checkoutBtn.classList.add('opacity-50', 'pointer-events-none');
                }
            } catch (err) {
                console.error(err);
                document.getElementById('cart-items-list').innerHTML = `<tr><td colspan="4" class="text-center py-8 text-red-500">Lỗi tải dữ liệu giỏ hàng.</td></tr>`;
            }
        }

        // 3. Hàm cập nhật số lượng sản phẩm (Gọi API PUT /api/cart/{id})
        async function updateQuantity(itemId, newQty) {
            if (newQty < 1) return; // Không cho giảm xuống dưới 1
            
            try {
                const res = await fetch(`/api/cart/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity: newQty })
                });

                if (res.ok) {
                    fetchCart(); // Tải lại dữ liệu giỏ hàng mới
                }
            } catch (err) {
                alert('Không thể cập nhật số lượng');
            }
        }

        // 4. Hàm xóa sản phẩm khỏi giỏ (Gọi API DELETE /api/cart/{id})
        async function deleteItem(itemId) {
            if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;

            try {
                const res = await fetch(`/api/cart/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    fetchCart();
                }
            } catch (err) {
                alert('Không thể xóa sản phẩm');
            }
        }

        // 5. Hàm đăng xuất của Client
        function logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user_role');
            window.location.href = "{{ route('login') }}";
        }

        // Chạy tải dữ liệu ngay khi trang được hiển thị
        fetchCart();
    </script>
</body>
</html>