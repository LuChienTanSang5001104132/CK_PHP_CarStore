<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand; // ← THÊM CHÍNH XÁC DÒNG NÀY VÀO ĐÂY

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $brands = [
        ['name' => 'VinFast'],
        ['name' => 'Ferrari'],
        ['name' => 'Lamborghini'],
        ['name' => 'Mercedes-Benz'],
        ['name' => 'BMW'],
        ['name' => 'Audi'],
    ];

    foreach ($brands as $brand) {
        Brand::create($brand);
    }
    }
}