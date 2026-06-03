<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new RevenueSheet($this->data),
            new TopCarsSheet($this->data),
        ];
    }
}

// Revenue Sheet
class RevenueSheet implements \Maatwebsite\Excel\Concerns\FromCollection,
                             \Maatwebsite\Excel\Concerns\WithHeadings,
                             \Maatwebsite\Excel\Concerns\WithTitle,
                             \Maatwebsite\Excel\Concerns\WithStyles
{
    protected $data;
    public function __construct($data) { $this->data = $data; }

    public function title(): string { return 'Doanh Thu Theo Tháng'; }
    public function headings(): array { return ['Tháng', 'Doanh Thu (VNĐ)', 'Số Đơn Hàng']; }

    public function collection()
    {
        return collect($this->data['revenue_by_month'])->map(fn($row) => [
            'Tháng ' . $row->month . '/' . $this->data['year'],
            number_format($row->revenue, 0, ',', '.'),
            $row->orders,
        ]);
    }

    public function styles($sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}

// Top Cars Sheet
class TopCarsSheet implements \Maatwebsite\Excel\Concerns\FromCollection,
                            \Maatwebsite\Excel\Concerns\WithHeadings,
                            \Maatwebsite\Excel\Concerns\WithTitle,
                            \Maatwebsite\Excel\Concerns\WithStyles
{
    protected $data;
    public function __construct($data) { $this->data = $data; }

    public function title(): string { return 'Xe Bán Chạy'; }
    public function headings(): array { return ['Tên Xe', 'Hãng', 'Giá (VNĐ)', 'Số Lượng Bán', 'Doanh Thu (VNĐ)']; }

    public function collection()
    {
        return collect($this->data['top_cars'])->map(fn($car) => [
            $car->name,
            $car->brand,
            number_format($car->price, 0, ',', '.'),
            $car->total_sold,
            number_format($car->total_revenue, 0, ',', '.'),
        ]);
    }

    public function styles($sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}