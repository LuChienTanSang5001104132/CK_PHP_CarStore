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
        Brand::create([
            'name' => 'VinFast',
        ]);
    }
}