@extends('layout.app')
@section('title', 'Chi Tiết Xe')
@section('header')
<div class="phan_dau">
    <a href="{{ url('/home') }}" class="nut_menu">Trang Chủ</a>
</div>
@endsection
@section('sidebar')
@endsection
@section('footer')
@endsection
@section('content')
<style>
    .khung_chi_tiet { max-width: 1200px; margin: 40px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; gap: 50px; flex-wrap: wrap; }
    .cot_hinh_anh { flex: 1; min-width: 400px; }
    .hinh_xe_chi_tiet { width: 100%; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .cot_thong_tin { flex: 1; min-width: 400px; display: flex; flex-direction: column; }
    .ten_xe_chi_tiet { font-size: 36px; font-weight: bold; margin: 0 0 5px 0; color: #000000; text-transform: uppercase; }
    .hang_xe_chi_tiet { font-size: 18px; color: #6c757d; margin-bottom: 15px; font-weight: bold; letter-spacing: 1px; }
    .gia_xe_chi_tiet { font-size: 32px; font-weight: bold; color: #0056b3; margin-bottom: 25px; border-bottom: 2px solid #eeeeee; padding-bottom: 15px; }
    .tieu_de_bang { font-size: 20px; font-weight: bold; margin-bottom: 15px; color: #000000; }
    .bang_thong_so { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
    .bang_thong_so th, .bang_thong_so td { padding: 12px 0; border-bottom: 1px solid #eeeeee; text-align: left; font-size: 16px; }
    .bang_thong_so th { width: 40%; color: #6c757d; font-weight: normal; }
    .bang_thong_so td { font-weight: bold; color: #333333; }
    .mo_ta_xe { font-size: 16px; line-height: 1.8; color: #444444; margin-bottom: 30px; text-transform: justify; }
    .nut_mua_ngay { background-color: #28a745; color: #ffffff; text-align: center; padding: 18px; font-size: 18px; font-weight: bold; border-radius: 6px; text-decoration: none; transition: background-color 0.2s; border: none; cursor: pointer; text-transform: uppercase; }
    .nut_mua_ngay:hover { background-color: #218838; }
</style>
<div class="khung_chi_tiet">
    <div class="cot_hinh_anh">
        <img class="hinh_xe_chi_tiet" src="{{ asset('Image/' . $xe->featured_image) }}" alt="{{ $xe->name }}">
    </div>
    <div class="cot_thong_tin">
        <h1 class="ten_xe_chi_tiet">{{ $xe->name }}</h1>
        <div class="hang_xe_chi_tiet">HÃNG: {{ $xe->brand_name }}</div>
        <div class="gia_xe_chi_tiet">{{ number_format($xe->price, 0, ',', '.') }} đ</div>
        <div class="tieu_de_bang">Thông Số Kỹ Thuật</div>
        <table class="bang_thong_so">
            <tr><th>Năm sản xuất</th><td>{{ $xe->year }}</td></tr>
            <tr><th>Màu sắc</th><td>{{ $xe->color ?? 'Đang cập nhật' }}</td></tr>
            <tr><th>Kiểu dáng</th><td>{{ $xe->type ?? 'Đang cập nhật' }}</td></tr>
            <tr><th>Nhiên liệu</th><td>{{ $xe->fuel_type ?? 'Đang cập nhật' }}</td></tr>
            <tr><th>Hộp số</th><td>{{ $xe->transmission ?? 'Đang cập nhật' }}</td></tr>
            <tr><th>Động cơ</th><td>{{ $xe->engine_capacity ?? 'Đang cập nhật' }}</td></tr>
            <tr><th>Số chỗ ngồi</th><td>{{ $xe->seats ?? 'Đang cập nhật' }}</td></tr>
            <tr><th>Số km đã đi</th><td>{{ $xe->mileage ? number_format($xe->mileage, 0, ',', '.') . ' km' : 'Xe mới' }}</td></tr>
        </table>
        <div class="tieu_de_bang">Mô Tả Chung</div>
        <div class="mo_ta_xe">{{ $xe->description ?? 'Hiện tại chưa có mô tả chi tiết cho dòng xe này. Vui lòng liên hệ trực tiếp để biết thêm thông tin.' }}</div>
        <button class="nut_mua_ngay">Thêm vào giỏ hàng</button>
    </div>
</div>
@endsection