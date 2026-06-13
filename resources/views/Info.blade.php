@extends('layout.app')
@section('title', 'Thông Tin Công Ty')
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
    .khung_bai_viet { max-width: 900px; margin: 40px auto; padding: 50px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); font-family: sans-serif; line-height: 1.8; color: #333333; }
    .tieu_de_chinh { text-align: center; color: #000000; font-size: 32px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
    .duong_ke_ngang { width: 80px; height: 4px; background-color: #0056b3; margin: 0 auto 30px auto; border-radius: 2px; }
    .tieu_de_phu { color: #0056b3; font-size: 22px; margin-top: 35px; margin-bottom: 15px; border-left: 4px solid #0056b3; padding-left: 12px; }
    .doan_van { text-align: justify; margin-bottom: 20px; font-size: 16px; }
    .danh_sach_gia_tri { list-style-type: none; padding: 0; }
    .danh_sach_gia_tri li { margin-bottom: 15px; padding-left: 30px; position: relative; font-size: 16px; text-align: justify; }
    .danh_sach_gia_tri li::before { content: "★"; position: absolute; left: 0; color: #0056b3; font-size: 18px; }
    .chu_in_dam { font-weight: bold; color: #000000; }
</style>
<div class="khung_bai_viet">
    <h1 class="tieu_de_chinh">CÔNG TY KẸO DỪA VĨNH LONG</h1>
    <div class="duong_ke_ngang"></div>
    <p class="doan_van"><span class="chu_in_dam">Công ty Kẹo Dừa Vĩnh Long</span> khởi nguồn từ một khát vọng mang đến sự giao thoa độc đáo giữa nét mộc mạc truyền thống và sự đẳng cấp thượng lưu. Dù mang tên gọi đậm chất quê hương miền Tây, nhưng lĩnh vực hoạt động chủ lực của chúng tôi lại là phân phối các dòng siêu xe và xe hơi hạng sang nhập khẩu chính hãng từ các thương hiệu hàng đầu thế giới như Lamborghini, Ferrari, BMW, Audi, và Vinfast.</p>
    <h2 class="tieu_de_phu">Tầm Nhìn & Sứ Mệnh</h2>
    <p class="doan_van"><span class="chu_in_dam">Tầm nhìn:</span> Trở thành biểu tượng của sự uy tín và đẳng cấp trong lĩnh vực phân phối siêu xe tại Việt Nam, mang đến cho giới tinh hoa những kiệt tác cơ khí bốn bánh không chỉ để di chuyển mà còn để khẳng định vị thế độc tôn.</p>
    <p class="doan_van"><span class="chu_in_dam">Sứ mệnh:</span> Phá vỡ mọi giới hạn về dịch vụ khách hàng. Chúng tôi cam kết cá nhân hóa trải nghiệm của từng quý khách, từ khâu tư vấn chọn xe, trải nghiệm lái thử, cho đến dịch vụ bảo dưỡng chuyên sâu đạt chuẩn toàn cầu.</p>
    <h2 class="tieu_de_phu">Giá Trị Cốt Lõi</h2>
    <ul class="danh_sach_gia_tri">
        <li><span class="chu_in_dam">Đẳng cấp khác biệt:</span> Chỉ cung cấp những sản phẩm hoàn mỹ nhất, đi kèm giấy tờ minh bạch và nguồn gốc xuất xứ rõ ràng.</li>
        <li><span class="chu_in_dam">Tận tâm phục vụ:</span> Khách hàng là trung tâm của mọi hoạt động. Sự hài lòng tuyệt đối của bạn chính là thước đo thành công của chúng tôi.</li>
        <li><span class="chu_in_dam">Bảo dưỡng chuyên nghiệp:</span> Sở hữu đội ngũ kỹ thuật viên được đào tạo trực tiếp từ các hãng xe danh tiếng, trang bị hệ thống máy móc công nghệ cao.</li>
    </ul>
    <h2 class="tieu_de_phu">Cam Kết Của Chúng Tôi</h2>
    <p class="doan_van">Khi bước chân vào showroom của Kẹo Dừa Vĩnh Long, quý khách không chỉ mua một chiếc xe, mà đang đầu tư vào một lối sống đẳng cấp. Chúng tôi cam kết đồng hành cùng quý khách trên mọi nẻo đường, đảm bảo cỗ máy của bạn luôn vận hành trong trạng thái hoàn hảo và an toàn nhất.</p>
</div>
@endsection