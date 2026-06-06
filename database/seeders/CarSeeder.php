<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use Illuminate\Support\Str;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'brand_id'        => 1,
                'name'            => 'VinFast VF8',
                'slug'            => 'vinfast-vf8-' . uniqid(),
                'price'           => 650000000,
                'year'            => 2024,
                'color'           => 'Trắng',
                'type'            => 'SUV',
                'quantity'        => 10,
                'fuel_type'       => 'Điện',
                'transmission'    => 'Tự động',
                'engine_capacity' => 'N/A',
                'seats'           => 5,
                'mileage'         => 0,
                'description'     => 'Xe điện thương hiệu Việt Nam.',
                'status'          => 1,
                'views'           => 0,
            ],
            [
                'brand_id'        => 1,
                'name'            => 'VinFast VF5',
                'slug'            => 'vinfast-vf5-' . uniqid(),
                'price'           => 458000000,
                'year'            => 2024,
                'color'           => 'Đỏ',
                'type'            => 'Hatchback',
                'quantity'        => 8,
                'fuel_type'       => 'Điện',
                'transmission'    => 'Tự động',
                'engine_capacity' => 'N/A',
                'seats'           => 5,
                'mileage'         => 0,
                'description'     => 'Xe điện cỡ nhỏ tiết kiệm.',
                'status'          => 1,
                'views'           => 0,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
