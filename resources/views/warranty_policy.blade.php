@extends('layouts.app')

@section('title', 'Chính Sách Bảo Hành | CarStore')

@section('content')
    <div class="w-full bg-white border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4 py-16">
            <h1 class="text-3xl md:text-4xl font-extrabold text-center text-blue-600 mb-4 uppercase tracking-tight leading-tight">
                Chính Sách Bảo Hành
            </h1>
            <p class="text-center text-gray-500 mb-12 text-lg font-medium">Đảm bảo quyền lợi tối đa - Đồng hành cùng bạn trên mọi nẻo đường</p>
            
            <div class="space-y-6 text-gray-600 leading-relaxed text-justify text-base md:text-lg font-light">
                <p>Kính chào Quý khách hàng, CarStore (thuộc hệ thống Kẹo Dừa Vĩnh Long) vô cùng vinh hạnh khi được Quý khách tin tưởng và lựa chọn làm nơi gửi gắm niềm đam mê tốc độ. Để đảm bảo chiếc xe của Quý khách luôn vận hành trong tình trạng hoàn hảo nhất, chúng tôi thiết lập và áp dụng một hệ thống chính sách bảo hành chính hãng chuẩn quốc tế. Mọi quy định dưới đây được xây dựng dựa trên tiêu chuẩn khắt khe nhất của các thương hiệu xe sang hàng đầu thế giới.</p>
                
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 pt-6 uppercase tracking-tight flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-600 rounded-full inline-block"></span>1. Thời hạn và điều kiện bảo hành cơ bản
                </h3>
                <p>Tất cả các dòng xe mới (New Cars) được phân phối chính thức tại CarStore đều được hưởng chế độ bảo hành tiêu chuẩn kéo dài <strong class="text-gray-900">05 năm hoặc 100.000 km</strong> (tùy thuộc điều kiện nào đến trước), tính từ thời điểm xe được bàn giao chính thức cho khách hàng. Đối với các dòng xe siêu sang và siêu xe đặc biệt, thời hạn bảo hành có thể được nâng lên theo chế độ riêng biệt của từng hãng.</p>
                <p>Bên cạnh đó, đối với các dòng xe điện, cụm pin cao áp (High-Voltage Battery) sẽ được áp dụng chính sách bảo hành độc lập lên đến <strong class="text-gray-900">08 năm hoặc 160.000 km</strong>. Chúng tôi cam kết thay mới hoặc sửa chữa miễn phí nếu dung lượng pin hao hụt xuống dưới 70% trong thời gian bảo hành hợp lệ.</p>
                
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 pt-6 uppercase tracking-tight flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-600 rounded-full inline-block"></span>2. Phạm vi áp dụng bảo hành
                </h3>
                <p>CarStore chịu trách nhiệm bảo hành, sửa chữa hoặc thay thế miễn phí bất kỳ chi tiết, linh kiện nào bị hư hỏng do lỗi vật liệu hoặc lỗi lắp ráp từ phía nhà sản xuất. Phạm vi bảo hành bao gồm nhưng không giới hạn ở:</p>
                <ul class="list-disc pl-6 space-y-2 mt-2 font-medium text-gray-700 marker:text-blue-500">
                    <li>Hệ thống động cơ, hộp số và hệ dẫn động.</li>
                    <li>Hệ thống điện, điện tử và các cảm biến trên xe.</li>
                    <li>Hệ thống làm mát, hệ thống điều hòa nhiệt độ.</li>
                    <li>Khung gầm và hệ thống treo, hệ thống lái.</li>
                    <li>Chính sách chống rỉ sét xuyên thủng thân vỏ (lên đến 10 năm).</li>
                </ul>
                
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 pt-6 uppercase tracking-tight flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-600 rounded-full inline-block"></span>3. Các trường hợp từ chối bảo hành
                </h3>
                <p>Để đảm bảo tính công bằng và tuân thủ nguyên tắc kỹ thuật, chế độ bảo hành sẽ không được áp dụng đối với những trường hợp sau đây:</p>
                <ul class="list-disc pl-6 space-y-2 mt-2 font-medium text-gray-700 marker:text-red-500">
                    <li>Những hư hỏng do hao mòn tự nhiên trong quá trình sử dụng (ví dụ: má phanh, lốp xe, cần gạt nước, các loại bộ lọc, bugi, dây đai truyền động...).</li>
                    <li>Hư hỏng phát sinh do khách hàng không tuân thủ lịch bảo dưỡng định kỳ tại các trung tâm dịch vụ ủy quyền của CarStore.</li>
                    <li>Xe bị thay đổi kết cấu, can thiệp phần mềm (remap động cơ), hoặc lắp đặt các phụ tùng, phụ kiện không chính hãng mà không có sự chấp thuận bằng văn bản từ CarStore.</li>
                    <li>Hư hỏng do tai nạn giao thông, va chạm, hỏa hoạn, ngập nước (thủy kích), hoặc các thảm họa thiên nhiên khác.</li>
                    <li>Sử dụng sai nhiên liệu, dầu nhớt hoặc hóa chất không đúng với khuyến cáo của nhà sản xuất ghi trong sách hướng dẫn sử dụng.</li>
                </ul>
                
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 pt-6 uppercase tracking-tight flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-600 rounded-full inline-block"></span>4. Trách nhiệm của chủ sở hữu
                </h3>
                <p>Để duy trì hiệu lực của sổ bảo hành, Quý khách hàng cần thực hiện đúng và đủ các trách nhiệm sau: Đọc kỹ Sách hướng dẫn sử dụng được giao kèm theo xe; Đảm bảo thực hiện bảo dưỡng định kỳ đúng hạn tại các xưởng dịch vụ của CarStore; Kịp thời mang xe đến kiểm tra ngay khi phát hiện các đèn cảnh báo trên bảng điều khiển hoặc các âm thanh, rung động bất thường. Việc tự ý đưa xe đến các garage bên ngoài không được ủy quyền có thể dẫn đến việc xe bị từ chối bảo hành.</p>
                
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 pt-6 uppercase tracking-tight flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-600 rounded-full inline-block"></span>5. Quy trình tiếp nhận và xử lý bảo hành
                </h3>
                <p>Khi xe gặp sự cố nằm trong phạm vi bảo hành, Quý khách chỉ cần liên hệ ngay với đường dây nóng hỗ trợ 24/7 của CarStore. Đội ngũ chuyên viên sẽ lập tức hướng dẫn xử lý từ xa hoặc điều phối xe cứu hộ chuyên dụng đến đưa xe Quý khách về trung tâm dịch vụ gần nhất hoàn toàn miễn phí. Tại đây, các kỹ sư lành nghề sẽ tiến hành kiểm tra bằng hệ thống máy tính chuyên dụng, xác định lỗi và thông báo phương án khắc phục. Mọi chi phí về nhân công và phụ tùng thay thế thuộc diện bảo hành sẽ do CarStore chi trả 100%.</p>
                
                <div class="mt-12 bg-gray-900 rounded-2xl p-6 text-white shadow-lg">
                    <h3 class="text-lg font-bold uppercase tracking-tight mb-3 flex items-center gap-2 text-blue-400">
                        <i class="fa-solid fa-car-on"></i> Dịch vụ hỗ trợ thay thế phương tiện
                    </h3>
                    <p class="font-light">Đặc biệt, thấu hiểu sự bất tiện của Quý khách khi xe phải nằm xưởng, đối với những ca bảo dưỡng hoặc sửa chữa phức tạp kéo dài hơn 48 giờ, CarStore sẽ cung cấp cho Quý khách một chiếc xe sang trọng tương đương để sử dụng tạm thời (Courtesy Car) trong suốt quá trình chờ đợi.</p>
                    <p class="font-semibold mt-4 text-blue-300">CarStore - Trách nhiệm đến cùng, cam kết dài lâu. Xin trân trọng cảm ơn Quý khách!</p>
                </div>
            </div>
        </div>
    </div>
@endsection