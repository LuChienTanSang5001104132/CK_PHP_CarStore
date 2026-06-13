@extends('layout.app')
@section('title', 'Trang Chủ')
@section('content')
<div class="phan_than">
    <video class="khung_chuyen_clip hoat_dong" autoplay muted playsinline><source src="{{ asset('video/1.mp4') }}" type="video/mp4"></video>
    <video class="khung_chuyen_clip" autoplay muted playsinline><source src="{{ asset('video/2.mp4') }}" type="video/mp4"></video>
    <video class="khung_chuyen_clip" autoplay muted playsinline><source src="{{ asset('video/3.mp4') }}" type="video/mp4"></video>
    <button class="nut_dieu_huong nut_trai" onclick="clipTruoc()">&#10094;</button>
    <button class="nut_dieu_huong nut_phai" onclick="clipKeTiep()">&#10095;</button>
</div>
<div class="vung_banner_khung">
    <div class="vong_lap_banner" id="khung_truot_banner">
        <div class="the_banner banner_1">
            <div class="banner_chu">
                <h3 class="banner_tieu_de">Tuần Lễ Vàng - Săn Siêu Xe Sang!</h3>
                <p class="banner_mo_ta">Giảm ngay 5% giá trị xe & Tặng kèm gói bảo dưỡng kim cương 2 năm. Cơ hội sở hữu siêu phẩm cơ khí chưa bao giờ gần đến thế.</p>
            </div>
            <a href="#" class="banner_nut">Nhận Ưu Đãi</a>
        </div>
        <div class="the_banner banner_2">
            <div class="banner_chu">
                <h3 class="banner_tieu_de">Khai Xuân Đón Lộc - Rước Xe Trúng Lớn!</h3>
                <p class="banner_mo_ta">Cơ hội trúng ngay một chuyến du lịch Châu Âu dành cho 2 người khi hoàn tất thủ tục hợp đồng trong tháng này.</p>
            </div>
            <a href="#" class="banner_nut">Xem Chi Tiết</a>
        </div>
        <div class="the_banner banner_3">
            <div class="banner_chu">
                <h3 class="banner_tieu_de">Đặc Quyền Thành Viên - Khởi Đầu Thượng Lưu!</h3>
                <p class="banner_mo_ta">Gia nhập câu lạc bộ chủ sở hữu xe Kẹo Dừa Vĩnh Long để nhận vé mời VIP tham dự các đêm tiệc đẳng cấp siêu xe toàn quốc.</p>
            </div>
            <a href="#" class="banner_nut">Tham Gia Ngay</a>
        </div>
        <div class="the_banner banner_4">
            <div class="banner_chu">
                <h3 class="banner_tieu_de">Trả Góp 0% - Sở Hữu Ngay Siêu Xe!</h3>
                <p class="banner_mo_ta">Hỗ trợ thủ tục vay vốn nhanh chóng trong 15 phút với lãi suất ưu đãi tuyệt đối. Đưa xe về nhà chỉ với 20% giá trị ban đầu.</p>
            </div>
            <a href="#" class="banner_nut">Tư Vấn Ngay</a>
        </div>
    </div>
</div>
<div class="vung_danh_sach_xe">
    <h2 class="tieu_de_muc">Danh Sách Xe Đang Bán</h2>
    <div class="thanh_hang_xe">
        <button class="nut_hang_xe hoat_dong" onclick="locHangXe('tat_ca', this)">Tất cả</button>
        @foreach($danh_sach_hang as $hang)
        <button class="nut_hang_xe" onclick="locHangXe({{ $hang->id }}, this)">{{ $hang->name }}</button>
        @endforeach
    </div>
    <div class="luoi_san_pham">
        @foreach($danh_sach_xe as $xe)
        <div class="the_xe_hoi" data-hang-id="{{ $xe->brand_id }}">
            <img class="khung_hinh_xe" src="{{ asset('Image/' . $xe->featured_image) }}" alt="{{ $xe->name }}">
            <div class="ten_xe_hoi">{{ $xe->name }}</div>
            <p class="gia_xe_hoi">{{ number_format($xe->price, 0, ',', '.') }} đ</p>
            <div class="vung_nut_bam">
                <a href="{{ url('/ChiTietXe/' . $xe->id) }}" class="nut_chi_tiet">Chi Tiết</a>
                <a href="#" class="nut_them">Thêm vào giỏ hàng</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    let chi_so_clip = 0;
    const danh_sach_clip = document.querySelectorAll('.khung_chuyen_clip');
    function cap_nhat_clip(vi_tri_moi) {
        danh_sach_clip[chi_so_clip].classList.remove('hoat_dong');
        danh_sach_clip[chi_so_clip].pause();
        danh_sach_clip[chi_so_clip].currentTime = 0;
        chi_so_clip = vi_tri_moi;
        if (chi_so_clip >= danh_sach_clip.length) { chi_so_clip = 0; }
        if (chi_so_clip < 0) { chi_so_clip = danh_sach_clip.length - 1; }
        danh_sach_clip[chi_so_clip].classList.add('hoat_dong');
        danh_sach_clip[chi_so_clip].play();
    }
    function clipTruoc() { cap_nhat_clip(chi_so_clip - 1); }
    function clipKeTiep() { cap_nhat_clip(chi_so_clip + 1); }
    danh_sach_clip.forEach(clip => {
        clip.addEventListener('ended', clipKeTiep);
    });
    function locHangXe(hangId, nutBam) {
        document.querySelectorAll('.nut_hang_xe').forEach(nut => nut.classList.remove('hoat_dong'));
        nutBam.classList.add('hoat_dong');
        document.querySelectorAll('.the_xe_hoi').forEach(the => {
            if (hangId === 'tat_ca' || the.getAttribute('data-hang-id') == hangId) {
                the.style.display = 'flex';
            } else {
                the.style.display = 'none';
            }
        });
    }
    let chi_so_banner = 0;
    const thanh_truot = document.getElementById('khung_truot_banner');
    function chuyen_banner_tu_dong() {
        chi_so_banner = (chi_so_banner + 1) % 4;
        thanh_truot.style.transform = 'translateX(-' + (chi_so_banner * 25) + '%)';
    }
    setInterval(chuyen_banner_tu_dong, 7500);
</script>
@endsection