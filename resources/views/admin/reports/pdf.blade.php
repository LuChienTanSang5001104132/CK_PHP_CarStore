<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo Cáo Kinh Doanh - CarStore</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        h1 { text-align: center; color: #1e40af; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1e40af; padding-bottom: 10px; }
        .summary { display: flex; justify-content: space-around; margin: 30px 0; }
        .card {
            border: 1px solid #ddd; padding: 15px; border-radius: 8px; 
            text-align: center; width: 30%; background: #f8fafc;
        }
        .card h3 { margin: 5px 0; color: #334155; }
        .card .value { font-size: 24px; font-weight: bold; color: #1e40af; }
        table {
            width: 100%; border-collapse: collapse; margin: 25px 0;
        }
        th, td {
            border: 1px solid #94a3b8; padding: 10px; text-align: left;
        }
        th {
            background-color: #1e40af; color: white;
        }
        .footer {
            text-align: center; margin-top: 50px; color: #64748b; font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BÁO CÁO KINH DOANH</h1>
        <h2>CỬA HÀNG XE HƠI CARSTORE</h2>
        <p>Năm {{ $year }} {{ $month ? '- Tháng ' . $month : '' }} | Xuất lúc: {{ $generated_at }}</p>
    </div>

    <!-- Tổng quan -->
    <div class="summary">
        <div class="card">
            <h3>TỔNG DOANH THU</h3>
            <div class="value">{{ number_format($total_revenue, 0, ',', '.') }} ₫</div>
        </div>
        <div class="card">
            <h3>TỔNG ĐƠN HÀNG</h3>
            <div class="value">{{ number_format($total_orders) }}</div>
        </div>
        <div class="card">
            <h3>TỔNG KHÁCH HÀNG</h3>
            <div class="value">{{ number_format($total_customers) }}</div>
        </div>
    </div>

    <!-- Doanh thu theo tháng -->
    <h3>DOANH THU THEO THÁNG</h3>
    <table>
        <thead>
            <tr>
                <th>Tháng</th>
                <th>Doanh Thu</th>
                <th>Số Đơn Hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenue_by_month as $row)
            <tr>
                <td>Tháng {{ $row->month }} / {{ $year }}</td>
                <td>{{ number_format($row->revenue, 0, ',', '.') }} ₫</td>
                <td>{{ $row->orders }} đơn</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Top xe bán chạy -->
    <h3>TOP XE BÁN CHẠY NHẤT</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Xe</th>
                <th>Hãng</th>
                <th>Giá</th>
                <th>Số Lượng Bán</th>
                <th>Doanh Thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($top_cars as $i => $car)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $car->name }}</td>
                <td>{{ $car->brand }}</td>
                <td>{{ number_format($car->price, 0, ',', '.') }} ₫</td>
                <td>{{ $car->total_sold }} chiếc</td>
                <td>{{ number_format($car->total_revenue, 0, ',', '.') }} ₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Báo cáo được tạo tự động bởi Hệ thống Quản trị CarStore<br>
        {{ $generated_at }}
    </div>
</body>
</html>