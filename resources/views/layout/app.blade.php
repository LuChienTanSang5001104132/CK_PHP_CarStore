<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Car Store')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @section('header')
    <div class="phan_dau">
        <button class="nut_menu" onclick="moMenu()">Cài đặt</button>
        <div class="vung_tim_kiem">
            <button class="nut_tim_kiem" onclick="hienThiThanhTimKiem()">Tìm Kiếm</button>
            <div id="hop_tim_kiem">
                <input type="text" id="chuoi_tim_kiem" class="o_nhap_tim_kiem" placeholder="Nhập tên xe cần tìm..." oninput="xuLyTimKiem()">
                <div id="ket_qua_tim_kiem"></div>
            </div>
        </div>
    </div>
    @show
    @section('sidebar')
    <div class="man_chan" id="man_chan_menu" onclick="dongMenu()"></div>
    <div class="menu_trai" id="menu_trai">
        <div class="nut_dong_menu"><button onclick="dongMenu()">X</button></div>
        @auth
        <a href="#">Thông tin tài khoản</a>
        <a href="#">Bảo mật</a>
        <a href="#">Lịch sử thanh toán</a>
        <a href="#">Đăng xuất</a>
        @else
        <a href="#">Đăng nhập</a>
        @endauth
    </div>
    @show
    @yield('content')
    @section('footer')
    <div class="phan_cuoi">
        <div class="thong_tin_cong_ty">
            <div class="cong_ty_ten">CÔNG TY KẸO DỪA VĨNH LONG</div>
            <p class="cong_ty_mo_ta">Tự hào là đơn vị phân phối các dòng xe hơi chính hãng uy tín hàng đầu. Chúng tôi cam kết mang đến những sản phẩm đẳng cấp, dịch vụ bảo dưỡng chuẩn quốc tế cùng chính sách hậu mãi tối ưu. Đối với chúng tôi, sự an toàn trên mọi hành trình và sự hài lòng của quý khách luôn là trách nhiệm cao nhất.</p>
            <a href="{{ url('/ThongTin') }}" class="xem_them_link">Xem thêm</a>
        </div>
        <div class="vung_theo_doi">
            <div class="tieu_de_theo_doi">Liên hệ qua:</div>
            <div class="mxh_o">
                <a href="#" class="mxh_link"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                <a href="#" class="mxh_link"><svg viewBox="0 0 24 24"><path d="M12.213 0C5.367 0 0 5.367 0 12.213s5.367 12.213 12.213 12.213c4.27 0 7.376-2.115 8.795-4.786l-2.997-1.733c-.765 1.55-2.529 3.012-5.798 3.012-4.834 0-8.293-3.69-8.293-8.706s3.459-8.706 8.293-8.706c3.921 0 6.814 2.502 6.814 6.558 0 2.21-.765 3.328-1.921 3.328-1.026 0-1.464-.783-1.464-1.956V7.472h-3.418v1.071c-.783-.909-1.992-1.341-3.328-1.341-2.96 0-5.186 2.348-5.186 5.485 0 3.057 2.161 5.394 5.095 5.394 1.501 0 2.666-.637 3.375-1.592.519 1.137 1.637 1.774 3.374 1.774 2.911 0 4.885-2.31 4.885-6.558C24 4.549 19.38 0 12.213 0zm-1.137 15.35c-1.529 0-2.457-1.119-2.457-2.638 0-1.55.983-2.666 2.52-2.666 1.55 0 2.457 1.137 2.457 2.666 0 1.519-.946 2.638-2.52 2.638z"/></svg></a>
                <a href="#" class="mxh_link"><svg viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a>
                <a href="#" class="mxh_link"><svg viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                <a href="#" class="mxh_link"><svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                <a href="#" class="mxh_link"><svg viewBox="0 0 16 16"><path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.38 13.93 4 15.88 4v2a8 8 0 0 1-4.07-1.183V11.222C11.81 14.184 9.428 16 6 16c-3.41 0-6-2.262-6-5.56 0-3.196 2.204-5.352 5.5-5.352.26 0 .52.02.78.06V7.2a4 4 0 0 0-.78-.08c-2.146 0-3.5 1.157-3.5 3.164 0 2.204 1.6 3.586 3.986 3.586 2.108 0 3.834-1.31 3.834-3.666V0z"/></svg></a>
            </div>
        </div>
    </div>
    @show
    <script>
        function moMenu() { document.getElementById('menu_trai').classList.add('hoat_dong'); document.getElementById('man_chan_menu').classList.add('hoat_dong'); }
        function dongMenu() { document.getElementById('menu_trai').classList.remove('hoat_dong'); document.getElementById('man_chan_menu').classList.remove('hoat_dong'); }
        function hienThiThanhTimKiem() { const hop = document.getElementById('hop_tim_kiem'); if (hop.style.display === 'none' || hop.style.display === '') { hop.style.display = 'block'; document.getElementById('chuoi_tim_kiem').focus(); } else { hop.style.display = 'none'; } }
        function xuLyTimKiem() {
            const tu_khoa = document.getElementById('chuoi_tim_kiem').value.trim();
            const khung_ket_qua = document.getElementById('ket_qua_tim_kiem');
            if (tu_khoa === '') { khung_ket_qua.innerHTML = ''; return; }
            fetch('{{ url('/TimKiem') }}?q=' + tu_khoa)
            .then(res => res.json())
            .then(data => {
                khung_ket_qua.innerHTML = '';
                if (data.length === 0) {
                    khung_ket_qua.innerHTML = '<div style="padding: 10px; text-align: center; color: #666666; font-size: 14px;">Không tìm thấy xe nào!</div>';
                    return;
                }
                data.forEach(xe => {
                    const the_a = document.createElement('a');
                    the_a.href = '{{ url('/ChiTietXe') }}/' + xe.id;
                    the_a.className = 'the_goi_y';
                    the_a.innerHTML = '<img src="{{ url('/Image') }}/' + xe.featured_image + '" class="hinh_goi_y"><span class="ten_goi_y">' + xe.name + '</span>';
                    khung_ket_qua.appendChild(the_a);
                });
            });
        }
    </script>
</body>
</html>